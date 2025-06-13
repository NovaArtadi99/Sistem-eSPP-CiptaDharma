@extends('admin.admin-layout')
@section('content')
    {{-- <div class="row mb-3">
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
                <option value="1">Januari</option>
                <option value="2">Februari</option>
                <option value="3">Maret</option>
                <option value="4">April</option>
                <option value="5">Mei</option>
                <option value="6">Juni</option>
                <option value="7">Juli</option>
                <option value="8">Agustus</option>
                <option value="9">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
            </select>
        </div>
        <div class="col-4">
            <button type="submit" class="btn btn-outline-primary mt-4" id="btnFilter">
                Filter
            </button>

        </div>
    </div> --}}
    <div class="col-md-12">
        <div class="d-flex justify-content-end my-4">
            <div>
                {{-- <a href="#" onclick="window.print()" class="btn btn-outline-dark m-1 d-xl-inline d-lg-inline d-block"
                    id="btnPrint">
                    <i class="fas fa-print"></i> Print
                </a> --}}
                {{-- <a href="{{ route('laporanPetugas.print') }}" class="btn btn-outline-dark m-1 d-xl-inline d-lg-inline d-block"
                    id="btnPrint">
                    <i class="fas fa-print"></i> Print
                </a> --}}
            </div>


        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-light" id="dataTables">
            <thead class="thead-light">
                <tr>
                    <th>No</th>
                    <th>Nama Pegawai</th>
                    <th>NIP</th>
                    <th>Jabatan</th>
                    <th>SPP Terbit</th>
                    <th>SPP Dilunasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporan_petugas as $index => $petugas)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $petugas->nama }}</td>
                        <td>{{ $petugas->nip ?? '-' }}</td>
                        <td>
                            <ul>
                                @foreach ($petugas->roles as $role)
                                    <li>{{ $role->name }}</li>
                                @endforeach
                            </ul>


                        </td>
                        <td><b>{{ $petugas->menerbitkan_count }}</b></td>
                        <td><b>{{ $petugas->melunasi_count ?? '-' }}</b></td>
                        <td>
                            <div class="d-grid">
                                <a href="{{ route('laporanPetugas.show', ['petugas' => $petugas->id]) }}"
                                    class="btn btn-block btn-info my-1">Detail</a>
                            </div>

                        </td>
                    </tr>
                @endforeach


            </tbody>
        </table>
    </div>
@endsection

{{-- @push('scripts')
<script>
    document.getElementById('btnExport').addEventListener('click', function(e) {
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

        const url = "{{ route('laporanPetugas.export') }}" + "?" + params.toString();
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

        const url = "{{ route('laporanPetugas.print') }}" + "?" + params.toString();
        window.location.href = url;
    });
</script>

@endpush --}}
{{-- <script>
        $(document).ready(function() {
            $('#btnFilter').click(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('laporanPetugas.filter') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "filter_tahun": $('#filterTahun').val(),
                        "filter_bulan": $('#filterBulan').val(),
                    },
                    success: function(data) {
                        $('#dataTables').DataTable().destroy();
                        $('#dataTables tbody').empty();

                        $.each(data, function(index, value) {
                            $('#dataTables tbody').append('<tr>' +
                                '<td>' + (index + 1) + '</td>' +
                                '<td>' + value.nama + '</td>' +
                                '<td>' + (value.nip ? value.nip : '-') + '</td>' +
                                '<td>' +
                                '<ul>' +
                                value.roles.map(role => '<li>' + role.name +
                                    '</li>').join('') +
                                '</ul>' +
                                '</td>' +
                                '<td><b>' + value.menerbitkan_count + '</b></td>' +
                                '<td><b>' + (value.melunasi_count ? value.melunasi_count : '-') + '</b></td>' +
                                '<td>' +
                                '<div class="d-grid">' +
                                '<a href="/laporan-petugas/' + value.id +
                                '" class="btn btn-block btn-info my-1">Detail</a>' +
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
    </script> --}}
