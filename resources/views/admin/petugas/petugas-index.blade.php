@extends('admin.admin-layout')
@section('content')
    <div class="my-3">
        <a href="{{ route('petugas.create') }}" class="btn btn-primary">Tambah petugas</a>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="filterAngkatan">Filter Data Petugas</label>
            <select id="filterJK" name="filter_jenis_kelamin" class="form-control">
                <option value="">Pilih Jenis Kelamin</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>

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
                    <th>Nama Lengkap</th>
                    <th>NIP</th>
                    <th>Jabatan</th>
                    <th>Jenis Kelamin</th>

                    <th>Status</th>
                    <th>Aksi</th> <!-- Kolom untuk aksi -->
                </tr>
            </thead>
            <tbody>
                @foreach ($petugas as $index => $petugas)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $petugas->nama ?? '-' }}</td>
                        <td>{{ $petugas->nip ?? '-' }}</td>
                        <td>
                            <ul>
                                @foreach ($petugas->roles as $role)
                                    <li>{{ $role->name }}</li>
                                @endforeach
                            </ul>


                        </td>
                        <td>{{ $petugas->jenis_kelamin ?? '-' }}</td>

                        <td>
                            @if ($petugas->status == 1)
                                <span class="badge rounded-pill bg-success">Aktif</span>
                            @else
                                <span class="badge rounded-pill bg-danger">Tidak Aktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('petugas.edit', ['petugas' => $petugas->id]) }}"
                                    class="btn btn-block btn-warning my-1">Edit</a>
                                <form action="{{ route('petugas.destroy', ['petugas' => $petugas->id]) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-block btn-danger my-1"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus petugas ini?')">Hapus</button>
                                </form>

                                <button class="btn btn-block btn-info my-1 btnDetailPetugas" data-bs-toggle="modal"
                                    data-bs-target="#detailModal" data-id = "{{ $petugas->id }}">Detail</button>
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
                    <h5 class="modal-title" id="my-modal-title">Detail Petugas</h5>
                    <button class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="detail-nama-lengkap">Nama Lengkap</label>
                        <input type="text" id="detail-nama-lengkap" class="form-control" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="detail-nip">NIP</label>
                        <input type="text" id="detail-nip" class="form-control" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="detail-jabatan">Jabatan</label>
                        <input type="text" id="detail-jabatan" class="form-control" readonly>
                    </div>
                    {{-- <div class="form-group mb-3">
                        <label for="detail-username">Username</label>
                        <input type="text" id="detail-username" class="form-control" readonly>
                    </div> --}}
                    <div class="form-group mb-3">
                        <label for="detail-email">Email</label>
                        <input type="text" id="detail-email" class="form-control" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="detail-jenis-kelamin">Jenis Kelamin</label>
                        <input type="text" id="detail-jenis-kelamin" class="form-control" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="detail-alamat">Alamat</label>
                        <input type="text" id="detail-alamat" class="form-control" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="detail-telepon">Telepon</label>
                        <input type="text" id="detail-telepon" class="form-control" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="detail-agama">Agama</label>
                        <input type="text" id="detail-agama" class="form-control" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="detail-status">Status</label>
                        <div id="detail-status">

                        </div>
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
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            if (localStorage.getItem("filter_jenis_kelamin")) {
                $('#filterJK').val(localStorage.getItem("filter_jenis_kelamin"));
            }
            $.ajax({
                url: "{{ route('petugas.filterAgama') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "filter_jk": $('#filterJK').val(),
                },
                success: function(data) {
                    console.log(data);
                    $('#dataTables').DataTable().destroy();
                    $('#dataTables tbody').empty();

                    $.each(data, function(index, value) {
                        $('#dataTables tbody').append(
                            '<tr>' +
                            '<td>' + (index + 1) + '</td>' +
                            '<td>' + (value.nama ? value.nama : '-') + '</td>' +
                            '<td>' + (value.nip ? value.nip : '-') + '</td>' +
                            '<td>' +
                            '<ul>' +
                            value.roles.map(role => '<li>' + role.name + '</li>').join('') +
                            '</ul>' +
                            '</td>' +
                            '<td>' + (value.jenis_kelamin ? value.jenis_kelamin : '-') +
                            '</td>' +

                            '<td>' + (value.status == 1 ?
                                '<span class="badge rounded-pill bg-success">Aktif</span>' :
                                '<span class="badge rounded-pill bg-danger">Tidak Aktif</span>'
                                ) +
                            '</td>' +
                            '<td>' +
                            '<div class="d-flex gap-1">' +
                            '<a href="/petugas/' + value.id +
                            '/edit" class="btn btn-block btn-warning my-1">Edit</a>' +
                            '<form action="/petugas/' + value.id +
                            '" method="POST" style="display:inline;">' +
                            '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                            '<input type="hidden" name="_method" value="DELETE">' +
                            '<button type="submit" class="btn btn-block btn-danger my-1" onclick="return confirm(\'Apakah Anda yakin ingin menghapus petugas ini?\')">Hapus</button>' +
                            '</form>' +
                            '<button class="btn btn-block btn-info my-1 btnDetailPetugas" data-bs-toggle="modal" data-bs-target="#detailModal" data-id="' +
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
        $('#btnFilter').click(function(e) {
            e.preventDefault();
            localStorage.setItem("filter_jenis_kelamin", $('#filterJK').val());
            $.ajax({
                url: "{{ route('petugas.filterAgama') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "filter_jk": $('#filterJK').val(),
                },
                success: function(data) {
                    $('#dataTables').DataTable().destroy();
                    $('#dataTables tbody').empty();

                    $.each(data, function(index, value) {
                        $('#dataTables tbody').append(
                            '<tr>' +
                            '<td>' + (index + 1) + '</td>' +
                            '<td>' + (value.nama ? value.nama : '-') + '</td>' +
                            '<td>' + (value.nip ? value.nip : '-') + '</td>' +
                            '<td>' +
                            '<ul>' +
                            value.roles.map(role => '<li>' + role.name + '</li>').join('') +
                            '</ul>' +
                            '</td>' +
                            '<td>' + (value.jenis_kelamin ? value.jenis_kelamin : '-') +
                            '</td>' +

                            '<td>' + (value.status == 1 ?
                                '<span class="badge rounded-pill bg-success">Aktif</span>' :
                                '<span class="badge rounded-pill bg-danger">Tidak Aktif</span>'
                                ) +
                            '</td>' +
                            '<td>' +
                            '<div class="d-flex gap-1">' +
                            '<a href="/petugas/' + value.id +
                            '/edit" class="btn btn-block btn-warning my-1">Edit</a>' +
                            '<form action="/petugas/' + value.id +
                            '" method="POST" style="display:inline;">' +
                            '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                            '<input type="hidden" name="_method" value="DELETE">' +
                            '<button type="submit" class="btn btn-block btn-danger my-1" onclick="return confirm(\'Apakah Anda yakin ingin menghapus petugas ini?\')">Hapus</button>' +
                            '</form>' +
                            '<button class="btn btn-block btn-info my-1 btnDetailPetugas" data-bs-toggle="modal" data-bs-target="#detailModal" data-id="' +
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



        $(document).on('click', '.btnDetailPetugas', function(e) {

            // e.preventDefault();
            var dataId = $(this).data('id');

            $.ajax({
                type: "GET",
                url: "{{ route('petugas.show', ['petugas' => ':id']) }}".replace(':id', dataId),
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": dataId
                },
                dataType: "json",
                success: function(response) {
                    $('#detail-nama-lengkap').val(response.nama);
                    $('#detail-nama-lengkap').val(response.nama ?? '-');
                    $('#detail-nip').val(response.nip ?? '-');
                    $('#detail-jabatan').val(response.roles.map(role => role.name).join(', '));
                    // $('#detail-username').val(response.username ?? '-');
                    $('#detail-email').val(response.email ?? '-');
                    $('#detail-jenis-kelamin').val(response.jenis_kelamin ?? '-');
                    $('#detail-alamat').val(response.alamat ?? '-');
                    $('#detail-telepon').val(response.no_telp ?? '-');
                    $('#detail-agama').val(response.agama ?? '-');
                    $('#detail-status').html(response.status == 1 ?
                        '<span class="badge rounded-pill bg-success">Aktif</span>' :
                        '<span class="badge rounded-pill bg-danger">Tidak Aktif</span>');
                }
            });
        });

        $('#btnReset').click(function() {
            localStorage.removeItem("filter_jenis_kelamin");
            $('#filterJK').val('');
            location.reload();
        });
    </script>
@endpush
