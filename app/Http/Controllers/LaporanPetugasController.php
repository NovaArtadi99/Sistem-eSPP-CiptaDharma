<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class LaporanPetugasController extends Controller
{
    public function index()
    {
        $data['judul'] = 'Laporan Data Petugas';
        $data['laporan_petugas'] = User::role(['Petugas', 'KepalaSekolah'])->withCount('menerbitkan')->withCount('melunasi')->latest()->get();


        // dd($data);
        return view('admin.laporan-petugas.laporan-petugas-index', $data);
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


    public function show(User $petugas)
    {
        $petugas->load(['roles','menerbitkan','melunasi']);
        $petugas->menerbitkan_count = $petugas->menerbitkan->count();
        $petugas->melunasi_count = $petugas->melunasi->count();
        // dd($petugas);
        return view('admin.laporan-petugas.laporan-petugas-show', compact('petugas'));
    }


    public function filter(Request $request)
    {
        // dd($request->all());
        if (empty($request->filter_tahun) && empty($request->filter_bulan) && empty($request->filter_angkatan) && empty($request->filter_kelas)) {
            return User::with('roles')->withCount('menerbitkan')->role(['Petugas', 'KepalaSekolah'])->latest()->get();
        } else {
            return response()->json(
                User::with('roles')->withCount('menerbitkan')->role(['Petugas', 'KepalaSekolah'])
                    ->when(!empty($request->filter_tahun), function ($query) use ($request) {
                        $query->whereYear('created_at', $request->filter_tahun);
                    })
                    ->when(!empty($request->filter_bulan), function ($query) use ($request) {
                        $query->whereMonth('created_at', $request->filter_bulan);
                    })->when($request->filter_angkatan != null, function ($query) use ($request) {
                        return $query->whereHas('siswa', function ($query) use ($request) {
                            $query->where('angkatan', $request->filter_angkatan);
                        });
                    })
                    ->get()
            );
        }
    }
}
