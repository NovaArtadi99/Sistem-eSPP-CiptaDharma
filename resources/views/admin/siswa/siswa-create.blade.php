@extends('admin.admin-layout')
@section('content')
    <form action="{{ route('siswa.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="">Nama Siswa</label>
            <input type="text" name="nama" class="form-control" required autocomplete="on" value="{{ old('nama', '') }}">
        </div>
        {{-- <div class="mb-3">
            <label for="">Username</label>
            <input type="text" name="username" class="form-control" required autocomplete="on" value="{{ old('username', '') }}">
        </div> --}}
       <div class="mb-3">
    <label for="">Kelas</label>
    <select name="kelas" id="" class="form-control" autocomplete="on">
        @for ($kelas = 1; $kelas <= 6; $kelas++)
            @php
                $rangeHuruf = $kelas <= 2 ? range('A', 'D') : range('A', 'E');
            @endphp
            @foreach ($rangeHuruf as $huruf)
                <option value="{{ $kelas . $huruf }}" {{ old('kelas', '') == $kelas . $huruf ? 'selected' : '' }}>
                    {{ $kelas . ' - ' . $huruf }}
                </option>
            @endforeach
        @endfor
    </select>
</div>


        <div class="mb-3">
            <label for="">Angkatan</label>
            <select name="angkatan" id="" class="form-control" autocomplete="on" value="{{ old('angkatan', '') }}">
                @for ($kelas = 2019; $kelas <= 2024; $kelas++)
                    <option value="{{ $kelas }}" {{ old('angkatan', '') == $kelas ? 'selected' : '' }}>{{ $kelas  }}</option>
                @endfor
            </select>
        </div>


        <div class="mb-3">
            <label for="">NIS</label>
            <input type="number" name="nis" class="form-control" required autocomplete="on" value="{{ old('nis', '') }}">
        </div>

        <div class="mb-3">
            <label for="">NISN</label>
            <input type="number" name="nisn" class="form-control" required autocomplete="on" value="{{ old('nisn', '') }}">
        </div>

        <div class="mb-3">
            <label for="">Email</label>
            <input type="email" name="email" class="form-control" required autocomplete="on" value="{{ old('email', '') }}">
        </div>

        <div class="mb-3">
            <label for="">Password</label>
            <input type="password" name="password" class="form-control" required autocomplete="on" value="{{ old('password', '') }}">
        </div>

        <div class="mb-3">
            <label for="">Jenis Kelamin</label>
            <select type="text" name="jenis_kelamin" id="jenis_kelamin" class="form-control" required autocomplete="on" value="{{ old('jenis_kelamin', '') }}">
                <option value="Laki-laki" {{ old('jenis_kelamin', '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('jenis_kelamin', '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="">Alamat</label>
            <input type="text" name="alamat" class="form-control" required autocomplete="on" value="{{ old('alamat', '') }}">
        </div>

        <div class="mb-3">
            <label for="">Agama</label>
            <select name="agama" id="" class="form-control" required autocomplete="on" value="{{ old('agama', '') }}">
                <option value="Islam" {{ old('agama', '') == 'Islam' ? 'selected' : '' }}>Islam</option>
                <option value="Kristen" {{ old('agama', '') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                <option value="Katolik" {{ old('agama', '') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                <option value="Hindu" {{ old('agama', '') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                <option value="Budha" {{ old('agama', '') == 'Budha' ? 'selected' : '' }}>Budha</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="">No Telepon</label>
            <input type="number" name="no_telp" class="form-control" required autocomplete="on" value="{{ old('no_telp', '') }}">
        </div>

        <div class="mb-3">
            <label for="">Nama Orang Tua</label>
            <input type="text" name="nama_wali" class="form-control" required autocomplete="on" value="{{ old('nama_wali', '') }}">
        </div>

        <div class="mb-3">
            <label for="">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="form-control" required autocomplete="on" value="{{ old('tanggal_lahir', '') }}">
        </div>


        <div class="mb-3 d-flex justify-content-start gap-2">
            <button type="submit" class="btn btn-success">Kirim</button>
            <a href="{{ route('siswa.index') }}" class="btn btn-primary">Batal</a>
        </div>
    </form>
@endsection
