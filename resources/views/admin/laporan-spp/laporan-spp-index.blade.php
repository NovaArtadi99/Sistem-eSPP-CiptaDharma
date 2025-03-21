@extends('admin.admin-layout')
@section('content')
    <div class="row mb-3">

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
        <div class="col-md-2">
            <label for="filterTanggalAwal">Filter Tanggal Awal</label>
            <input type="date" id="filterTanggalAwal" name="filter_tanggal_awal" class="form-control">
        </div>
        <div class="col-md-2">
            <label for="filterTanggalAkhir">Filter Tanggal Akhir</label>
            <input type="date" id="filterTanggalAkhir" name="filter_tanggal_akhir" class="form-control">
        </div>

        <div class="col-md-1">
            <button type="submit" class="btn btn-outline-primary mt-4" id="btnFilter">
                Filter
            </button>

        </div>

        <div class="col-md-12">
            <div class="d-flex justify-content-end my-4">
                <div>
                    <a href="{{ route('laporanSpp.export') }}" class="btn btn-outline-success" id="btnExport">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </a>
                    {{-- <a href="{{ route('laporanSpp.import') }}" class="btn btn-warning" id="btnImport" data-bs-toggle="modal"
                        data-bs-target="#importModal">
                        <i class="fas fa-file-import"></i> Import Excel
                    </a> --}}
                    <a href="{{ route('laporanSpp.print') }}" class="btn btn-outline-dark" id="btnPrint">
                        <i class="fas fa-print"></i> Print
                    </a>

                </div>


            </div>
        </div>


    </div>

    <div class="table-responsive">
        <table class="table table-light" id="dataTables">
            <thead class="thead-light">
                <tr>
                    <th>No</th>
                    <th>No Invoice</th>
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Bulan</th>
                    <th>Tahun</th>
                    <th>Total Bayar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporan_spp as $index => $spp)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $spp->no_invoice ?? '-' }}</td>
                        <td>{{ $spp->siswa->nis ?? '-' }}</td>
                        <td>{{ $spp->siswa->nama ?? '-' }}</td>
                        <td>{{ $spp->siswa->kelas ?? '-' }}</td>
                        <td>{{ $spp->bulan ?? '-' }}</td>
                        <td>{{ $spp->tahun ?? '-' }}</td>
                        <td>
                            @if ($spp->status == 'Lunas')
                                <b> Rp. {{ number_format($spp->biaya->nominal, 0, ',', '.') }}</b>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <div class="d-grid">
                                <button class="btn btn-block btn-info my-1 btnDetailLaporanSPP" data-bs-toggle="modal"
                                    data-bs-target="#detailModal" data-id="{{ $spp->id }}">Detail</button>
                            </div>

                        </td>
                    </tr>
                @endforeach


            </tbody>
        </table>

    </div>


    <div id="importModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Import Data SPP</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('laporanSpp.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file" class="form-control" accept=".xls,.xlsx,.csv">
                        <button type="submit" class="btn btn-primary mt-3">Import</button>
                    </form>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>

    <div id="detailModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Detail Biaya</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="detail-no-invoice">No Invoice</label>
                        <input type="text" id="detail-no-invoice" class="form-control" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="detail-nis">NIS</label>
                        <input type="text" id="detail-nis" class="form-control" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="detail-nama-siswa">Nama Siswa</label>
                        <input type="text" id="detail-nama-siswa" class="form-control" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="detail-kelas">Kelas</label>
                        <input type="text" id="detail-kelas" class="form-control" readonly>
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
                        <label for="detail-total-bayar">Total Bayar</label>
                        <input type="text" id="detail-total-bayar" class="form-control" readonly>
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
                    url: "{{ route('laporanSpp.filter') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "filter_tahun": $('#filterTahun').val(),
                        "filter_bulan": $('#filterBulan').val(),
                        "filter_tanggal_awal": $('#filterTanggalAwal').val(),
                        "filter_tanggal_akhir": $('#filterTanggalAkhir').val(),
                    },
                    success: function(data) {
                        $('#dataTables').DataTable().destroy();
                        $('#dataTables tbody').empty();

                        $.each(data, function(index, value) {
                            $('#dataTables tbody').append('<tr>' +
                                '<td>' + (index + 1) + '</td>' +
                                '<td>' + value.no_invoice + '</td>' +
                                '<td>' + value.siswa.nis + '</td>' +
                                '<td>' + value.siswa.nama + '</td>' +
                                '<td>' + value.siswa.kelas + '</td>' +
                                '<td>' + value.bulan + '</td>' +
                                '<td>' + value.tahun + '</td>' +
                                '<td>' + 'Rp. ' + value.biaya.nominal + '</td>' +
                                '<td>' +
                                '<div class="d-grid">' +
                                '<button class="btn btn-block btn-info my-1 btnDetailLaporanSPP" data-bs-toggle="modal" data-bs-target="#detailModal" data-id="' +
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

        $(document).on('click', '.btnDetailLaporanSPP', function(e) {


            e.preventDefault();
            var dataId = $(this).data('id');
            $.ajax({
                url: "{{ route('laporanSpp.show', ['laporan_spp' => ':id']) }}".replace(':id',
                    dataId),
                type: "GET",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": dataId,
                },
                success: function(response) {
                    $('#detail-no-invoice').val(response.no_invoice);
                    $('#detail-nis').val(response.siswa.nis);
                    $('#detail-nama-siswa').val(response.siswa.nama);
                    $('#detail-kelas').val(response.siswa.kelas);
                    $('#detail-bulan').val(response.bulan);
                    $('#detail-tahun').val(response.tahun);
                    $('#detail-total-bayar').val('Rp. ' + response.biaya.nominal);
                }
            });
        });
    </script>
@endpush
