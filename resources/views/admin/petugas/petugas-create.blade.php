@extends('admin.admin-layout')
@section('content')
    <form action="{{ route('petugas.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="">Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" required autocomplete="on" value="{{ old('nama', '') }}">
        </div>

        <div class="mb-3">
            <label for="">NIK</label>
            <input type="number" name="nip" class="form-control" required autocomplete="on"
                value="{{ old('nip', '') }}">
        </div>

        <div class="mb-3">
            <label for="">Jabatan Petugas</label>
            <select name="roles" class="form-control" required>
                <option value="">Pilih Jabatan</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                @endforeach

            </select>
        </div>

        {{-- <div class="mb-3">
            <label for="">Username</label>
            <input type="text" name="username" class="form-control" required autocomplete="on"
                value="{{ old('username', '') }}">
        </div> --}}


        <div class="mb-3">
            <label for="">Email</label>
            <input type="email" name="email" class="form-control" required autocomplete="on"
                value="{{ old('email', '') }}">
        </div>

        <div class="mb-3">
            <label for="">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="">Jenis Kelamin</label>
            <select type="text" name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </div>



        <div class="mb-3">
            <label for="">Alamat</label>
            <input type="text" name="alamat" class="form-control" required autocomplete="on"
                value="{{ old('alamat', '') }}">
        </div>

        <div class="mb-3">
            <label for="">No Telepon</label>
            <input type="number" name="no_telp" class="form-control" required autocomplete="on"
                value="{{ old('no_telp', '') }}">
        </div>


        <div class="mb-3">
            <label for="">Agama</label>
            <select name="agama" id="" class="form-control" required>
                <option value="Islam">Islam</option>
                <option value="Kristen">Kristen</option>
                <option value="Katolik">Katolik</option>
                <option value="Hindu">Hindu</option>
                <option value="Budha">Budha</option>
            </select>
        </div>


        <div class="mb-3">
            <label for="">Status</label>
            <select name="is_aktif" id="" class="form-control" required>
                <option value="1">Aktif</option>
                <option value="0">Tidak Aktif</option>
            </select>
        </div>



        <div class="mb-3 d-flex justify-content-start gap-2">
            <button type="submit" class="btn btn-success">Kirim</button>
            <a href="{{ route('petugas.index') }}" class="btn btn-primary">Batal</a>
        </div>
    </form>
@endsection
