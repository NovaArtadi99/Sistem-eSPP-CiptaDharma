@extends('admin.admin-layout')
@section('content')
    <div class="row mb-3">
        <div class="col-md-2">
            <label for="filterAngkatan">Filter Angkatan</label>
            <select id="filterAngkatan" name="filter_angkatan" class="form-control">
                <option value="">Pilih Angkatan</option>
                @for ($year = 2020; $year <= date('Y'); $year++)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-2">
            <label for="filterKelas">Filter Kelas</label>
            <select id="filterKelas" class="form-control" name="filter_kelas">
                <option value="">Pilih Kelas</option>
                @foreach (range(1, 6) as $number)
                    @foreach (range('A', 'D') as $letter)
                        <option value="{{ $number . $letter }}">{{ $number . $letter }}</option>
                    @endforeach
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label for="filterTahun">Filter Tahun</label>
            <select id="filterTahun" name="filter_tahun" class="form-control">
                <option value="">Pilih Tahun</option>
                @for ($year = 2020; $year <= date('Y'); $year++)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-2">
            <label for="filterBulan">Filter Bulan</label>
            <select id="filterBulan" class="form-control" name="filter_bulan">
                <option value="">Pilih Bulan</option>
                <option value="Januari">Januari</option>
                <option value="Februari">Februari</option>
                <option value="Maret">Maret</option>
                <option value="April">April</option>
                <option value="Mei">Mei</option>
                <option value="Juni">Juni</option>
                <option value="Juli">Juli</option>
                <option value="Agustus">Agustus</option>
                <option value="September">September</option>
                <option value="Oktober">Oktober</option>
                <option value="November">November</option>
                <option value="Desember">Desember</option>
            </select>
        </div>
        <div class="col-4">
            <button type="submit" class="btn btn-outline-primary mt-4" id="btnFilter">Filter</button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-light" id="dataTables">
            <thead class="thead-light">
                <tr>
                    <th>No</th>
                    <th>No Invoice</th>
                    <th>NIS</th>
                    <th>Siswa</th>
                    <th>Nominal</th>
                    <th>Bulan</th>
                    <th>Tahun</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pembayarans as $index => $pembayaran)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $pembayaran->no_invoice }}</td>
                        <td>{{ $pembayaran->siswa->nis }}</td>
                        <td>{{ $pembayaran->siswa->nama }} - <b>{{ $pembayaran->siswa->kelas }}</b></td>
                        <td>{{ 'Rp. ' . number_format($pembayaran->biaya->nominal, 0, ',', '.') }}</td>
                        <td>{{ $pembayaran->bulan }}</td>
                        <td>{{ $pembayaran->tahun }}</td>
                        <td>
                            @if ($pembayaran->status == 'Belum Lunas')
                                <span class="badge rounded-pill bg-danger">Belum Lunas</span>
                            @elseif ($pembayaran->status == 'Sedang Diverifikasi')
                                <span class="badge rounded-pill bg-warning">Sedang Diverifikasi</span>
                            @elseif ($pembayaran->status == 'Lebih')
                                <span class="badge rounded-pill bg-success">Lunas Lebih</span>
                            @elseif ($pembayaran->status == 'Kurang')
                                <span class="badge rounded-pill bg-warning">Kurang</span>
                            @elseif ($pembayaran->status == 'Verifikasi Kurang')
                                <span class="badge rounded-pill bg-warning">Verifikasi Kurang</span>
                            @else
                                <span class="badge rounded-pill bg-success">Lunas</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                @if ($pembayaran->isSentKuitansi == '1')
                                    <a href="{{ route('tagihan.lihatKuitansi', $pembayaran->id) }}"
                                        class="btn btn-sm btn-secondary">Lihat Kuitansi</a>
                                @endif

                                @if (
                                    $pembayaran->bukti_pelunasan != null &&
                                        ($pembayaran->status == 'Sedang Diverifikasi' || $pembayaran->status == 'Kurang' ||
                                            $pembayaran->status == 'Belum Lunas' || $pembayaran->status == 'Verifikasi Kurang'))
                                    <a href="javascript:void(0);" id="btnVerifikasi_{{ $pembayaran->id }}"
                                        class="btn btn-sm btn-info btn-verifikasi" data-id="{{ $pembayaran->id }}">
                                        Verifikasi</a>
                                    <div id="statusButtons_{{ $pembayaran->id }}" class="status-buttons"
                                        style="display: none;">
                                        <a href="{{ route('pembayaran.verifikasi', $pembayaran->id) }}"
                                            class="btn btn-sm btn-success">Lunas</a>
                                        <button data-bs-toggle="modal" data-bs-target="#lebih_{{ $index + 1 }}"
                                            class="btn btn-sm btn-primary">Lebih</button>
                                        <button data-bs-toggle="modal" data-bs-target="#kurang_{{ $index + 1 }}"
                                            class="btn btn-sm btn-danger">Kurang</button>
                                    </div>
                                @endif

                                <a href="{{ route('pembayaran.show', $pembayaran->id) }}"
                                    class="btn btn-sm btn-warning">Detail</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <!-- tambahan a -->
    @foreach ($pembayarans as $index => $pembayaran)
        <!-- Modal lebih-->
        <div class="modal fade" id="lebih_{{ $index + 1 }}" tabindex="-1" role="dialog"
            aria-labelledby="modalTitleId_{{ $index + 1 }}" aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId_{{ $index + 1 }}">
                            Verifikasi Nominal Lebih
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('lebih', $pembayaran->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <label for="numb">Jumlah Nominal Lebih Sebesar</label>
                            <input id="numb" type="number" class="form-control" name="nominal">
                            <label hidden for="bukti_kembali">Bukti dikembalikan</label>
                            <input hidden id="bukti_kembali" type="file" class="form-control" accept="image/*"
                                name="file_bukti">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">
                                Kirim
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- modal kurang -->
        <div class="modal fade" id="kurang_{{ $index + 1 }}" tabindex="-1" role="dialog"
            aria-labelledby="modalTitleId_{{ $index + 1 }}" aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId_{{ $index + 1 }}">
                            Verifikasi Nominal Kurang
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('kurang', $pembayaran->id) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <label for="numb">Jumlah Nominal Kurang Sebesar</label>
                            <input id="numb" type="number" class="form-control" name="nominal">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">
                                Kirim
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    <!-- tambahan b -->
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('.btn-verifikasi').click(function() {
                var id = $(this).data('id');
                $(this).hide(); // Hide clicked button
                $('#statusButtons_' + id).show(); // Show status buttons for this row
            });
            reattachEventHandlers();
            $('#btnFilter').click(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('pembayaran.filter') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "filter_tahun": $('#filterTahun').val(),
                        "filter_bulan": $('#filterBulan').val(),
                        "filter_angkatan": $('#filterAngkatan').val(),
                        "filter_kelas": $('#filterKelas').val()
                    },
                    success: function(data) {
                        $('#dataTables').DataTable().destroy();
                        $('#dataTables tbody').empty();

                        $.each(data, function(index, value) {
                            $('#dataTables tbody').append('<tr>' +
                                '<td>' + (index + 1) + '</td>' +
                                '<td>' + value.no_invoice + '</td>' +
                                '<td>' + value.siswa.nis + '</td>' +
                                '<td>' + value.siswa.nama + ' - <b>' + value.siswa
                                .kelas + '</b></td>' +
                                '<td> Rp. ' + value.biaya.nominal.toLocaleString(
                                    'id-ID') + '</td>' +
                                '<td>' + value.bulan + '</td>' +
                                '<td>' + value.tahun + '</td>' +
                                '<td>' +
                                (value.status == 'Belum Lunas' ?
                                    '<span class="badge rounded-pill bg-danger">Belum Lunas</span>' :
                                    (value.status == 'Sedang Diverifikasi' ?
                                        '<span class="badge rounded-pill bg-warning">Sedang Diverifikasi</span>' :
                                        (value.status == 'Lebih' ?
                                        '<span class="badge rounded-pill bg-success">Lunas Lebih</span>' :
                                            (value.status == 'Kurang' ?
                                            '<span class="badge rounded-pill bg-warning">Kurang</span>' :
                                                (value.status == 'Verifikasi Kurang' ?
                                                '<span class="badge rounded-pill bg-warning">Verifikasi Kurang</span>' :
                                                    '<span class="badge rounded-pill bg-success">Lunas</span>'
                                                )
                                            )
                                        )
                                    )
                                ) +
                                '</td>' +
                                // In your filter AJAX success callback, update the generated HTML:
                                '<td>' +
                                '<div class="d-flex gap-1">' +
                                (value.isSentKuitansi == '1' || value.status ==
                                    'Lebih' ?
                                    '<a href="/lihat-kuitansi/' + value.id +
                                    '" class="btn btn-sm btn-secondary">Lihat Kuitansi</a>' :
                                    '') +
                                (value.bukti_pelunasan != null && (value.status ==
                                        'Sedang Diverifikasi' || value.status ==
                                        'Kurang' || value.status ==
                                        'Verifikasi Kurang' || value.status == 'Belum Lunas') ?
                                    '<a href="javascript:void(0);" class="btn btn-sm btn-info btn-verifikasi" data-id="' +
                                    value.id + '">Verifikasi</a>' +
                                    '<div id="statusButtons_' + value.id +
                                    '" class="status-buttons" style="display: none;">' +
                                    '<a href="/pembayaran/verifikasi/' + value.id +
                                    '" class="btn btn-sm btn-success">Lunas</a>' +
                                    '<button data-bs-toggle="modal" data-bs-target="#lebih_' +
                                    (index + 1) +
                                    '" class="btn btn-sm btn-primary">Lebih</button>' +
                                    '<button data-bs-toggle="modal" data-bs-target="#kurang_' +
                                    (index + 1) +
                                    '" class="btn btn-sm btn-danger">Kurang</button>' +
                                    '</div>' :
                                    '') +
                                '<a href="/pembayaran/' + value.id +
                                '" class="btn btn-sm btn-warning">Detail</a>' +
                                '</div>' +
                                '</td>' +
                                '</tr>');
                        });

                        $('#dataTables').DataTable({
                            "paging": true,
                            "lengthMenu": [10, 25, 50, 100], // Pilihan entries per page
                            "pageLength": 10, // Default 10 entries per page
                            "ordering": true, // Nonaktifkan sorting jika tidak diperlukan
                            "searching": true, // Aktifkan fitur pencarian
                            "info": true, // Tampilkan informasi jumlah data
                            "language": {
                                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                                "zeroRecords": "Tidak ada data ditemukan",
                                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                                "infoEmpty": "Tidak ada data tersedia",
                                "infoFiltered": "(disaring dari _MAX_ total data)",
                                "search": "Cari:",
                                "paginate": {
                                    "first": "<<",
                                    "last": ">>",
                                    "next": ">",
                                    "previous": "<"
                                }
                            }
                        });
                    }
                });
            });
        });
    </script>
<script>
function reattachEventHandlers() {
    // Handler for verification buttons
    $(document).off('click', '.btn-verifikasi').on('click', '.btn-verifikasi', function() {
        var id = $(this).data('id');
        $(this).hide();
        $('#statusButtons_' + id).show();
    });

    // Handler for invoice buttons (reattach if needed)
    $(document).off('click', '.btnSendInvoice').on('click', '.btnSendInvoice', function(e) {
        e.preventDefault();
        var dataId = $(this).data('id');
        // Your existing invoice sending code...
    });
}
</script>
    <!-- tambahan a -->
    <script>
        document.getElementById('btnVerifikasi').addEventListener('click', function() {
            this.style.display = 'none'; // Sembunyikan tombol Verifikasi
            document.getElementById('statusButtons').style.display = 'block'; // Tampilkan tombol lainnya
        });
    </script>
    <!-- tambahan b -->
@endpush
