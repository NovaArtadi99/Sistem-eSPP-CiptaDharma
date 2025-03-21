<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\User;
use Illuminate\Http\Request;

class LaporanSiswaController extends Controller
{
    public function index()
    {
        $data['judul'] = 'Laporan Data Siswa';
        $data['laporan_siswa'] = Tagihan::with('siswa')->latest()->get();

        // dd($data);
        return view('admin.laporan-siswa.laporan-siswa-index', $data);
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


        User::create(
            [
                'nama' => $request->nama,
                'nis' => $request->nis,
                'nisn' => $request->nisn,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'nama_wali' => $request->nama_wali,
                'alamat' => $request->alamat,
                'no_telp' => $request->no_telp,
                'angkatan' => $request->angkatan,
                'kelas' => $request->kelas,
                'jenis_kelamin' => $request->jenis_kelamin,
            ]
        );


        return redirect()->route('siswa.index')->with('success', 'Data siswa baru telah ditambahkan');
    }


    public function show(Tagihan $laporan_siswa)
    {
        $laporan_siswa->load('siswa', 'biaya', 'penerbit', 'melunasi')->find($laporan_siswa->id);

        return response()->json($laporan_siswa);
        // return view('admin.laporan-siswa.laporan-siswa-show', compact('laporan_siswa'));
    }


    public function edit(Tagihan $petugas)
    {
        return view('admin.petugas.petugas-edit', compact('siswa'));
    }


    public function destroy(Tagihan $laporan_siswa)
    {
        $laporan_siswa->delete();
        return redirect()->route('siswa.index')->with('success', 'Data siswa telah dihapus');
    }

    public function filter(Request $request)
    {
        // dd($request->all());
        if (empty($request->filter_angkatan) && empty($request->filter_kelas) && empty($request->filter_status) && empty($request->filter_tahun) && empty($request->filter_bulan)) {
            return response()->json(
                Tagihan::whereMonth('created_at', date('m'))->with('siswa')->latest()->get()
            );
        } else {
            // dd($request->all());
            return response()->json(
                Tagihan::with('siswa')
                    ->when(!empty($request->filter_tahun), function ($query) use ($request) {
                        $query->whereTahun($request->filter_tahun);
                    })
                    ->when(!empty($request->filter_bulan), function ($query) use ($request) {
                        $query->whereBulan($request->filter_bulan);
                    })
                    ->when($request->filter_kelas != null, function ($query) use ($request) {
                        return $query->whereHas('siswa', function ($query) use ($request) {
                            $query->where('kelas', $request->filter_kelas);
                        });
                    })
                    ->when($request->filter_angkatan != null, function ($query) use ($request) {
                        return $query->whereHas('siswa', function ($query) use ($request) {
                            $query->where('angkatan', $request->filter_angkatan);
                        });
                    })
                    ->when(!empty($request->filter_status), function ($query) use ($request) {
                        $query->where('status', $request->filter_status);
                    })
                    ->get()
            );
        }
    }
}
