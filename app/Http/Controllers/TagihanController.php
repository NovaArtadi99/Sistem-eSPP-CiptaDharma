<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Biaya;
use App\Models\Siswa;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use App\Exports\TagihanExport;
use App\Imports\TagihanImport;
use Maatwebsite\Excel\Facades\Excel;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

// require_once base_path('dompdf/autoload.inc.php');
use Dompdf\Dompdf;
use Dompdf\Options;


class TagihanController extends Controller
{

    public function index()
    {
        $data['judul'] = 'Tagihan';
        $data['tagihans'] = Tagihan::with(['siswa', 'biaya', 'penerbit', 'melunasi'])->latest()->get();
        $data['kelas'] = User::role('SiswaOrangTua')->select('id', 'kelas')->get()->unique();


        return view('admin.tagihan.tagihan-index', $data);
    }

    public function create()
    {
        $data['judul'] = 'Tambah Tagihan';
        $data['siswas'] = User::role('SiswaOrangTua')->get();
        $data['biayas'] = Biaya::select('id', 'nama_biaya', 'nominal')->get();

        return view('admin.tagihan.tagihan-create', $data);
    }

    public function store(Request $request)
    {

        // dd($request->all());
        $request->validate([
            'user_id' => 'required',
            'biaya_id' => 'required',
        ], [
            'user_id.required' => 'Siswa harus dipilih',
            'biaya_id.required' => 'Biaya harus dipilih',
        ]);


        $tagihan = new Tagihan();


        if ($request->has('biaya_lain')) {
            $tagihan->no_invoice = $request->no_invoice;
            $tagihan->keterangan = $request->keterangan;
            $tagihan->user_id = $request->user_id;
            $tagihan->bulan = $request->bulan ?? date('m');
            $tagihan->tahun = $request->tahun ?? date('Y');
            $tagihan->tanggal_terbit = $request->tanggal_terbit ?? Carbon::now();
            $tagihan->tanggal_lunas = $request->tanggal_lunas;
            $tagihan->user_penerbit_id = auth()->user()->id;

            $tagihan->biaya_lain = $request->biaya_lain;
            $tagihan->nominal_biaya_lain = $request->nominal_biaya_lain;
        } else {
            $tagihan->no_invoice = $request->no_invoice;
            $tagihan->keterangan = $request->keterangan;
            $tagihan->user_id = $request->user_id;
            $tagihan->bulan = $request->bulan ?? date('m');
            $tagihan->tahun = $request->tahun ?? date('Y');
            $tagihan->tanggal_terbit = $request->tanggal_terbit ?? Carbon::now();
            $tagihan->tanggal_lunas = $request->tanggal_lunas;
            $tagihan->biaya_id = $request->biaya_id;
            $tagihan->user_penerbit_id = auth()->user()->id;
        }


        //new
        $data_tagihan = [
            'no_invoice'     => $request->no_invoice,
            'nama_invoice'   => $request->nama_invoice,
            'user_id'        => $request->user_id,
            'biaya_id'       => $request->biaya_id,
            'bulan'          => $request->bulan,
            'tahun'          => $request->tahun ?? date('Y'),
            'tanggal_terbit' => $request->tanggal_terbit ?? Carbon::now(),
            'tanggal_lunas'  => $request->tanggal_lunas,
        ];


        $tagihan->save();

        // Telegram
        $id_siswa = $request->user_id;
        $user = User::where('id', $id_siswa)->first();
        $biaya = Biaya::where('id', $request->biaya_id)->first();

        $chatId = $user ? $user->chat_id : null;
        if (!$chatId) {
            $chatId = env('TELEGRAM_CHAT_ID');
        }
        $imageData = base64_encode(file_get_contents(public_path('logo_sekolah.png')));
        $imageSrc = 'data:image/png;base64,' . $imageData;

        // Using both variable formats for compatibility with the unified template
        $html = view('invoice_template', [
            'user' => $user,
            'biaya' => $biaya,
            'data_tagihan' => $data_tagihan,
            'imageSrc' => $imageSrc,
            'tagihan' => null // Set to null to indicate we're using the separate variables format
        ])->render();

        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->set_option('isPhpEnabled', true);
        $dompdf->set_option('DOMPDF_ENABLE_REMOTE', true);
        $dompdf->loadHtml($html);
        $dompdf->setPaper([0, 0, 800, 600], 'portrait');
        $dompdf->render();

        $output = $dompdf->output();

        $pdfPath = storage_path('app/public/invoice.pdf');
        file_put_contents($pdfPath, $output);

        $botToken = env('TELEGRAM_BOT_TOKEN');
        $client = new Client();
        $client->post("https://api.telegram.org/bot{$botToken}/sendMessage", [
            'form_params' => [
                'chat_id' => $chatId,
                'text' => "Halo {$user->nama}, berikut adalah invoice {$request->nama_invoice} Anda.",
            ],
        ]);

        // Kirim PDF
        $client->post("https://api.telegram.org/bot{$botToken}/sendDocument", [
            'multipart' => [
                [
                    'name'     => 'chat_id',
                    'contents' => $chatId,
                ],
                [
                    'name'     => 'document',
                    'contents' => fopen($pdfPath, 'r'),
                    'filename' => 'invoice.pdf',
                ],
            ],
        ]);

        unlink($pdfPath);
        // Telegram


        return to_route('tagihan.index')->with('success', 'Tagihan baru ditambahkan');
    }

    public function show(Tagihan $tagihan)
    {
        // return view('admin.tagihan.tagihan-show', $data);

        $tagihan->load(['siswa', 'biaya', 'penerbit', 'melunasi']);
        return response()->json($tagihan);
    }

    public function edit(Tagihan $tagihan)
    {
        $data['judul'] = 'Edit Data Tagihan';
        $data['siswas'] = User::role('SiswaOrangTua')->select('id', 'nama', 'kelas', 'nis')->get();
        $data['biayas'] = Biaya::select('id', 'nama_biaya', 'nominal')->get();
        $data['tagihan'] = $tagihan;
        return view('admin.tagihan.tagihan-edit', $data);
    }

    public function update(Request $request, Tagihan $tagihan)
    {
        $request->validate([
            'user_id' => 'required',
            'biaya_id' => 'required',
        ], [
            'user_id.required' => 'Siswa harus dipilih',
            'biaya_id.required' => 'Biaya harus dipilih',
        ]);


        $tagihan->nama_tagihan = $request->nama_tagihan;
        $tagihan->user_id = $request->user_id;
        $tagihan->biaya_id = $request->biaya_id;
        $tagihan->tanggal_terbit = $request->tanggal_terbit;
        $tagihan->tanggal_lunas = $request->tanggal_lunas;
        $tagihan->biaya_id = $request->biaya_id;
        $tagihan->status = $request->status;
        $tagihan->user_penerbit_id = auth()->user()->id;

        return to_route('tagihan.index')->with('success', 'Tagihan telah diperbarui');
    }

    public function destroy(Tagihan $tagihan)
    {
        $tagihan->delete();
        return to_route('tagihan.index')->with('success', 'Tagihan telah dihapus');
    }


    public function export()
    {
        $tgl = date('d-m-Y_H-i-s');
        return Excel::download(new TagihanExport, 'data_tagihan_' . $tgl . '.xlsx');
    }


    public function import()
    {
        Excel::import(new TagihanImport, request()->file('file'));

        return redirect()->back()->with('success', 'Data tagihan baru telah ditambahkan');
    }



    public function filter(Request $request)
    {
        // dd($request->all());
        if (empty($request->filter_tahun) && empty($request->filter_bulan) && empty($request->filter_angkatan) && empty($request->filter_kelas)) {
            return Tagihan::with(['siswa', 'biaya', 'penerbit', 'melunasi'])->get();
        } else {
            return response()->json(
                Tagihan::with(['biaya', 'siswa', 'penerbit', 'melunasi'])
                    ->when(!empty($request->filter_tahun), function ($query) use ($request) {
                        $query->whereTahun($request->filter_tahun);
                    })
                    ->when(!empty($request->filter_bulan), function ($query) use ($request) {
                        $query->whereBulan($request->filter_bulan);
                    })->when(!empty($request->filter_angkatan), function ($query) use ($request) {
                        return $query->whereHas('siswa', function ($query) use ($request) {
                            $query->where('angkatan', $request->filter_angkatan);
                        });
                    })
                    ->when(!empty($request->filter_kelas), function ($query) use ($request) {
                        return $query->whereHas('siswa', function ($query) use ($request) {
                            $query->where('kelas', $request->filter_kelas);
                        });
                    })
                    ->get()
            );
        }
    }


    public function sendInvoice(Tagihan $tagihan)
    {

        try {
            $tagihan->isSentKuitansi = "1";
            $tagihan->save();
            return response()->json(['success' => 'Kuitansi telah dikirim']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengirim kuitansi', 'message' => $e->getMessage()], 500);
        }
    }


    public function lihatKuitansi(Tagihan $tagihan)
    {
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->setDpi(150);
        $dompdf = new Dompdf($options);

        $dataTagihan = $tagihan->load(['siswa', 'biaya', 'penerbit', 'melunasi']);
        $imageData = base64_encode(file_get_contents(public_path('logo_sekolah.png')));
        $imageSrc = 'data:image/png;base64,' . $imageData;


        $html = view('kwitansi_template', [
            'tagihan' => $dataTagihan,
            'imageSrc' => $imageSrc,
            'bootstrap' => public_path('css/bootstrap.min.css'),
            // Include these for compatibility even though they won't be used
            'user' => null,
            'biaya' => null,
            'data_tagihan' => null
        ])->render();

        $dompdf->loadHtml($html);
        $dompdf->setBasePath(public_path());
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return response()->stream(
            fn() => print($dompdf->output()),
            200,
            ['Content-Type' => 'application/pdf']
        );
    }

    public function downloadKuitansi(Tagihan $tagihan)
    {
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->setDpi(150);
        $dompdf = new Dompdf($options);

        $dataTagihan = $tagihan->load(['siswa', 'biaya', 'penerbit', 'melunasi']);
        $imageData = base64_encode(file_get_contents(public_path('logo_sekolah.png')));
        $imageSrc = 'data:image/png;base64,' . $imageData;

        $html = view('invoice_template', [
            'tagihan' => $dataTagihan,
            'imageSrc' => $imageSrc,
            'bootstrap' => public_path('css/bootstrap.min.css'),
            // Include these for compatibility even though they won't be used
            'user' => null,
            'biaya' => null,
            'data_tagihan' => null
        ])->render();

        $dompdf->loadHtml($html);
        $dompdf->setBasePath(public_path());
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return response()->streamDownload(
            fn() => print($dompdf->output()),
            'kuitansi_' . $tagihan->no_invoice . '.pdf',
            ['Content-Type' => 'application/pdf']
        );
    }
}
