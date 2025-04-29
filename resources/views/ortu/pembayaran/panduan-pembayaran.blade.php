@extends('admin.admin-layout-ortu')
@section('content')
<div class="container py-4">
    <div class="card shadow-sm mb-3">
        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
            <div class="mb-2 mb-md-0">
                <h5 class="card-title mb-1">Cara melakukan pembayaran</h5>
                {{-- <p class="card-text text-muted small">Panduan lengkap pembayaran untuk orang tua siswa.</p> --}}
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-primary btn-sm toggle-detail-btn"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#detailPembayaran"
                        aria-expanded="false"
                        aria-controls="detailPembayaran">
                    Lihat Detail
                </button>
                <a href="{{ route('panduan.export') }}" target="_blank" class="btn btn-success btn-sm">
                    Unduh PDF
                </a>
            </div>
        </div>

        <div class="collapse" id="detailPembayaran">
            <div class="card-body border-top">
                <p class="mb-3">
                    Pembayaran dapat dilakukan melalui transfer bank ke rekening sekolah. Setelah melakukan pembayaran, simpan bukti transfer dan unggah melalui portal sekolah atau serahkan langsung ke bagian administrasi.
                </p>
                <div class="row">
                    <p class="mb-3">
                        <b>
                            1. Buka menu pembayaran.
                        </b>
                    </p>
                    <div class="col-md-4 mb-3">
                        <img src="{{ asset('panduan/langkah1.png') }}" alt="Langkah 1" class="img-fluid rounded shadow-sm">
                    </div>
                    <p class="mb-3">
                        <b>
                            2. Pilih invoice yang ingin dibayarkan, kemudian Tekan Bayar.
                        </b>
                    </p>
                    <div class="col-md-4 mb-3">
                        <img src="{{ asset('panduan/langkah2.png') }}" alt="Langkah 2" class="img-fluid rounded shadow-sm">
                    </div>
                    <p class="mb-3">
                        <b>
                            3. Tekan Submit setelah mengisi form yang telah disediakan.
                        </b>
                    </p>
                    <div class="col-md-4 mb-3">
                        <img src="{{ asset('panduan/langkah3.png') }}" alt="Langkah 2" class="img-fluid rounded shadow-sm">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
    document.getElementById('unduhPdfBtn').addEventListener('click', function () {
        const element = document.getElementById('detailPembayaran');
        const wasCollapsed = !element.classList.contains('show');

        // Jika masih collapse, buka dulu
        if (wasCollapsed) {
            element.classList.add('show'); // buka manual
        }

        // Tunggu sebentar agar tampil sempurna
        setTimeout(() => {
            const opt = {
                margin:       0.5,
                filename:     'panduan_pembayaran.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2 },
                jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
            };

            html2pdf().set(opt).from(element).save().then(() => {
                // Jika sebelumnya collapse, tutup kembali
                if (wasCollapsed) {
                    element.classList.remove('show');
                }
            });
        }, 500); // 500ms agar rendering elemen selesai
    });

</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.querySelector('.toggle-detail-btn');
        const collapseElement = document.getElementById('detailPembayaran');

        collapseElement.addEventListener('show.bs.collapse', function () {
            toggleBtn.textContent = 'Tutup Detail';
        });

        collapseElement.addEventListener('hide.bs.collapse', function () {
            toggleBtn.textContent = 'Lihat Detail';
        });
    });
</script>
@endpush
