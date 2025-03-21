<?php

namespace App\Http\Controllers;

use App\Models\Biaya;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BiayaController extends Controller
{

    public function index()
    {
        $data['biayas'] = Biaya::select('id','nama_biaya', 'nominal','nama_nominal', 'tahun', 'bulan', 'level')->latest()->get();
        $data['judul'] = 'Data Biaya';

        return view('admin.biaya.biaya-index', $data);
    }

    public function create()
    {
        $data['judul'] = 'Tambah Data Biaya';

        return view('admin.biaya.biaya-create', $data);
    }

    public function store(Request $request)
    {

        // dd($request->tahun);
        $tahun = Carbon::parse($request->tahun)->format('Y');
        // dd($tahun);
        $this->validate($request, [
            'nama_biaya' => 'required',
            'nominal' => 'required|numeric',
            'tahun' => 'required',
            'bulan' => 'required',
            'level' => 'required',
        ]);

        $biaya = new Biaya();
        $biaya->nama_biaya = $request->nama_biaya;
        $biaya->nominal = $request->nominal;
        $biaya->nama_nominal = $request->nama_nominal;
        $biaya->tahun = $tahun;
        $biaya->bulan = $request->bulan;
        $biaya->level = $request->level;
        $biaya->save();

        return to_route('biaya.index')->with('success', 'Data biaya baru telah ditambahkan');
    }

    public function show(Biaya $biaya)
    {
        // $biaya = Biaya::find($biaya);


        return response()->json($biaya);
    }


    public function edit(Biaya $biaya)
    {
        $data['biaya'] = $biaya;
        $data['judul'] = 'Edit Data Biaya';

        return view('admin.biaya.biaya-edit', $data);
    }

    public function update(Request $request, Biaya $biaya)
    {
        $tahun = Carbon::parse($request->tahun)->format('Y');
        // dd($tahun);
        $this->validate($request, [
            'nama_biaya' => 'required',
            'nominal' => 'required|numeric',
            'tahun' => 'required',
            'bulan' => 'required',
            'level' => 'required',
        ]);
        $biaya->nama_biaya = $request->nama_biaya;
        $biaya->nominal = $request->nominal;
        $biaya->nama_nominal = $request->nama_nominal;
        $biaya->tahun = $tahun;
        $biaya->bulan = $request->bulan;
        $biaya->level = $request->level;
        $biaya->save();

        return to_route('biaya.index')->with('success', 'Data biaya baru telah diperbarui');
    }

    public function destroy(Biaya $biaya)
    {

        $biaya->delete();
        return redirect()->route('biaya.index')->with('success', 'Data biaya telah dihapus');
    }

    public function filter(Request $request)
    {



        if(empty($request->filter_tahun) && empty($request->filter_bulan)){
           return Biaya::get();
        } else {
            return response()->json(
                Biaya::when(!empty($request->filter_tahun), function ($query) use ($request) {
                        $query->where('tahun', $request->filter_tahun);
                    })
                    ->when(!empty($request->filter_bulan), function ($query) use ($request) {
                        $query->where('bulan', $request->filter_bulan);
                    })
                    ->get()
            );
        }

    }
}
