@extends('admin.admin-layout')
@section('content')
    <div class="mb-3">
        <label for="">No Invoice</label>
        <input type="text" name="no_invoice" class="form-control" value="{{ $laporan_siswa->no_invoice }}" readonly>
    </div>

    <div class="mb-3">
        <label for="">Keterangan</label>
        <input type="text" name="keterangan" class="form-control" value="{{ $laporan_siswa->keterangan }}" readonly>
    </div>

    <div class="mb-3">
        <label for="">Tanggal Terbit</label>
        <input type="date" name="tanggal_terbit" class="form-control" value="{{ $laporan_siswa->tanggal_terbit }}" readonly>
    </div>

    <div class="mb-3">
        <label for="">Tanggal Lunas</label>
        <input type="date" name="tanggal_lunas" class="form-control" value="{{ $laporan_siswa->tanggal_lunas ?? '' }}" readonly>
    </div>


    <div class="mb-3">
        <label for="">Status</label>
        <input type="text" name="status" class="form-control" value="{{ $laporan_siswa->status }}" readonly>
    </div>

    <div class="mb-3">
        <label for="">User Penerbit</label>
        <input type="text" name="user_penerbit_id" class="form-control" value="{{ $laporan_siswa->penerbit->nama }}" readonly>
    </div>

    <div class="mb-3">
        <label for="">User Melunasi</label>
        <input type="text" name="user_melunasi_id" class="form-control" value="{{ $laporan_siswa->melunasi->nama ?? 'Belum Dilunasi' }}" readonly>
    </div>

    <div class="mb-3">
        <label for="">Biaya</label>
        <input type="text" name="biaya_id" class="form-control" value="{{ $laporan_siswa->biaya->nama_biaya }}" readonly>
    </div>

    <div class="mb-3">
        <label for="">User</label>
        <input type="text" name="user_id" class="form-control" value="{{ $laporan_siswa->siswa->nama }}" readonly>
    </div>

    <div class="mb-3">
        <label for="">Bulan</label>
        <input type="text" name="bulan" class="form-control" value="{{ $laporan_siswa->bulan }}" readonly>
    </div>

    <div class="mb-3">
        <label for="">Tahun</label>
        <input type="text" name="tahun" class="form-control" value="{{ $laporan_siswa->tahun }}" readonly>
    </div>

    <div class="mb-3">
        <label for="">Status</label>
        <div class="d-grid">
            <button class="btn {{ $laporan_siswa->status == 'Belum Lunas' ? 'btn-danger' : 'btn-success' }}">{{ $laporan_siswa->status == 'Belum Lunas' ? 'Belum Lunas' : 'Lunas' }}</button>
        </div>
    <div class="mb-3">
        <label for="">Bukti Pelunasan</label>
        <a href="{{ url('storage/' . $laporan_siswa->bukti_pelunasan) }}" target="_blank" >
            <div class="">
                <img src="{{ url('storage/' . $laporan_siswa->bukti_pelunasan) }}" alt="" width="100" height="100">

            </div>
           </a>
    </div>


    <a href="{{ url()->previous() }}" class="btn btn-primary">Kembali</a>
@endsection
