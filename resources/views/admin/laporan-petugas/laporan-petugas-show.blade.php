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
        <label for="">No Telfon</label>
        <input type="number" name="no_telp" class="form-control" value="{{ $petugas->no_telp }}" readonly>
    </div>

    <div class="mb-3">
        <label for="">NIP</label>
        <input type="text" name="nip" class="form-control" value="{{ $petugas->nip }}" readonly>
    </div>

    <div class="mb-3">
        <label for="">SPP Terbit</label>
        <input type="text" name="spp_terbit" class="form-control" value="{{ $petugas->menerbitkan_count }}" readonly>
    </div>

    <div class="mb-3">
        <label for="">SPP Dilunasi</label>
        <input type="text" name="spp_dilunasi" class="form-control" value="{{ $petugas->melunasi_count }}" readonly>
    </div>

    <a href="{{ url()->previous() }}" class="btn btn-primary">Kembali</a>
@endsection
