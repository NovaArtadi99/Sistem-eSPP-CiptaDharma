@extends('admin.admin-layout')
@section('content')
    <div class="row my-3">
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12  mt-3">
            <a href="{{ route('siswa.create') }}" class="btn btn-primary">Tambah Siswa</a>

        </div>
        <div class="col-xxl-9 col-xl-9 col-lg-9 col-md-9 col-sm-12 mt-3">
            <div class="d-xxl-flex d-xl-flex d-md-flex d-sm-grid justify-content-end">
                <form action="{{ route('siswa.update_chatid') }}" method="POST" class="d-inline m-1 pb-0">
                    @csrf
                    <div class="py-0 px-1">
                        <button class="btn btn-secondary d-block w-100">
                            Update ID Chat Telegram
                        </button>
                    </div>

                </form>
                <a href="{{ route('siswa.export') }}" class="btn btn-outline-success m-1 d-xl-inline d-lg-inline d-block "
                    id="btnExport">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
                <a href="#" class="btn btn-warning m-1 d-xl-inline d-lg-inline d-block" id="btnImport"
                    data-bs-toggle="modal" data-bs-target="#importModal">
                    <i class="fas fa-file-import"></i> Import Excel
                </a>
                <a href="{{ route('siswa.print') }}" class="btn btn-outline-dark m-1 d-xl-inline d-lg-inline d-block"
                    id="btnPrint">
                    <i class="fas fa-print"></i> Print
                </a>
            </div>


        </div>


    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="filterAngkatan">Filter Angkatan</label>
            <select id="filterAngkatan" name="filter_angkatan" class="form-control">
                <option value="">Pilih Angkatan</option>
                @for ($year = 2020; $year <= date('Y'); $year++)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-4">
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
        <div class="col-4">
            <button class="btn btn-outline-primary mt-4" id="btnFilter">
                Filter
            </button>
            <button class="btn btn-outline-danger mt-4" id="btnReset">Reset</button>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-light" id="dataTables">
            <thead class="thead-light">
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Angkatan</th>
                    <th>Kelas</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                    <th>Aksi</th> <!-- Kolom untuk aksi -->
                </tr>
            </thead>
            <tbody>
                @foreach ($siswas as $index => $siswa)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $siswa->nama }}</td>
                        <td>{{ $siswa->angkatan }}</td>
                        <td>{{ $siswa->kelas }}</td>
                        <td>{{ $siswa->jenis_kelamin }}</td>
                        <td>{{ $siswa->alamat }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <button class="btn btn-block btn-info my-1 btnDetailSiswa" data-bs-toggle="modal"
                                    data-bs-target="#detailModal" data-id = "{{ $siswa->id }}">Detail</button>

                                {{-- <a href="{{ route('siswa.show', $siswa->id) }}" class="btn btn-block btn-info my-1">Detail</a> --}}
                                <a href="{{ route('siswa.edit', $siswa->id) }}"
                                    class="btn btn-block btn-warning my-1">Edit</a>

                                <form action="{{ route('siswa.destroy', $siswa->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-block my-1"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus siswa ini?')">Hapus</button>
                                </form>
                            </div>

                        </td>
                    </tr>
                @endforeach

                {{-- {{ $siswas->links() }} --}}

            </tbody>
        </table>
    </div>



    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="modalTitleId"
        aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Import Data Siswa
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('siswa.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file" class="form-control" accept=".xls,.xlsx,.csv">
                        <button type="submit" class="btn btn-primary mt-3">Import</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>

                </div>
            </div>
        </div>
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
                        <label for="detail-nama">Nama</label>
                        <input type="text" id="detail-nama" class="form-control" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="detail-nis">NIS</label>
                        <input type="text" id="detail-nis" class="form-control" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="detail-nisn">NISN</label>
                        <input type="text" id="detail-nisn" class="form-control" readonly>
                    </div>

                    <div class="form-group mb-3">
                        <label for="detail-email">Email</label>
                        <input type="email" id="detail-email" class="form-control" readonly>
                    </div>

                    <div class="form-group mb-3">
                        <label for="detail-nama-wali">Nama Wali</label>
                        <input type="text" id="detail-nama-wali" class="form-control" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="detail-alamat">Alamat</label>
                        <input type="text" id="detail-alamat" class="form-control" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="detail-no-telp">No Telp</label>
                        <input type="text" id="detail-no-telp" class="form-control" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="detail-angkatan">Angkatan</label>
                        <input type="text" id="detail-angkatan" class="form-control" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="detail-kelas">Kelas</label>
                        <input type="text" id="detail-kelas" class="form-control" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="detail-jenis-kelamin">Jenis Kelamin</label>
                        <input type="text" id="detail-jenis-kelamin" class="form-control" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="detail-tanggal-laihr">Tanggal Lahir</label>
                        <input type="text" id="detail-tanggal-lahir" class="form-control" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="detail-password">Password</label>
                        <input type="password" id="detail-password" class="form-control" readonly>
                    </div>
                    {{-- <div class="form-group mb-3">
                        <label for="detail-id-telegram">ID Telegram</label>
                        <input type="text" id="detail-id-telegram" class="form-control" readonly>
                    </div> --}}
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
            if (localStorage.getItem("filter_angkatan")) {
                $('#filterAngkatan').val(localStorage.getItem("filter_angkatan"));
            }
            if (localStorage.getItem("filter_kelas")) {
                $('#filterKelas').val(localStorage.getItem("filter_kelas"));
            }
            $.ajax({
                url: "{{ route('siswa.filter') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "filter_angkatan": $('#filterAngkatan').val(),
                    "filter_kelas": $('#filterKelas').val()
                },
                success: function(data) {
                    $('#dataTables').DataTable().destroy(); // Hancurkan instance DataTable lama
                    $('#dataTables tbody').empty(); // Kosongkan isi tabel sebelum menambahkan data baru

                    $.each(data, function(index, value) {
                        $('#dataTables tbody').append('<tr>' +
                            '<td>' + (index + 1) + '</td>' +
                            '<td>' + value.nama + '</td>' +
                            '<td>' + value.angkatan + '</td>' +
                            '<td>' + value.kelas + '</td>' +
                            '<td>' + value.jenis_kelamin + '</td>' +
                            '<td>' + value.alamat + '</td>' +
                            '<td>' +
                            '<div class="d-flex gap-1">' +
                            '<button class="btn btn-info btnDetailSiswa" data-id="' + value
                            .id +
                            '" data-bs-toggle="modal" data-bs-target="#detailModal">Detail</button>' +
                            '<a href="/siswa/' + value.id +
                            '/edit" class="btn btn-warning">Edit</a>' +
                            '<form action="/siswa/' + value.id +
                            '" method="POST" style="display:inline;">' +
                            '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                            '<input type="hidden" name="_method" value="DELETE">' +
                            '<button type="submit" class="btn btn-danger" onclick="return confirm(\'Apakah Anda yakin ingin menghapus siswa ini?\')">Hapus</button>' +
                            '</form>' +
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
    </script>
    <script>
        $('#btnFilter').click(function(e) {
            e.preventDefault();
            localStorage.setItem("filter_angkatan", $('#filterAngkatan').val());
            localStorage.setItem("filter_kelas", $('#filterKelas').val());
            $.ajax({
                url: "{{ route('siswa.filter') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "filter_angkatan": $('#filterAngkatan').val(),
                    "filter_kelas": $('#filterKelas').val()
                },
                success: function(data) {
                    $('#dataTables').DataTable().destroy(); // Hancurkan instance DataTable lama
                    $('#dataTables tbody').empty(); // Kosongkan isi tabel sebelum menambahkan data baru

                    $.each(data, function(index, value) {
                        $('#dataTables tbody').append('<tr>' +
                            '<td>' + (index + 1) + '</td>' +
                            '<td>' + value.nama + '</td>' +
                            '<td>' + value.angkatan + '</td>' +
                            '<td>' + value.kelas + '</td>' +
                            '<td>' + value.jenis_kelamin + '</td>' +
                            '<td>' + value.alamat + '</td>' +
                            '<td>' +
                            '<div class="d-flex gap-1">' +
                            '<button class="btn btn-info btnDetailSiswa" data-id="' + value
                            .id +
                            '" data-bs-toggle="modal" data-bs-target="#detailModal">Detail</button>' +
                            '<a href="/siswa/' + value.id +
                            '/edit" class="btn btn-warning">Edit</a>' +
                            '<form action="/siswa/' + value.id +
                            '" method="POST" style="display:inline;">' +
                            '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                            '<input type="hidden" name="_method" value="DELETE">' +
                            '<button type="submit" class="btn btn-danger" onclick="return confirm(\'Apakah Anda yakin ingin menghapus siswa ini?\')">Hapus</button>' +
                            '</form>' +
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
        $(document).on('click', '.btnDetailSiswa', function(e) {
            var dataId = $(this).data('id');


            $.ajax({
                type: "GET",
                url: "{{ route('siswa.show', ['siswa' => ':id']) }}".replace(':id', dataId),
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": dataId
                },
                dataType: "json",
                success: function(response) {
                    $('#detail-nama').val(response.nama);
                    $('#detail-nis').val(response.nis);
                    $('#detail-nisn').val(response.nisn);
                    $('#detail-email').val(response.email);
                    $('#detail-nama-wali').val(response.nama_wali);
                    $('#detail-alamat').val(response.alamat);
                    $('#detail-no-telp').val(response.no_telp);
                    $('#detail-angkatan').val(response.angkatan);
                    $('#detail-kelas').val(response.kelas);
                    $('#detail-jenis-kelamin').val(response.jenis_kelamin);
                    $('#detail-id-telegram').val(response.id_telegram);
                    $('#detail-tanggal-lahir').val(response.tanggal_lahir);
                    $('#detail-password').val(response.password);

                }
            });
        });
        $('#btnReset').click(function() {
            localStorage.removeItem("filter_angkatan");
            localStorage.removeItem("filter_kelas");
            $('#filterAngkatan').val('');
            $('#filterKelas').val('');
        });

    </script>
@endpush
