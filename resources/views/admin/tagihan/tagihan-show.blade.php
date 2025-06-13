{{-- @extends('admin.admin-layout')
@section('content')
    <form>
        <div class="mb-3">
            <label for="">Nomor Invoice</label>
            <input type="text" name="no_invoice" class="form-control" value="{{ $tagihan->no_invoice }}" readonly>
        </div>

        <div class="mb-3">
            <label for="">Nama Tagihan</label>
            <input type="text" name="keterangan" class="form-control" value="{{ $tagihan->keterangan }}" readonly>
        </div>

        <div class="mb-3">
            <label for="">Biaya</label>
            <input type="text" name="biaya_id" class="form-control" value="{{ $tagihan->biaya->nama_biaya }} - Rp.{{ number_format($tagihan->biaya->nominal) }}" readonly>
        </div>

        <div class="mb-3">
            <label for="">Siswa</label>
            <input type="text" name="user_id" class="form-control" value="{{ $tagihan->siswa->nama }} - Kelas {{ $tagihan->siswa->kelas }}" readonly>
        </div>

        <div class="mb-3">
            <label for="">Tanggal Terbit</label>
            <input type="date" name="tanggal_terbit" class="form-control" value="{{ $tagihan->tanggal_terbit ?? date('Y-m-d') }}" readonly>
        </div>

        <div class="mb-3">
            <label for="">Tanggal Lunas</label>
            <input type="date" name="tanggal_lunas" class="form-control" value="{{ $tagihan->tanggal_lunas }}" readonly>
        </div>

        <div class="mb-3">
            <label for="">Status Pelunasan</label>
            <select name="status" class="form-control" disabled>
                <option value="Belum Lunas" {{ $tagihan->status == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                <option value="Lunas" {{ $tagihan->status == 'Lunas' ? 'selected' : '' }}>Lunas</option>
            </select>
        </div>

        <a href="{{ url()->previous() }}" class="btn btn-primary">Kembali</a>
    </form>
@endsection

@push('scrirpts')

@endpush --}}
