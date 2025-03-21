@extends('admin.admin-layout')
@section('content')
    <div class="row mb-3">

        <div class="">
            <button class="btn btn-dark mb-5">Data yang disajikan adalah data siswa pada bulan ini</button>

        </div>
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
            <label for="filterStatus">Filter Status</label>
            <select id="filterStatus" class="form-control" name="filter_status">
                <option value="">Pilih Status</option>
                <option value="Belum Lunas">Belum Lunas</option>
                <option value="Sedang Diverifikasi">Sedang Diverifikasi</option>
                <option value="Lunas">Lunas</option>
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
        <div class="col-2">
            <button class="btn btn-outline-primary mt-4" id="btnFilter">
                Filter
            </button>

        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-light" id="dataTables">
            <thead class="thead-light">
                <tr>
                    <th>No</th>
                    <th>No Invoice</th>
                    <th>Nama Siswa</th>
                    <th>NIS</th>
                    <th>Angkatan</th>
                    <th>Kelas</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporan_siswa as $index => $siswa)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $siswa->no_invoice }}</td>
                        <td>{{ $siswa->siswa->nama }}</td>
                        <td>{{ $siswa->siswa->nis }}</td>
                        <td>{{ $siswa->siswa->angkatan }}</td>
                        <td>{{ $siswa->siswa->kelas }}</td>
                        <td>
                            @if ($siswa->status == 'Belum Lunas')
                                <button class="btn btn-danger">Belum Lunas</button>
                            @elseif ($siswa->status == 'Sedang Diverifikasi')
                                <button class="btn btn-warning">Sedang Diverifikasi</button>
                            @else
                                <button class="btn btn-success">Lunas</button>
                            @endif
                        </td>
                        <td>
                            <div class="d-grid">
                                <button class="btn btn-block btn-info my-1 btnDetailLaporanSiswa" data-bs-toggle="modal"
                                    data-bs-target="#detailModal" data-id = "{{ $siswa->id }}">Detail</button>
                            </div>

                        </td>
                    </tr>
                @endforeach


            </tbody>
        </table>
    </div>


    <div id="detailModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Detail Siswa</h5>
                    <button class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="detail-nama-siswa">Nama Siswa</label>
                        <input type="text" id="detail-nama-siswa" class="form-control" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="detail-nominal">Nominal</label>
                        <input type="text" id="detail-nominal" class="form-control" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="detail-no-invoice">No Invoice</label>
                        <input type="text" id="detail-no-invoice" class="form-control" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="detail-keterangan">Keterangan</label>
                        <input type="text" id="detail-keterangan" class="form-control" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="detail-tanggal-terbit">Tanggal Terbit</label>
                        <input type="date" id="detail-tanggal-terbit" class="form-control" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="detail-tanggal-lunas">Tanggal Lunas</label>
                        <input type="date" id="detail-tanggal-lunas" class="form-control" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="detail-status">Status</label>
                        <input type="text" id="detail-status" class="form-control" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="detail-user-penerbit">User Penerbit</label>
                        <input type="text" id="detail-user-penerbit" class="form-control" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="detail-user-melunasi">User Melunasi</label>
                        <input type="text" id="detail-user-melunasi" class="form-control" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="detail-biaya">Biaya</label>
                        <input type="text" id="detail-biaya" class="form-control" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="detail-bulan">Bulan</label>
                        <input type="text" id="detail-bulan" class="form-control" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="detail-tahun">Tahun</label>
                        <input type="text" id="detail-tahun" class="form-control" readonly>
                    </div>

                    <div class="form-group mb-3">
                        <label for="detail-nis">NIS </label>
                        <input type="text" id="detail-nis" class="form-control" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="detail-bukti-pelunasan">Bukti Pelunasan</label>
                        <br>
                        <a href="" id="detail-bukti-pelunasan-link" target="_blank"> Click to view
                        </a>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#btnFilter').click(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('laporanSiswa.filter') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "filter_angkatan": $('#filterAngkatan').val(),
                        "filter_kelas": $('#filterKelas').val(),
                        "filter_status": $('#filterStatus').val(),
                        "filter_tahun": $('#filterTahun').val(),
                        "filter_bulan": $('#filterBulan').val(),
                    },
                    success: function(data) {
                        $('#dataTables').DataTable().destroy();
                        $('#dataTables tbody').empty();

                        $.each(data, function(index, value) {
                            $('#dataTables tbody').append('<tr>' +
                                '<td>' + (index + 1) + '</td>' +
                                '<td>' + value.no_invoice + '</td>' +
                                '<td>' + value.siswa.nama + '</td>' +
                                '<td>' + value.siswa.nis + '</td>' +
                                '<td>' + value.siswa.angkatan + '</td>' +
                                '<td>' + value.siswa.kelas + '</td>' +
                                '<td>' + (value.status == 'Belum Lunas' ?
                                    '<button class="btn btn-danger">Belum Lunas</button>' :
                                    (value.status == 'Sedang Diverifikasi' ?
                                        '<button class="btn btn-warning">Sedang Diverifikasi</button>' :
                                        '<button class="btn btn-success">Lunas</button>'
                                    )
                                ) + '</td>' +
                                '<td> <div class="d-grid">' +
                                '<button class="btn btn-block btn-info my-1 btnDetailLaporanSiswa" data-bs-toggle="modal" data-bs-target="#detailModal" data-id="' +
                                value.id +
                                '">Detail</button>' +
                                '</div>' +
                                '</td>' +
                                '</tr>');
                        });

                        $('#dataTables').DataTable({
                            "paging": true,
                            "lengthMenu": [10, 25, 50, 100], // Pilihan entries per page
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



        $(document).on('click', '.btnDetailLaporanSiswa', function(e) {
            var dataId = $(this).data('id');


            $.ajax({
                type: "GET",
                url: "{{ route('laporanSiswa.show', ['laporan_siswa' => ':id']) }}".replace(':id', dataId),
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": dataId
                },
                dataType: "json",
                success: function(response) {
                    $('#detail-nis').val(response.siswa.nis);
                    $('#detail-nama-siswa').val(response.siswa.nama);
                    $('#detail-nominal').val(response.biaya.nominal);
                    $('#detail-no-invoice').val(response.no_invoice);
                    $('#detail-keterangan').val(response.keterangan);
                    $('#detail-tanggal-terbit').val(response.tanggal_terbit);
                    $('#detail-tanggal-lunas').val(response.tanggal_lunas);
                    $('#detail-bukti-pelunasan-link').attr('href', response.bukti_pelunasan ?
                        "{{ asset('bukti-pelunasan') }}/" + response.bukti_pelunasan : '');
                    $('#detail-status').val(response.status);
                    $('#detail-user-penerbit').val(response.penerbit ? response.penerbit
                        .nama : '-');
                    $('#detail-user-melunasi').val(response.melunasi ? response.melunasi
                        .nama : '-');
                    $('#detail-biaya').val(response.biaya ? response.biaya.nama_biaya : '-');
                    $('#detail-bulan').val(response.bulan);
                    $('#detail-tahun').val(response.tahun);
                }
            });
        });
    </script>
@endpush
