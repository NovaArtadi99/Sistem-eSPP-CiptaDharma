<?php

namespace App\Http\Controllers;

use App\Exports\LaporanSPPExport;
use App\Imports\LaporanSPPImport;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanSPPController extends Controller
{
    public function index()
    {
        $data['judul'] = 'Laporan Data SPP';
        $data['laporan_spp'] = Tagihan::with('siswa')->whereStatus('Lunas')->latest()->get();

        // dd($data);
        return view('admin.laporan-spp.laporan-spp-index', $data);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'nis' => 'required|unique:users',
            'nisn' => 'required|unique:users',
            'email' => 'required|unique:users',
            'password' => 'required',
            'nama_wali' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
            'angkatan' => 'required',
            'kelas' => 'required',
            'jenis_kelamin' => 'required',
        ]);




        return redirect()->route('siswa.index')->with('success', 'Data siswa baru telah ditambahkan');
    }


    public function show(Tagihan $laporan_spp)
    {
        $laporan_spp->load(['siswa', 'biaya']);
        return response()->json($laporan_spp);
        // return view('admin.laporan-spp.laporan-spp-show', compact('laporan_spp'));
    }


    public function edit(Tagihan $laporan_spp)
    {
        return view('admin.petugas.petugas-edit', compact('siswa'));
    }


    public function destroy(Tagihan $laporan_spp)
    {
        $laporan_spp->delete();
        return redirect()->route('laporanPetugas.index')->with('success', 'Data spp telah dihapus');
    }

    public function filter(Request $request)
    {
        if (empty($request->filter_tahun) && empty($request->filter_bulan) && empty($request->filter_tanggal_awal) && empty($request->filter_tanggal_akhir)) {
            return Tagihan::with(['siswa','biaya'])->whereStatus('Lunas')->latest()->get();
        } else {
            return response()->json(
                Tagihan::with(['siswa','biaya'])
                    ->whereStatus('Lunas')
                    ->when(!empty($request->filter_tahun), function ($query) use ($request) {
                        $query->whereTahun($request->filter_tahun);
                    })
                    ->when(!empty($request->filter_bulan), function ($query) use ($request) {
                        $query->whereBulan($request->filter_bulan);
                    })->when(!empty($request->filter_tanggal_awal) && !empty($request->filter_tanggal_akhir), function ($query) use ($request) {
                        $query->whereBetween('tanggal_lunas', [$request->filter_tanggal_awal, $request->filter_tanggal_akhir]);
                    })
                    ->latest()
                    ->get()
            );
        }
    }


    public function export(Request $request)
    {
        $filterTahun = $request->query('filter_tahun');
        $filterBulan = $request->query('filter_bulan');
        $filterTanggalAwal = $request->query('filter_tanggal_awal');
        $filterTanggalAkhir = $request->query('filter_tanggal_akhir');
        $tgl = date('d-m-Y_H-i-s');
        return Excel::download(new LaporanSPPExport($filterTahun, $filterBulan, $filterTanggalAwal, $filterTanggalAkhir), 'laporan_spp_' . $tgl . '.xlsx');
    }


    public function import(Request $request)
    {
        // dd($request->all());
        Excel::import(new LaporanSPPImport, $request->file('file'));
        return redirect()->back()->with('success', 'Data laporan SPP baru telah ditambahkan');
    }


    public function print()
    {
        $laporan_spp = Tagihan::with('siswa')->latest()->get();
        $pdf = PDF::loadview('admin.pdf.laporan-spp-pdf', compact('laporan_spp'))
            ->setPaper('a4', 'landscape');
        $tgl = date('d-m-Y_H-i`-s');
        return $pdf->stream('siswa' . $tgl . '.pdf');
    }
}
