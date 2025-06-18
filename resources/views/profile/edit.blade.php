@extends('admin.admin-layout')
@section('content')
    <form action="{{ route('profile.update',$user->id) }}" method="POST">
        @method('PUT')
        @csrf
        <div class="mb-3">
            <label for="">Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ $user->nama }}" required>
        </div>

        <div class="mb-3">
            <label for="">Email</label>
            <input type="text" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>

        <div class="mb-3">
            <label for="">Password</label>
            <input type="text" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label for="">Nomor Telepon</label>
            <input type="text" name="no_telp" class="form-control" value="{{ $user->no_telp }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Kirim</button>
    </form>



@endsection
