<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class PetugasController extends Controller
{
    public function index()
    {
        $data['judul'] = 'Data Petugas';
        $data['petugas'] = User::role(['Petugas', 'KepalaSekolah'])->latest()->get();

        return view('admin.petugas.petugas-index', $data);
    }


    public function create()
    {

        $data['roles'] = Role::where('name', '!=', 'SiswaOrangTua')->get();
        return view('admin.petugas.petugas-create', $data);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
            'jenis_kelamin' => 'required',
            'nip' => 'unique:users'
        ]);


        $user = User::create(
            [
                'nama' => $request->nama,
                'email' => $request->email,
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'nama_wali' => $request->nama_wali,
                'alamat' => $request->alamat,
                'no_telp' => $request->no_telp,
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama' => $request->agama,
                'nip' => $request->nip,
                'status' => $request->status
            ]
        );


        $user->assignRole($request->roles);


        return redirect()->route('petugas.index')->with('success', 'Data petugas baru telah ditambahkan');
    }


    public function show(User $petugas)
    {

        $petugas->load('roles');


        return response()->json($petugas);
    }


    public function edit(User $petugas)
    {
        $roles = Role::where('name', '!=', 'SiswaOrangTua')->get();
        $data['roles'] = $roles;
        $data['petugas'] = $petugas;
        return view('admin.petugas.petugas-edit', $data);
    }
    public function update(Request $request, User $petugas)
    {
        $this->validate($request, [
            'nama' => 'required',
            'username' => 'required|unique:users,username,' . $petugas->id . ',id',
            'email' => 'required|unique:users,email,' . $petugas->id . ',id',
            // 'password' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
            'jenis_kelamin' => 'required',
        ]);

        $password = $request->filled('password') ? bcrypt($request->password) : $petugas->password;

        $petugas->update(
            [
                'nama' => $request->nama,
                'nis' => $request->nis,
                'nisn' => $request->nisn,
                'email' => $request->email,
                'username' => $request->username,
                'password' => $password,
                'nama_wali' => $request->nama_wali,
                'alamat' => $request->alamat,
                'no_telp' => $request->no_telp,
                'angkatan' => $request->angkatan,
                'kelas' => $request->kelas,
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama' => $request->agama,
                'status' => $request->status

            ]
        );


        return redirect()->route('petugas.index')->with('success', 'Data petugas telah diupdate');
    }


    public function destroy(User $petugas)
    {
        $petugas->delete();
        return redirect()->route('petugas.index')->with('success', 'Data siswa telah dihapus');
    }


    public function filterAgama(Request $request)
    {
        if (empty($request->filter_jk)) {
            return response()->json(
                User::with('roles')->role(['Petugas', 'KepalaSekolah'])->latest()->get()
            );
        } else {
            return response()->json(
                User::with('roles')->role(['Petugas', 'KepalaSekolah'])->latest()
                    ->when($request->filled('filter_jk'), function ($query) use ($request) {
                        return $query->where('jenis_kelamin', $request->filter_jk);
                    })
                    ->get()
            );
        }
    }
}
