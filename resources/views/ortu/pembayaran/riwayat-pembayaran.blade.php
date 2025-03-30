@extends('admin.admin-layout')
@section('content')
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="filterTahun">Filter Tahun</label>
            <select id="filterTahun" name="filter_tahun" class="form-control">
                <option value="">Pilih Tahun</option>
                @for ($year = 2015; $year <= date('Y'); $year++)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-4">
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
                    <th>Tanggal</th>
                    <th>Nama Siswa</th>
                    <th>NIS</th>
                    <th>Angkatan</th>
                    <th>Kelas</th>
                    <th>Nominal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($riwayats as $index => $riwayat)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $riwayat->no_invoice }}</td>
                        <td>{{ $riwayat->tanggal_terbit }}</td>
                        <td>{{ $riwayat->siswa->nama }}</td>
                        <td>{{ $riwayat->siswa->nis }}</td>
                        <td>{{ $riwayat->siswa->angkatan }}</td>
                        <td>{{ $riwayat->siswa->kelas }}</td>
                        <td>{{ 'Rp. ' . number_format($riwayat->biaya->nominal, 0, ',', '.') }}</td>

                        <td>
                            <div class="d-flex gap-1">
                                @if ($riwayat->status == 'Belum Lunas')
                                    <button type="button" class="btn btn-sm btn-danger">Belum Lunas</button>
                                @elseif ($riwayat->status == 'Sedang Diverifikasi')
                                    <button type="button" class="btn btn-sm btn-warning">Sedang Diverifikasi</button>

                                    <!-- tambahan a -->
                                {{-- @elseif ($riwayat->status == 'Lebih')
                                    <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                        data-bs-target="#buktiModal_{{ $index + 1 }}">Lunas Lebih</a> --}}
                                {{-- @elseif ($riwayat->status == 'Kurang')
                                    <button type="button" class="btn btn-sm btn-warning">Kurang</button> --}}
                                    <!-- tambahan b -->
                                @else
                                    <button type="button" class="btn btn-sm btn-success">Lunas</button>
                                @endif

                                @if ($riwayat->status == 'Lunas' && $riwayat->isSentKuitansi == '1')
                                    {{-- <a href="{{ asset('bukti-pelunasan/' . $riwayat->bukti_pelunasan) }}"
                                        class="btn btn-sm btn-primary">Bukti</a> --}}
                                    <a href="{{ route('tagihan.lihatKuitansi', $riwayat->id) }}"
                                        class="btn btn-sm btn-secondary">Lihat Kuitansi</a>
                                @else
                                    <button disabled class="btn btn-sm btn-secondary">Kuitansi Belum ada</button>
                                @endif
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('ortu.show.riwayatPembayaran', $riwayat->id) }}"
                                class="btn btn-sm btn-info">Detail</a>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- tambahan --}}
    <!-- modal -->
    @foreach ($riwayats as $index => $riwayat)
        <div class="modal fade" id="buktiModal_{{ $index + 1 }}" tabindex="-1" aria-labelledby="buktiModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="buktiModalLabel">Bukti Dikembalikan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="buktiImage" src="{{ asset('bukti-pelunasan/' . $riwayat->bukti_lebih) }}"
                            class="img-fluid" alt="Bukti Transfer">
                        <form action="{{ route('validasi.lebih') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $riwayat->id }}">
                            <button type="submit" class="btn btn-primary mt-3">Validasi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{--  --}}
@endsection
@push('scripts')
    <script>

        $(document).ready(function() {

            $('#dataTableOrtu').DataTable();
            $('#btnFilter').click(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('ortu.filterRiwayatPembayaran') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "filter_tahun": $('#filterTahun').val(),
                        "filter_bulan": $('#filterBulan').val(),
                    },
                    success: function(data) {
                        $('#dataTableOrtu').DataTable().destroy();
                        $('#dataTableOrtu tbody').empty();
                        $.each(data, function(index, value) {
                            $('#dataTableOrtu tbody').append('<tr>' +
                                '<td>' + (index + 1) + '</td>' +
                                '<td>' + value.no_invoice + '</td>' +
                                '<td>' + value.tanggal_terbit + '</td>' +
                                '<td>' + value.siswa.nama + '</td>' +
                                '<td>' + value.siswa.nis + '</td>' +
                                '<td>' + value.siswa.angkatan + '</td>' +
                                '<td>' + value.siswa.kelas + '</td>' +
                                '<td> Rp. ' + value.biaya.nominal.toLocaleString(
                                    'id-ID') + '</td>' +
                                '<td>' +
                                '<div class="d-flex gap-1">' +
                                (value.status == 'Belum Lunas' ?
                                    '<a href="{{ route('pembayaran.verifikasi', ' + value.id + ') }}" class="btn btn-sm btn-danger">Belum Lunas</a>' :
                                    '<span class="btn btn-sm btn-success">Lunas</span>'
                                ) +
                                (value.status == 'Lunas' && value.isSentKuitansi ==
                                    1 ?
                                    '<a href="{{ asset("bukti-pelunasan/' + value.bukti_pelunasan + '") }}" class="btn btn-sm btn-secondary">Kuitansi</a>' :
                                    '<button disabled class="btn btn-sm btn-secondary">Kuitansi Belum ada</button>'
                                ) +
                                '</div>' +
                                '</td>' +
                                '<td>' +
                                '<a href="/ortu/riwayat-pembayaran/' + value.id +
                                '" class="btn btn-sm btn-info">Detail</a>' +
                                '</td>' +
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
