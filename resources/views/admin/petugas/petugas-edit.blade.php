@extends('admin.admin-layout')
@section('content')
    <form action="{{ route('petugas.update', $petugas->id) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf

        <div class="mb-3">
            <label for="">Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" value="{{ $petugas->nama }}" required autocomplete="on">
        </div>

        <div class="mb-3">
            <label for="">Email</label>
            <input type="email" name="email" class="form-control" value="{{ $petugas->email }}" required autocomplete="on">
        </div>

        <div class="mb-3">
            <label for="">Username</label>
            <input type="text" name="username" class="form-control" value="{{ $petugas->username }}" required autocomplete="on">
        </div>

        <div class="mb-3">
            <label for="">Jabatan petugas</label>
            <select name="roles" class="form-control" required>
                <option value="">Pilih Jabatan</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}" {{ $petugas->roles->first()->name == $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="">NIP</label>
            <input type="number" name="nip" class="form-control" value="{{ $petugas->nip }}" required autocomplete="on">
        </div>

        <div class="mb-3">
            <label for="">Agama</label>
            <select name="agama" id="" class="form-control" required>
                <option value="Islam" {{ $petugas->agama == 'Islam' ? 'selected' : '' }}>Islam</option>
                <option value="Kristen" {{ $petugas->agama == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                <option value="Katolik" {{ $petugas->agama == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                <option value="Hindu" {{ $petugas->agama == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                <option value="Budha" {{ $petugas->agama == 'Budha' ? 'selected' : '' }}>Budha</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="">Password</label>
            <input type="password" name="password" class="form-control" >
        </div>

        <div class="mb-3">
            <label for="">Jenis Kelamin</label>
            <select type="text" name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                <option value="Laki-laki" {{ $petugas->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ $petugas->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="">Alamat</label>
            <input type="text" name="alamat" class="form-control" value="{{ $petugas->alamat }}" required autocomplete="on">
        </div>

        <div class="mb-3">
            <label for="">No Telfon</label>
            <input type="number" name="no_telp" class="form-control" value="{{ $petugas->no_telp }}" required autocomplete="on">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
