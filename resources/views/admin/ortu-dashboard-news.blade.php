<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Dashboard Siswa</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #cbd1e0;
        }

        /* Header Navbar Ungu */
        .navbar {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            background-color: white;
            /* ganti dari #5a67d8 */
            padding: 0.75rem 1rem;
            color: #333;
            /* karena background putih, teks sebaiknya gelap */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* beri bayangan agar tidak terlalu flat */
        }

        /* .navbar {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            background-color: #5a67d8;
            padding: 0.75rem 1rem;
            color: white;
        } */

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: bold;
            font-size: 1.1rem;
        }

        .user {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
        }

        .hamburger {
            display: none;
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Menu Bar Atas (Putih) */


        .menu-bar {
            margin: 0 auto;
            display: flex;
            gap: 2rem;
            /* jarak antar menu */
            background-color: #4c51bf;
            padding: 1.25rem 2rem;
            /* lebih tinggi */
            font-size: 1.1rem;
        }

        .menu-bar a i {
            margin-right: 8px;
            /* Atur jarak antara ikon dan teks */
            font-size: 1.25rem;
            /* (Opsional) Ukuran ikon */
        }




        .menu-bar a {
            text-decoration: none;
            color: white;
            font-weight: bold;
            font-size: 1.05rem;
            display: flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            transition: background-color 0.2s ease;
        }

        .menu-bar a:hover {
            background-color: #5a67d8;
        }


        .menu-bar a.active {
            color: rgb(2, 2, 106);
            /* sedikit lebih terang */
        }


        /* Selamat Datang */
        .welcome {
            background-color: white;
            margin: 1rem auto;
            padding: 1rem;
            border-radius: 6px;
        }

        /* Tombol Aksi Bawah */
        .actions {
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
            margin: 2rem auto;
        }

        .actions a {
            text-decoration: none;
            color: #333;
            background-color: white;
            border: none;
            padding: 1rem;
            width: 300px;
            height: 120px;
            font-weight: bold;
            border-radius: 12px;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: background-color 0.3s;
        }

        .actions a:hover {
            background-color: #edf2f7;
        }

        .actions a img {
            max-height: 60px;
            /* Atur tinggi maksimum agar gambar seragam */
            max-width: 100px;
            /* Atur lebar maksimum */
            object-fit: contain;
        }

        .actions a span {
            font-size: 1rem;
        }


        /* Responsive */
        @media (max-width: 768px) {
            .user span {
                display: none;
            }

            .user {
                gap: 0;
                margin-left: 20px;
            }

            .navbar {
                position: relative;
            }

            .menu-bar {
                display: none;
                flex-direction: column;
                background-color: #4c51bf;
                padding: 1rem;
                position: absolute;
                top: 56px;
                left: 0;
                right: 0;
                z-index: 999;
                margin-top: 0px;
            }

            .menu-bar a {
                color: white;
                padding: 10px 0;
            }

            .menu-bar a.active {
                /* color: #e2e8f0; */
                color: rgb(2, 2, 106)
            }

            .menu-bar.show {
                display: flex;
            }

            .hamburger {
                display: block;
                margin-left: auto;
            }

            .actions {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar Header -->
    <nav class="navbar">
        <div class="brand">
            <img src="{{ asset('dist/assets/image/logo_sd_cipta_dharma-removebg-preview.png') }}" alt="Logo SD"
                style="height: 40px;">
            <span>SD Cipta Dharma</span>
        </div>
        <div class="hamburger" id="hamburger">&#9776;</div>
        <a href="{{ route('profil.index') }}" class="user" style="text-decoration: none; color: inherit;">
            <span id="userEmail">{{ Auth::user()->email }}</span>
            {{-- <i class="fas fa-user" style="font-size: 20px; margin-left: 8px;"></i> --}}
            <img src="\admin\demo1\src\media\svg\avatars\001-boy.svg" alt="User">
        </a>

    </nav>


    <!-- Menu Bar -->
    <div class="menu-bar" id="menuBar">
        <a href="#" class="active"><i class="fas fa-home"></i> Dashboard</a>
        <a href="{{ route('profil.index') }}"><i class="fas fa-user"></i> Profil User</a>
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </form>
    </div>


    <!-- Selamat Datang -->
    <div class="welcome" style="
    margin-left: 10px;
    margin-right: 10px;">
        Hai {{ Auth::user()->nama }}, Selamat datang di web E-SPP CHIPTA DHARMA
    </div>

    <!-- 3 Tombol Aksi -->
    {{-- <div class="actions">
    <a href="{{ route('ortu.pembayaran') }}"><i class="fas fa-credit-card"></i> Pembayaran</a>
    <a href="{{ route('ortu.riwayatPembayaran') }}"><i class="fas fa-history"></i> Riwayat Pembayaran</a>
    <a href="{{ route('ortu.panduan') }}"><i class="fas fa-book-open"></i> Panduan Pengguna</a>
</div> --}}
    <div class="actions">
        <a href="{{ route('ortu.pembayaran') }}">
            <img src="{{ asset('dist/assets/image/pembayaran1.png') }}" alt="Pembayaran">
            <span>Pembayaran</span>
        </a>
        <a href="{{ route('ortu.riwayatPembayaran') }}">
            <img src="{{ asset('dist/assets/image/riwayat.png') }}" alt="Riwayat">
            <span>Riwayat Pembayaran</span>
        </a>
        <a href="{{ route('ortu.panduan') }}">
            <img src="{{ asset('dist/assets/image/panduan.png') }}" alt="Panduan">
            <span>Panduan Pengguna</span>
        </a>
    </div>



    <script>
        const hamburger = document.getElementById("hamburger");
        const menuBar = document.getElementById("menuBar");

        hamburger.addEventListener("click", () => {
            menuBar.classList.toggle("show");
            hamburger.innerHTML = menuBar.classList.contains("show") ? "&times;" : "&#9776;";
        });
    </script>

</body>

</html>
