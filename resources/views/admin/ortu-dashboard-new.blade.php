@extends('admin.admin-layout-ortu')
@section('content')

<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-md-4 col-12 mb-3">
            <a href="{{ route('ortu.pembayaran') }}" class="text-decoration-none">
                <div class="card custom-card" style="background-image: url('https://source.unsplash.com/300x300/?money');">
                    <div class="card-body text-center d-flex align-items-center justify-content-center">
                        <h5 class="card-title">💳 Pembayaran</h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 col-12 mb-3">
            <a href="{{ route('ortu.riwayatPembayaran') }}" class="text-decoration-none">
                <div class="card custom-card" style="background-image: url('https://source.unsplash.com/300x300/?history');">
                    <div class="card-body text-center d-flex align-items-center justify-content-center">
                        <h5 class="card-title">📜 Riwayat Pembayaran</h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 col-12 mb-3">
            <a href="#" class="text-decoration-none">
                <div class="card custom-card" style="background-image: url('https://source.unsplash.com/300x300/?education');">
                    <div class="card-body text-center d-flex align-items-center justify-content-center">
                        <h5 class="card-title">📖 Tutorial</h5>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<style>
    .custom-card {
        width: 100%;
        aspect-ratio: 4/2; /* Membuat bentuk kotak sama sisi */
        background-size: cover;
        background-position: center;
        color: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        position: relative;
    }

    .custom-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.6));
    }

    .custom-card .card-body {
        position: relative;
        z-index: 2;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }

    .custom-card:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .card-title {
        font-size: 1.2rem;
        font-weight: bold;
    }

    /* Responsif: Ubah ke tampilan vertikal di mobile */
    @media (max-width: 768px) {
        .custom-card {
            width: 100%;
        }
    }
</style>

@endsection