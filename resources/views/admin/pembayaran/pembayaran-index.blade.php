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
        {{-- <div class="col-4">
            <button type="submit" class="btn btn-outline-primary mt-4" id="btnFilter">Filter</button>
        </div> --}}
        <div class="col-4">
            <button type="submit" class="btn btn-outline-primary mt-4" id="btnFilter">
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
                                {{-- Tombol Lihat Kuitansi --}}
                                @if ($pembayaran->isSentKuitansi == '1')
                                    <a href="{{ route('tagihan.lihatKuitansi', $pembayaran->id) }}"
                                        class="btn btn-sm btn-secondary">Lihat Kuitansi</a>
                                @endif

                                {{-- Tombol Verifikasi --}}
                                @if (
                                    $pembayaran->bukti_pelunasan != null &&
                                        ($pembayaran->status == 'Sedang Diverifikasi' || $pembayaran->status == 'Belum Lunas'))
                                    <button data-bs-toggle="modal" data-bs-target="#verifikasi_{{ $index + 1 }}"
                                        class="btn btn-sm btn-info">Verifikasi</button>
                                @endif

                                @if (
                                    $pembayaran->bukti_pelunasan != null &&
                                        ($pembayaran->status == 'Kurang' || $pembayaran->status == 'Verifikasi Kurang'))
                                    <button onclick="verifikasi_kurang({{ json_encode($pembayaran) }})"
                                        class="btn btn-sm btn-info">Verifikasi</button>
                                @endif

                                {{-- Tombol Lihat Bukti Pembayaran --}}
                                @if (
                                    $pembayaran->bukti_pelunasan != null &&
                                        ($pembayaran->status == 'Sedang Diverifikasi' || $pembayaran->status == 'Verifikasi Kurang'))
                                    <a href="{{ asset('bukti-pelunasan/' . $pembayaran->bukti_pelunasan) }}"
                                        target="_blank" class="btn btn-sm btn-success">Lihat Bukti</a>
                                @endif


                                {{-- Tombol Detail --}}
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
        <div class="modal fade" id="verifikasi_{{ $index + 1 }}" tabindex="-1" role="dialog"
            aria-labelledby="modalTitleId_{{ $index + 1 }}" aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId_{{ $index + 1 }}">
                            Verifikasi Pembayaran
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('verifikasi_nilai', $pembayaran->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <label for="ntagihan">Tagihan</label>
                            <input id="ntagihan_{{ $index }}" type="text" class="form-control" readonly
                                value="{{ 'Rp. ' . number_format($pembayaran->biaya->nominal, 0, ',', '.') }}">
                            <label for="numb">Nominal dikirim</label>
                            <input type="text" class="form-control" id="numb_{{ $index }}"
                                oninput="hitungStatus({{ $index }})"
                                value="{{ number_format($pembayaran->nominal, 0, ',', '.') }}">
                            <input type="hidden" name="nominal" id="real_numb_{{ $index }}"
                                value="{{ $pembayaran->nominal }}">
                            {{-- <input oninput="hitungStatus({{ $index }})" id="numb_{{ $index }}" type="number" class="form-control" name="nominal" value="{{ number_format($pembayaran->nominal, 0, ',', '.') }}"> --}}
                            <label for="status">Status</label>
                            <input id="status_{{ $index }}" type="text" class="form-control" readonly>
                            <div id="bukti_kembali_{{ $index }}" style="display: none;">
                                <label for="bukti_kembali">Bukti tambahan</label>
                                <input id="bukti_kembali_{{ $index }}" type="file" class="form-control"
                                    accept="image/*" name="file_bukti">
                            </div>
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

        <!-- Modal lebih-->
        {{-- <div class="modal fade" id="lebih_{{ $index + 1 }}" tabindex="-1" role="dialog"
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
                            <label for="bukti_kembali">Bukti dikembalikan</label>
                            <input id="bukti_kembali" type="file" class="form-control" accept="image/*"
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
        </div> --}}

        <!-- modal kurang -->
        {{-- <div class="modal fade" id="kurang_{{ $index + 1 }}" tabindex="-1" role="dialog"
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
        </div> --}}
    @endforeach
    <!-- tambahan b -->


    <div class="modal fade" id="VerifikasiKurang" tabindex="-1" aria-labelledby="VerifikasiKurangLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formkurang" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <input type="hidden" name="id" id="id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="verifikasiKurangModalLabel">Verifikasi Pembayaran Kurang</h5>
                    </div>
                    <div class="modal-body">
                        <label for="ntagihank">Tagihan Kurang</label>
                        <input id="ntagihank" type="text" class="form-control" readonly>
                        <label for="numbk">Nominal dikirim</label>
                        <input type="text" class="form-control" id="numbk" oninput="hitungStatusk()">
                        <input type="hidden" name="nominal" id="real_numbk">
                        <label for="statusk">Status</label>
                        <input id="statusk" type="text" class="form-control" readonly>
                        <div id="bukti_kembalik" style="display: none;">
                            <label for="bukti_kembalik">Bukti tambahan</label>
                            <input id="bukti_kembalikk" type="file" class="form-control" accept="image/*"
                                name="file_bukti">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            @foreach ($pembayarans as $index => $pembayaran)
                document.getElementById('verifikasi_{{ $index + 1 }}')
                    .addEventListener('shown.bs.modal', () => {
                        hitungStatus({{ $index }});
                    });

                // Tambahkan event input ke nominal
                document.getElementById(`numb_{{ $index }}`)
                    .addEventListener('input', () => hitungStatus({{ $index }}));
            @endforeach
        });

        function formatRupiah(angka) {
            return 'Rp. ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function hitungStatus(index) {
            const tagihanEl = document.getElementById(`ntagihan_${index}`);
            const nominalEl = document.getElementById(`numb_${index}`);
            const statusEl = document.getElementById(`status_${index}`);
            const buktiEl = document.getElementById(`bukti_kembali_${index}`);
            const realNominalEl = document.getElementById(`real_numb_${index}`);

            const tagihan = parseInt(tagihanEl.value.replace(/\D/g, ''));
            let nominalRaw = nominalEl.value.replace(/\D/g, '');
            let nominal = parseInt(nominalRaw || 0);

            // Update tampilan dengan format Rupiah
            nominalEl.value = formatRupiah(nominal);
            realNominalEl.value = nominal; // Simpan angka asli untuk dikirim

            // Logika status
            if (isNaN(nominal)) {
                statusEl.value = '';
                buktiEl.style.display = 'none';
                return;
            }

            let selisih = nominal - tagihan;
            if (selisih > 0) {
                statusEl.value = `Lebih Rp. ${formatRupiah(selisih).replace('Rp. ', '')}`;
                buktiEl.style.display = 'block';
            } else if (selisih < 0) {
                statusEl.value = `Kurang Rp. ${formatRupiah(Math.abs(selisih)).replace('Rp. ', '')}`;
                buktiEl.style.display = 'none';
            } else {
                statusEl.value = 'Pas';
                buktiEl.style.display = 'none';
            }
        }
    </script>



    {{-- <script>
    document.addEventListener('DOMContentLoaded', () => {
        @foreach ($pembayarans as $index => $pembayaran)
            document.getElementById('verifikasi_{{ $index + 1 }}')
                .addEventListener('shown.bs.modal', () => {
                    hitungStatus({{ $index }});
                });
        @endforeach
    });
    function hitungStatus(index) {
        // Ambil nilai dari input sesuai index
        const tagihanEl = document.getElementById(`ntagihan_${index}`);
        const nominalEl = document.getElementById(`numb_${index}`);
        const statusEl = document.getElementById(`status_${index}`);
        const buktiEl = document.getElementById(`bukti_kembali_${index}`);

        // Ambil nilai tagihan dari string 'Rp. ...'
        const tagihan = parseInt(tagihanEl.value.replace(/\D/g, ''));
        const nominal = parseInt(nominalEl.value.replace(/\D/g, ''));

        if (isNaN(nominal)) {
            statusEl.value = '';
            buktiEl.style.display = 'none';
            return;
        }

        if (nominal > tagihan) {
            statusEl.value = 'Lebih';
            buktiEl.style.display = 'block';
        } else if (nominal < tagihan) {
            statusEl.value = 'Kurang';
            buktiEl.style.display = 'none';
        } else {
            statusEl.value = 'Normal';
            buktiEl.style.display = 'none';
        }
    }
</script> --}}

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
                                                (value.status ==
                                                    'Verifikasi Kurang' ?
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
                                        'Verifikasi Kurang' || value.status ==
                                        'Belum Lunas') ?
                                    // '<a href="javascript:void(0);" class="btn btn-sm btn-info btn-verifikasi" data-id="' +
                                    // value.id + '">Verifikasi</a>' +
                                    '<button data-bs-toggle="modal" data-bs-target="#verifikasi_' +
                                    (index + 1) +
                                    '"class="btn btn-sm btn-info">Verifikasi</button>' +
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

        $('#btnReset').click(function() {
            localStorage.removeItem("filter_angkatan");
            localStorage.removeItem("filter_kelas");
            localStorage.removeItem("filter_tahun");
            localStorage.removeItem("filter_bulan");
            $('#filterAngkatan').val('');
            $('#filterKelas').val('');
            $('#filterTahun').val('');
            $('#filterBulan').val('');
            location.reload();
        });
    </script>
    <!-- tambahan a -->
    <script>
        document.getElementById('btnVerifikasi').addEventListener('click', function() {
            this.style.display = 'none'; // Sembunyikan tombol Verifikasi
            document.getElementById('statusButtons').style.display = 'block'; // Tampilkan tombol lainnya
        });
    </script>
    <!-- tambahan b -->

    <script>
        function verifikasi_kurang(data) {
            hitungStatusk();

            $('#ntagihank').val(`Rp. ${formatRupiah(data.biaya.nominal-data.nominal).replace('Rp. ', '')}`);
            $('#numbk').val(`Rp. ${formatRupiah(data.biaya.nominal-data.nominal).replace('Rp. ', '')}`);
            $('#real_numbk').val(data.biaya.nominal - data.nominal);
            $('#formMethod').val('POST');
            $('#formkurang').attr('action', `/verifikasi_kurang`);
            $('#id').val(data.id);
            $('#VerifikasiKurangLabel').text('Verifikasi Kurang');

            var modal = new bootstrap.Modal(document.getElementById('VerifikasiKurang'));
            modal.show();
        }

        function hitungStatusk() {
            const tagihanEl = document.getElementById(`ntagihank`);
            const nominalEl = document.getElementById(`numbk`);
            const statusEl = document.getElementById(`statusk`);
            const buktiEl = document.getElementById(`bukti_kembalik`);
            const realNominalEl = document.getElementById(`real_numbk`);

            const tagihan = parseInt(tagihanEl.value.replace(/\D/g, ''));
            let nominalRaw = nominalEl.value.replace(/\D/g, '');
            let nominal = parseInt(nominalRaw || 0);

            // Update tampilan dengan format Rupiah
            nominalEl.value = formatRupiah(nominal);
            realNominalEl.value = nominal; // Simpan angka asli untuk dikirim

            // Logika status
            if (isNaN(nominal)) {
                statusEl.value = '';
                buktiEl.style.display = 'none';
                return;
            }

            let selisih = nominal - tagihan;
            if (selisih > 0) {
                statusEl.value = `Lebih Rp. ${formatRupiah(selisih).replace('Rp. ', '')}`;
                buktiEl.style.display = 'block';
            } else if (selisih < 0) {
                statusEl.value = `Kurang Rp. ${formatRupiah(Math.abs(selisih)).replace('Rp. ', '')}`;
                buktiEl.style.display = 'none';
            } else {
                statusEl.value = 'Pas';
                buktiEl.style.display = 'none';
            }
        }
    </script>
@endpush
