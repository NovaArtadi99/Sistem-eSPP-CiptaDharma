@extends('admin.admin-layout')
@section('content')
    <div class="mb-3">
        <label for="">Nama petugas</label>
        <input type="text" name="nama" class="form-control" value="{{ $petugas->nama }}" readonly>
    </div>

    <div class="mb-3">
        <label for="">Jabatan petugas</label> <br>
        <div class="my-1">
            @foreach ($petugas->roles as $role)
            <button class="btn btn-sm btn-primary">{{ $role->name }}</button>
        @endforeach
        </div>

    </div>


    <div class="mb-3">
        <label for="">Email</label>
        <input type="email" name="email" class="form-control" value="{{ $petugas->email }}" readonly>
    </div>

    <div class="mb-3">
        <label for="">Password</label>
        <input type="password" name="password" class="form-control" value="{{ $petugas->password }}" readonly>
    </div>

    <div class="mb-3">
        <label for="">Jenis Kelamin</label>
        <select type="text" name="jenis_kelamin" id="jenis_kelamin" class="form-control" required disabled>
            <option value="Laki-laki" {{ $petugas->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
            <option value="Perempuan" {{ $petugas->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="">Alamat</label>
        <input type="text" name="alamat" class="form-control" value="{{ $petugas->alamat }}" readonly>
    </div>

    <div class="mb-3">
        <label for="">Agama</label>
        <input type="text" name="alamat" class="form-control" value="{{ $petugas->agama }}" readonly>

    </div>

    <div class="mb-3">
        <label for="">No Telfon</label>
        <input type="number" name="no_telp" class="form-control" value="{{ $petugas->no_telp }}" readonly>
    </div>


    <a href="{{ url()->previous() }}" class="btn btn-primary">Kembali</a>
@endsection
