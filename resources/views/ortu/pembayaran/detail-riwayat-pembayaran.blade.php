@extends('admin.admin-layout-ortu')
@section('content')
    <div class="card">
        <div class="card-body py-4">
            <div class="mb-4">
                <p class="mb-2"><strong>No Invoice:</strong> {{ $pembayaran->no_invoice ?? '2234445' }}</p>
                <p class="mb-2"><strong>Nama Siswa:</strong> {{ $pembayaran->siswa->nama ?? 'Ruslan Ismail' }}</p>
                <p class="mb-2"><strong>NIS:</strong> {{ $pembayaran->siswa->nis ?? '233933993' }}</p>
                <p class="mb-2"><strong>Angkatan:</strong> {{ $pembayaran->siswa->angkatan ?? '2024' }}</p>
                <p class="mb-2"><strong>Kelas:</strong> {{ $pembayaran->siswa->kelas ?? '1 D' }}</p>
                <p class="mb-2"><strong>Tanggal:</strong>
                    {{ \Carbon\Carbon::parse($pembayaran->tanggal_terbit ?? \Carbon\Carbon::now())->format('d-m-Y') }}</p>
                <p class="mb-2"><strong>Nominal:</strong> {{ number_format($pembayaran->biaya->nominal ?? 500000) }}</p>
                <p class="mb-2">
                    <strong>Status:</strong>
                    @if ($pembayaran->status == 'Lunas')
                        <span class="badge bg-success rounded-pill text-bg-success px-3">Sukses</span>
                    @elseif($pembayaran->status == 'Sedang Diverifikasi')
                        <span class="badge bg-warning  rounded-pill text-bg-warning px-3">Diproses</span>
                    @elseif($pembayaran->status == 'Verifikasi Kurang')
                        <span class="badge bg-warning  rounded-pill text-bg-warning px-3">Verifikasi Kurang</span>
                    @elseif($pembayaran->status == 'Kurang')
                        <span class="badge bg-warning  rounded-pill text-bg-warning px-3">Kurang</span>
                    @elseif($pembayaran->status == 'Lebih')
                        <span class="badge bg-warning  rounded-pill text-bg-warning px-3">Lebih</span>
                    @else
                        <span class="badge bg-danger  rounded-pill text-bg-danger px-3">Belum Lunas</span>
                    @endif
                </p>
            </div>

            <div class="row mb-4">
                <div class="col">
                    @if ($pembayaran->bukti_pelunasan)
                        <img src="{{ asset('bukti-pelunasan/' . $pembayaran->bukti_pelunasan) }}" id="preview"
                            class="img-fluid img-thumbnail shadow" alt="Bukti Pembayaran">
                    @endif
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('tagihan.lihatKuitansi', $pembayaran->id) }}" class="btn btn-lg btn-primary">Lihat
                    Kuitansi</a>
                <a href="{{ route('tagihan.downloadKuitansi', $pembayaran->id) }}" class="btn btn-lg btn-secondary">Unduh
                    Kuitansi</a>
            </div>
        </div>
    </div>
@endsection
