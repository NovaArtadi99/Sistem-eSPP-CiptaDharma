@extends('admin.admin-layout')
@section('content')
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="filterStatus">Filter Status</label>
            <select id="filterStatus" name="filter_status" class="form-control">
                <option value="">Pilih Status</option>
                <option value="Lunas">Lunas</option>
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
        <table class="table table-light" id="dataTableOrtu">
            <thead class="thead-light">
                <tr>
                    <th>No</th>
                    <th>No Invoice</th>
                    <th>Nama Siswa</th>
                    <th>NIS</th>
                    <th>Nominal</th>
                    <th>Keterangan</th>
                    <th>Tahun</th>
                    <th>Bulan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pembayarans as $index => $pembayaran)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td> {{ $pembayaran->no_invoice }}</td>
                        <td>{{ $pembayaran->siswa->nama }} - <b>{{ $pembayaran->siswa->kelas }} </b></td>
                        <td>{{ $pembayaran->siswa->nis }} </td>

                        <td>{{ 'Rp. ' . number_format($pembayaran->biaya->nominal, 0, ',', '.') }}</td>
                        <td>{{ $pembayaran->biaya->nama_nominal }}</td>
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
                                            data-bs-target="#buktiModal_{{ $index + 1 }}">Cek Bukti</a>
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
                        <h5 class="modal-title" id="buktiModalLabel">Bukti Dikembalikan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="buktiImage" src="{{ asset('bukti-pelunasan/' . $pembayaran->bukti_lebih) }}"
                            class="img-fluid" alt="Bukti Transfer">
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
@push('scripts')
    <script>
        // $('#dataTableOrtu').DataTable();
        $(document).ready(function() {
            $('#dataTableOrtu').DataTable();
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
                        $('#dataTableOrtu').DataTable().destroy();
                        $('#dataTableOrtu tbody').empty();

                        $.each(data, function(index, value) {
                            var actionButtons = '';

                            // Perlu menggunakan kondisi JavaScript, bukan sintaks Blade
                            if (value.isSentKuitansi == '1') {
                                actionButtons += '<a href="' +
                                    "{{ route('tagihan.lihatKuitansi', '') }}/" + value
                                    .id +
                                    '" class="btn btn-sm btn-secondary">Lihat Kuitansi</a>';
                            }

                            if (value.status == 'Belum Lunas') {
                                actionButtons += '<a href="' +
                                    "{{ route('pelunasan.tagihan', '') }}/" + value
                                    .id +
                                    '" class="btn btn-sm btn-success me-3">Bayar</a>';
                            }

                            $('#dataTableOrtu tbody').append('<tr>' +
                                '<td>' + (index + 1) + '</td>' +
                                '<td>' + value.no_invoice + '</td>' +
                                '<td>' + value.siswa.nama + '-' + value.siswa
                                .kelas + '</td>' +
                                '<td>' + value.siswa.nis + '</td>' +

                                '<td> Rp. ' + value.biaya.nominal.toLocaleString(
                                    'id-ID') + '</td>' +
                                '<td>' + value.biaya.nama_nominal + '</td>' +
                                '<td>' + value.tahun + '</td>' +
                                '<td>' + value.bulan + '</td>' +
                                '<td>' +
                                (value.status == 'Belum Lunas' ?
                                    '<span class="badge rounded-pill bg-danger">Belum Lunas</span>' :
                                    (value.status == 'Sedang Diverifikasi' ?
                                        '<span class="badge rounded-pill bg-warning">Sedang Diverifikasi</span>' :
                                        '<span class="badge rounded-pill bg-success">Lunas</span>'
                                    )
                                ) + '</td>' +
                                '<td>' +
                                '<div class="d-flex gap-1">' +
                                '<a href="/ortu/pembayaran/' + value.id +
                                '" class="btn btn-sm btn-warning">Detail</a>' +
                                actionButtons +
                                '</div> </td>' +
                                '</tr>');


                        });


                        $('#dataTableOrtu').DataTable({

                            "autoWidth": false, // Matikan auto width
                            "columnDefs": [{
                                    "width": "1%",
                                    "targets": 0
                                } // Atur width kolom pertama
                            ],
                            "paging": true,
                            "lengthMenu": [10, 25, 50,
                                100
                            ], // Pilihan entries per page
                            "pageLength": 10, // Default 10 entries per page
                            "ordering": false, // Nonaktifkan sorting jika tidak diperlukan
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
@endpush
