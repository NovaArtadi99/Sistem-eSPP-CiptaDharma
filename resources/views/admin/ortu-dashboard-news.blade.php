<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
            background-color: #5a67d8;
            padding: 0.75rem 1rem;
            color: white;
        }

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
            margin: 1rem auto;
            display: flex;
            gap: 1rem;
            background-color: white;
            padding: 0.75rem 1rem;
            /* justify-content: center; */
        }

        .menu-bar a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .menu-bar a.active {
            color: #4c51bf;
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
            gap: 1rem;
            flex-wrap: wrap;
            margin: 1rem auto;
        }

        .actions a {
            text-decoration: none;
            color: #333;
            background-color: white;
            border: none;
            padding: 1rem;
            width: 300px;
            height: 70px;;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .actions a:hover {
            background-color: #edf2f7;
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
            color: #e2e8f0;
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
            <span></span>
            <span>SD Cipta Dharma</span>
        </div>
        <div class="hamburger" id="hamburger">&#9776;</div>
        <div class="user">
            <span id="userEmail">{{ Auth::user()->email}}</span>
            <img src="\admin\demo1\src\media\svg\avatars\001-boy.svg" alt="User">
        </div>
    </nav>

    <!-- Menu Bar -->
    <div class="menu-bar" id="menuBar">
        <a href="#" class="active">📄 Dashboard</a>
        <a href="#">👤 Profil User</a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                                this.closest('form').submit();">🚪 Logout</a>

        </form>
    </div>

    <!-- Selamat Datang -->
    <div class="welcome" style="
    margin-left: 10px;
    margin-right: 10px;">
        Hai {{ Auth::user()->nama}}, Selamat datang di web E-SPP CHIPTA DHARMA
    </div>

    <!-- 3 Tombol Aksi -->
    <div class="actions">
        <a href="{{ route('ortu.pembayaran') }}">📘 Pembayaran</a>
        <a href="{{ route('ortu.riwayatPembayaran') }}">📥 Riwayat Pembayaran</a>
        <a href="#">📖 Panduan Pengguna</a>
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
