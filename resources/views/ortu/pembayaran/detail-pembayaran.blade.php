@extends('admin.admin-layout')
@section('content')
    <div class="card">
        <div class="card-header bg-primary bg-opacity-25">
            <h5 class="mb-0">Detail Pembayaran</h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Nama Invoice:</strong> {{ $pembayaran->keterangan ?? 'Uang SPP' }}</p>
                        <p class="mb-1"><strong>Total Pembayaran:</strong> {{ number_format($pembayaran->biaya->nominal) }}
                        </p>
                        <p class="mb-1">
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
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tanggal Upload</th>
                            <th>Jumlah</th>
                            <th>Bukti Pembayaran</th>
                            <th>Status</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($pembayaran->tanggal_lunas ?? \Carbon\Carbon::now())->format('d-m-Y') }}
                            </td>
                            <td>{{ number_format($pembayaran->biaya->nominal) }}</td>
                            <td>
                                @if ($pembayaran->bukti_pelunasan)
                                    <a href="{{ asset('bukti-pelunasan/' . $pembayaran->bukti_pelunasan) }}"
                                        class="btn btn-sm btn-primary" target="_blank">View</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
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
                            @endif</td>
                            <td>-</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <div class="mb-3">
                    <label for="">Bukti Pelunasan</label>
                    @if ($pembayaran->bukti_pelunasan == null)
                        <h3>Orang tua belum melakukan pembayaran</h3>
                    @else
                        <img src="{{ asset('bukti-pelunasan/' . $pembayaran->bukti_pelunasan) }}" id="preview"
                            width="100%" alt="" class="img-thumbnail shadow">
                    @endif
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="">No Invoice</label>
                            <input type="text" name="no_invoice" class="form-control"
                                value="{{ $pembayaran->no_invoice }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="">Nama Invoice</label>
                            <input type="text" name="nama_tagihan" class="form-control"
                                value="{{ $pembayaran->keterangan }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="">NIS</label>
                            <input type="text" name="nis" class="form-control" value="{{ $pembayaran->siswa->nis }}"
                                readonly>
                        </div>

                        <div class="mb-3">
                            <label for="">Siswa</label>
                            <input type="text" name="nama_siswa" class="form-control"
                                value="{{ $pembayaran->siswa->nama }} - Kelas {{ $pembayaran->siswa->kelas }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="">Nominal</label>
                            <input type="text" name="nominal" class="form-control"
                                value="Rp.{{ number_format($pembayaran->biaya->nominal) }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="">Bulan</label>
                            <input type="text" name="bulan" class="form-control" value="{{ $pembayaran->bulan }}"
                                readonly>
                        </div>

                        <div class="mb-3">
                            <label for="">Tahun</label>
                            <input type="text" name="tahun" class="form-control" value="{{ $pembayaran->tahun }}"
                                readonly>
                        </div>

                        <div class="mb-3">
                            <label for="">Tanggal Terbit</label>
                            <input type="date" name="tanggal_terbit" class="form-control"
                                value="{{ $pembayaran->tanggal_terbit ?? date('Y-m-d') }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="">Tanggal Dilunasi</label>
                            <input type="date" name="tanggal_lunas" class="form-control"
                                value="{{ $pembayaran->tanggal_lunas }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="">Status Pelunasan</label>
                            <input type="text" name="status" class="form-control" value="{{ $pembayaran->status }}"
                                readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="">Admin Penerbit</label>
                            <input type="text" name="admin_penerbit" class="form-control"
                                value="{{ $pembayaran->penerbit->nama ?? 'Belum ada' }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="">Admin Pelunasan</label>
                            <input type="text" name="admin_pelunasan" class="form-control"
                                value="{{ $pembayaran->melunasi->nama ?? 'Belum ada' }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
