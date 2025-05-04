<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;

class ProfilController extends Controller
{
    public function index()
    {
        $data['judul'] = 'Data Profile';
        
        $data['user'] = User::find(Auth::user()->id);

        return view('profile.editt', $data);
    }

    public function update(Request $request, User $user)
    {
        $data['judul'] = 'Data Profile';
        $password = $request->filled('password') ? bcrypt($request->password) : $user->password;

        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => $password,
            'no_telp' => $request->no_telp,
        ]);

        return redirect()->route('profil.index')->with('success', 'Data telah diupdate');

    }
}
