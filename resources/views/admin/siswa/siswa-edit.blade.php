@extends('admin.admin-layout')
@section('content')
    <form action="{{ route('siswa.update', $siswa->id) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf

        <div class="mb-3">
            <label for="">Nama Siswa</label>
            <input type="text" name="nama" class="form-control" value="{{ $siswa->nama }}" required>
        </div>

        {{-- <div class="mb-3">
            <label for="">Username</label>
            <input type="text" name="username" class="form-control" value="{{ $siswa->username }}" required>
        </div> --}}

        <div class="mb-3">
            <label for="">Kelas</label>
            <select name="kelas" id="" class="form-control" required>
                @for ($kelas = 1; $kelas <= 6; $kelas++)
                    @foreach (range('A', 'E') as $huruf)
                        <option value="{{ $kelas . $huruf }}" {{ $siswa->kelas == $kelas . $huruf ? 'selected' : '' }}>
                            {{ $kelas . ' - ' . $huruf }}</option>
                    @endforeach
                @endfor
            </select>
        </div>

        <div class="mb-3">
            <label for="">Angkatan</label>
            <select name="angkatan" id="" class="form-control" required>
                @for ($kelas = 2015; $kelas <= 2024; $kelas++)
                    <option value="{{ $kelas }}" {{ $siswa->angkatan == $kelas ? 'selected' : '' }}>
                        {{ $kelas }}</option>
                @endfor
            </select>
        </div>


        <div class="mb-3">
            <label for="">NIS</label>
            <input type="text" name="nis" class="form-control" value="{{ $siswa->nis }}" required>
        </div>

        <div class="mb-3">
            <label for="">NISN</label>
            <input type="text" name="nisn" class="form-control" value="{{ $siswa->nisn }}" required>
        </div>

        <div class="mb-3">
            <label for="">Email</label>
            <input type="email" name="email" class="form-control" value="{{ $siswa->email }}" required>
        </div>

        <div class="mb-3">
            <label for="">Password</label>
            <input type="password" name="password" class="form-control">
        </div>

        {{-- <div class="mb-3">
            <label for="">Nama Wali</label>
            <input type="text" name="nama_wali" class="form-control" value="{{ $siswa->nama_wali }}" required>
        </div> --}}

        <div class="mb-3">
            <label for="">Alamat</label>
            <input type="text" name="alamat" class="form-control" value="{{ $siswa->alamat }}" required>
        </div>

        <div class="mb-3">
            <label for="">No Telepon</label>
            <input type="text" name="no_telp" class="form-control" value="{{ $siswa->no_telp }}" required>
        </div>

        <div class="mb-3">
            <label for="">Angkatan</label>
            <input type="number" name="angkatan" class="form-control" value="{{ $siswa->angkatan }}" required>
        </div>
        <div class="mb-3">
            <label for="">Kelas</label>
            <select name="kelas" id="" class="form-control" autocomplete="on" value="{{ old('kelas', '') }}">
                @for ($kelas = 1; $kelas <= 6; $kelas++)
                    @foreach (range('A', 'E') as $huruf)
                        <option value="{{ $kelas . $huruf }}" {{ old('kelas', '') == $kelas . $huruf ? 'selected' : '' }}>
                            {{ $kelas . ' - ' . $huruf }}</option>
                    @endforeach
                @endfor
            </select>
        </div>
        <div class="mb-3">
            <label for="">Jenis Kelamin</label>
            <select type="text" name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                <option value="Laki-laki" @if ($siswa->jenis_kelamin == 'Laki-laki') selected @endif>Laki-laki</option>
                <option value="Perempuan" {{ $siswa->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="">Alamat</label>
            <input type="text" name="alamat" class="form-control" value="{{ $siswa->alamat }}" required>
        </div>

        <div class="mb-3">
            <label for="">Agama</label>
            <select name="agama" class="form-control" required>
                <option value="Islam" @if ($siswa->agama == 'Islam') selected @endif>Islam</option>
                <option value="Kristen" @if ($siswa->agama == 'Kristen') selected @endif>Kristen</option>
                <option value="Katolik" @if ($siswa->agama == 'Katolik') selected @endif>Katolik</option>
                <option value="Hindu" @if ($siswa->agama == 'Hindu') selected @endif>Hindu</option>
                <option value="Budha" @if ($siswa->agama == 'Budha') selected @endif>Budha</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="">Nama Orang Tua</label>
            <input type="text" name="nama_wali" class="form-control" value="{{ $siswa->nama_wali }}" required>
        </div>

        <div class="mb-3">
            <label for="">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="form-control" value="{{ $siswa->tanggal_lahir }}">
        </div>


        <div class="mb-3 d-flex justify-content-start gap-2">
            <button type="submit" class="btn btn-success">Kirim</button>
            <a href="{{ route('siswa.index') }}" class="btn btn-primary">Batal</a>
        </div>
    </form>

@endsection
