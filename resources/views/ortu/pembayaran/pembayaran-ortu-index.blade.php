@extends('admin.admin-layout-ortu')
@section('content')
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="filterStatus">Filter Status</label>
            <select id="filterStatus" name="filter_status" class="form-control">
                <option value="">Pilih Status</option>
                {{-- <option value="Lunas">Lunas</option> --}}
                <option value="Sedang Diverifikasi">Sedang Diverifikasi</option>
                <option value="Belum Lunas">Belum Lunas</option>
            </select>
        </div>

        <div class="col-4">
            <button type="submit" class="btn btn-outline-primary mt-4" id="btnFilter">
                Filter
            </button>

        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-light dt-responsive nowrap" id="dataTableOrtu" style="width: 100%;">
            <thead class="thead-light">
                <tr>
                    <th class="control"></th>
                    <th>No</th>
                    <th>No Invoice</th>
                    <th>Nama Siswa</th>
                    <th>NIS</th>
                    <th>Nominal</th>
                    {{-- <th>Keterangan</th> --}}
                    <th>Tahun</th>
                    <th>Bulan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pembayarans as $index => $pembayaran)
                    <tr>
                        <td class="control"></td>
                        <td>{{ $index + 1 }}</td>
                        <td> {{ $pembayaran->no_invoice }}</td>
                        <td>{{ $pembayaran->siswa->nama }} - <b>{{ $pembayaran->siswa->kelas }} </b></td>
                        <td>{{ $pembayaran->siswa->nis }} </td>

                        <td>{{ 'Rp. ' . number_format($pembayaran->biaya->nominal, 0, ',', '.') }}</td>
                        {{-- <td>{{ $pembayaran->biaya->nama_nominal }}</td> --}}
                        <td>{{ $pembayaran->tahun }}</td>
                        <td>{{ $pembayaran->bulan }}</td>
                        <td>
                            @if ($pembayaran->status == 'Belum Lunas')
                                <span class="badge rounded-pill bg-danger">Belum Lunas</span>
                            @elseif ($pembayaran->status == 'Sedang Diverifikasi')
                                <span class="badge rounded-pill bg-warning">Sedang Diverifikasi</span>
                                <!-- tambahan a -->
                            @elseif ($pembayaran->status == 'Lebih')
                                <span class="badge rounded-pill bg-success">Lunas Lebih</span>
                            @elseif ($pembayaran->status == 'Kurang')
                                <span class="badge rounded-pill bg-warning">Kurang</span>
                            @elseif ($pembayaran->status == 'Verifikasi Kurang')
                                <span class="badge rounded-pill bg-warning">Verifikasi Kurang</span>
                                <!-- tambahan b -->
                            @else
                                <span class="badge rounded-pill bg-success">Lunas</span>
                                @if ($pembayaran->status == 'Belum Lunas' || $pembayaran->status == 'Kurang')
                                    <a href="{{ route('pelunasan.tagihan', $pembayaran->id) }}"
                                        class="btn btn-sm btn-success me-3">Bayar</a>
                                @endif
                                {{-- @if ($pembayaran->status == 'Belum Lunas' || $pembayaran->status == 'Kurang') --}}

                                {{-- @elseif ($pembayaran->status == 'Lebih') --}}
                                @if ($pembayaran->status == 'Lebih')
                                    <div class="d-flex">
                                        <a href="#" class="btn btn-success me-1" data-bs-toggle="modal"
                                            data-bs-target="#buktiModal_{{ $index + 1 }}">Cek Bukti</a>
                                        <a href="{{ route('tagihan.lihatKuitansi', $pembayaran->id) }}"
                                            class="btn btn-sm btn-secondary">Lihat Kuitansi</a>
                                    </div>
                                @endif
                                {{-- tambahan --}}
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">

                                <a href="{{ route('ortu.pembayaran.show', $pembayaran->id) }}"
                                    class="btn btn-sm btn-warning">Detail</a>

                                @if ($pembayaran->isSentKuitansi == '1')
                                    <a href="{{ route('tagihan.lihatKuitansi', $pembayaran->id) }}"
                                        class="btn btn-sm btn-secondary">Lihat Kuitansi</a>
                                @endif

                                @if ($pembayaran->status == 'Belum Lunas' || $pembayaran->status == 'Kurang')
                                    <a href="{{ route('pelunasan.tagihan', $pembayaran->id) }}"
                                        class="btn btn-sm btn-success me-3">Bayar</a>
                                @endif
                                {{-- @if ($pembayaran->status == 'Belum Lunas' || $pembayaran->status == 'Kurang') --}}

                                {{-- @elseif ($pembayaran->status == 'Lebih') --}}
                                @if ($pembayaran->status == 'Lebih')
                                    <div class="d-flex">
                                        <a href="#" class="btn btn-success me-3" data-bs-toggle="modal"
                                            data-bs-target="#buktiModal_{{ $index + 1 }}">Validasi</a>
                                    </div>
                                @endif
                            </div>


                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <!-- modal -->
    @foreach ($pembayarans as $index => $pembayaran)
        <div class="modal fade" id="buktiModal_{{ $index + 1 }}" tabindex="-1" aria-labelledby="buktiModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="buktiModalLabel">Validasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        @if ($pembayaran->bukti_lebih == "kosong")
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTvX7ghSY75PvK5S-RvhkFxNz88MWEALSBDvA&s"id="preview" width="100%" alt="">
                        @endif
                        @if ($pembayaran->bukti_lebih != "kosong")
                        <img id="buktiImage" src="{{ asset('bukti-pelunasan/' . $pembayaran->bukti_lebih) }}" class="img-fluid" alt="Bukti Transfer">
                        @endif
                        <form action="{{ route('validasi.lebih') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $pembayaran->id }}">
                            <button type="submit" class="btn btn-primary mt-3">Validasi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
@push('scripts')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>


<script>
    var table;
    // table = $('#dataTableOrtu').DataTable({
    //         responsive: {
    //             details: {
    //                 type: 'column',
    //                 target: 0
    //             }
    //         },
    //         columnDefs: [
    //             { className: 'control', orderable: false, targets: 0 }
    //         ],
    //         ordering: true
    // });
    table = $('#dataTableOrtu').DataTable({
    responsive: {
        details: {
                display: $.fn.dataTable.Responsive.display.childRowImmediate,
                type: '' // kosong = tidak pakai tombol
            }
        },
        ordering: true
    });

    $(document).ready(function () {
    $('#btnFilter').click(function(e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('ortu.filterStatusPembayaran') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "filter_status": $('#filterStatus').val(),
            },
            success: function(data) {
                table.clear();

                var rows = [];
                $.each(data, function(index, value) {
                    var actionButtons = '';

                    if (value.isSentKuitansi == '1') {
                        actionButtons += '<a href="' +
                            "{{ route('tagihan.lihatKuitansi', '') }}/" + value.id +
                            '" class="btn btn-sm btn-secondary">Lihat Kuitansi</a>';
                    }

                    if (value.status == 'Belum Lunas') {
                        actionButtons += '<a href="' +
                            "{{ route('pelunasan.tagihan', '') }}/" + value.id +
                            '" class="btn btn-sm btn-success me-3">Bayar</a>';
                    }

                    var statusBadge = '';
                    if (value.status == 'Belum Lunas') {
                        statusBadge = '<span class="badge rounded-pill bg-danger">Belum Lunas</span>';
                    } else if (value.status == 'Sedang Diverifikasi') {
                        statusBadge = '<span class="badge rounded-pill bg-warning">Sedang Diverifikasi</span>';
                    } else if (value.status == 'Lebih') {
                        statusBadge = '<span class="badge rounded-pill bg-success">Lunas Lebih</span>';
                    } else if (value.status == 'Kurang') {
                        statusBadge = '<span class="badge rounded-pill bg-warning">Kurang</span>';
                    } else if (value.status == 'Verifikasi Kurang') {
                        statusBadge = '<span class="badge rounded-pill bg-warning">Verifikasi Kurang</span>';
                    } else {
                        statusBadge = '<span class="badge rounded-pill bg-success">Lunas</span>';
                    }

                    rows.push([
                        '', // control column
                        index + 1,
                        value.no_invoice,
                        value.siswa.nama + ' - ' + value.siswa.kelas,
                        value.siswa.nis,
                        'Rp. ' + value.biaya.nominal.toLocaleString('id-ID'),
                        value.tahun,
                        value.bulan,
                        statusBadge,
                        '<div class="d-flex gap-1">' +
                            '<a href="/ortu/pembayaran/' + value.id + '" class="btn btn-sm btn-warning">Detail</a>' +
                            actionButtons +
                        '</div>'
                    ]);
                });

                table.rows.add(rows).draw();
            }
        });
    });
});

</script>

@endpush
