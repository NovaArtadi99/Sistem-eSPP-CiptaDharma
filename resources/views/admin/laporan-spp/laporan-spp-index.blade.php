@extends('admin.admin-layout')
@section('content')
    <div class="row">
        <div class="row col-md-6">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">
                        <label for="filterstts">Status</label>
                        <select id="filterstts" name="filter_status" class="form-control">
                            <option value="Lunas">Lunas</option>
                            <option value="Belum Lunas">Belum Lunas</option>
                            <option value="Sedang Diverifikasi">Sedang Diverifikasi</option>
                            <option value="Lebih">Lebih</option>
                            <option value="Kurang">Kurang</option>
                            <option value="Verifikasi Kurang">Verifikasi Kurang</option>
                            <option value="">Semua</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="filterKelas">Kelas</label>
                        <select id="filterKelas" class="form-control" name="filter_kelas">
                            <option value="">Pilih Kelas</option>
                            @foreach (range(1, 6) as $number)
                                @foreach (range('A', 'D') as $letter)
                                    <option value="{{ $number . $letter }}">{{ $number . $letter }}</option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="filterTahun">Tahun</label>
                        <select id="filterTahun" name="filter_tahun" class="form-control">
                            <option value="">Pilih Tahun</option>
                            @for ($year = 2020; $year <= date('Y'); $year++)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="filterBulan">Bulan</label>
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
                </div>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <label for="filterTanggalAwal">Tanggal Awal</label>
                        <input type="date" id="filterTanggalAwal" name="filter_tanggal_awal" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label for="filterTanggalAkhir">Tanggal Akhir</label>
                        <input type="date" id="filterTanggalAkhir" name="filter_tanggal_akhir" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-outline-primary mt-4" id="btnFilter">
                            Filter
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row col-md-6">
            <div class="col-md-12">
                <div class="d-flex justify-content-end my-4">
                    <div>
                        <a href="#" class="btn btn-outline-success" id="btnExport_format"
                            data-bs-toggle="modal" data-bs-target="#btnExport_format_modal">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </a>
                        <a href="#" class="btn btn-outline-dark" id="btnPrint">
                            <i class="fas fa-print"></i> Print
                        </a>
                    </div>
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
                    <th>Nominal</th>
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


    {{-- <div id="importModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>

                </div>
            </div>
        </div>
    </div> --}}

    <div id="detailModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Detail Laporan SPP</h5>
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
                        <label for="detail-total-bayar">Nominal</label>
                        <input type="text" id="detail-total-bayar" class="form-control" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal format laporan -->
    <div class="modal fade" id="btnExport_format_modal" tabindex="-1" role="dialog" aria-labelledby="modalTitleId"
        aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Atur Format Laporan SPP
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formatLaporanForm">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="fieldNoInvoice" checked>
                            <label class="form-check-label" for="fieldNoInvoice">No Invoice</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="fieldNIS" checked>
                            <label class="form-check-label" for="fieldNIS">NIS</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="fieldNamaSiswa" checked>
                            <label class="form-check-label" for="fieldNamaSiswa">Nama Siswa</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="fieldKelas" checked>
                            <label class="form-check-label" for="fieldKelas">Kelas</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="fieldBulan" checked>
                            <label class="form-check-label" for="fieldBulan">Bulan</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="fieldTahun" checked>
                            <label class="form-check-label" for="fieldTahun">Tahun</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="fieldTotalBayar" checked>
                            <label class="form-check-label" for="fieldTotalBayar">Total Bayar</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="fieldTanggalTerbit" checked>
                            <label class="form-check-label" for="fieldTanggalTerbit">Tanggal Terbit</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="fieldTanggalLunas" checked>
                            <label class="form-check-label" for="fieldTanggalLunas">Tanggal Lunas</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="fieldAdminPenerbit" checked>
                            <label class="form-check-label" for="fieldAdminPenerbit">Admin Penerbit</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="fieldUserMelunasi" checked>
                            <label class="form-check-label" for="fieldUserMelunasi">User Melunasi</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="fieldStatus" checked>
                            <label class="form-check-label" for="fieldStatus">Status</label>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <a href="#" class="btn btn-outline-success" id="btnExport">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Tutup
                    </button>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.getElementById('btnExport').addEventListener('click', function(e) {
        e.preventDefault();

        const tahun = document.getElementById('filterTahun').value;
        const bulan = document.getElementById('filterBulan').value;
        const tglAwal = document.getElementById('filterTanggalAwal').value;
        const tglAkhir = document.getElementById('filterTanggalAkhir').value;
        const stts = document.getElementById('filterstts').value;
        const kelas = document.getElementById('filterKelas').value;

        const fields = [
            'NoInvoice', 'NIS', 'NamaSiswa', 'Kelas',
            'Bulan', 'Tahun', 'TotalBayar', 'TanggalTerbit',
            'TanggalLunas', 'AdminPenerbit', 'UserMelunasi', 'Status'
        ];

        const selectedFields = fields.filter(field => {
            const checkbox = document.getElementById(`field${field}`);
            return checkbox && checkbox.checked;
        });

        const params = new URLSearchParams();

        if (tahun) params.append('filter_tahun', tahun);
        if (bulan) params.append('filter_bulan', bulan);
        if (tglAwal) params.append('filter_tanggal_awal', tglAwal);
        if (tglAkhir) params.append('filter_tanggal_akhir', tglAkhir);
        if (stts) params.append('filter_stts', stts);
        if (kelas) params.append('filter_kelas', kelas);

        selectedFields.forEach(field => params.append('fields[]', field));

        const url = "{{ route('laporanSpp.export') }}" + "?" + params.toString();
        window.location.href = url;
    });

    document.getElementById('btnPrint').addEventListener('click', function(e) {
        e.preventDefault();

        const tahun = document.getElementById('filterTahun').value;
        const bulan = document.getElementById('filterBulan').value;
        const tglAwal = document.getElementById('filterTanggalAwal').value;
        const tglAkhir = document.getElementById('filterTanggalAkhir').value;

        const params = new URLSearchParams();

        if (tahun) params.append('filter_tahun', tahun);
        if (bulan) params.append('filter_bulan', bulan);
        if (tglAwal) params.append('filter_tanggal_awal', tglAwal);
        if (tglAkhir) params.append('filter_tanggal_akhir', tglAkhir);

        const url = "{{ route('laporanSpp.print') }}" + "?" + params.toString();
        window.location.href = url;
    });
</script>
    <script>
        $(document).ready(function() {
            $('#btnFilter').click(function(e) {
            // console.log($('#filterKelas').val());
                e.preventDefault();
                $.ajax({
                    url: "{{ route('laporanSpp.filter') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "filter_stts": $('#filterstts').val(),
                        "filter_kelas": $('#filterKelas').val(),
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
            $('#btnReset').click(function() {
                $('#filterStatus').val('');

                // Reload page to reset the table or you can optionally re-fetch all data via AJAX
                location.reload();
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
