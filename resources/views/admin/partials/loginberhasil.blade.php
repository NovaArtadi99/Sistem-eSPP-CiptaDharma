<div class="modal fade" id="loginSuccessModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-body text-center p-4">
                <div class="mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="green"
                        class="bi bi-check-circle" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                    </svg>
                </div>
                <h3 class="mb-3 text-success">Login Berhasil</h3>
                <p class="text-muted mb-4">
                    @if (Auth::check())
                        Selamat datang di Halaman Admin, <strong>{{ Auth::user()->nama }}</strong>
                    @endif
                </p>
                <div class="d-grid">
                    @can('owner')
                        <a href="{{ route('dashboard') }}" class="btn btn-success btn-lg">
                            Lanjutkan ke Dashboard
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    @else
                        <button type="button" class="btn btn-secondary btn-lg" id="okButton">
                            OK
                        </button>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            // Tambahkan backdrop static agar modal tidak tertutup saat diklik di luar
            $('#loginSuccessModal').modal({
                backdrop: 'static',
                keyboard: false
            });

            // Tampilkan modal
            $('#loginSuccessModal').modal('show');

            // Atur event tombol OK
            $('#okButton').on('click', function() {
                $('#loginSuccessModal').modal('hide'); // Tutup modal secara manual
            });

            // Atur timeout untuk menutup modal otomatis
            setTimeout(function() {
                $('#loginSuccessModal').modal('hide');
            }, 10000); // 5 detik
        });
    </script>
@endpush
