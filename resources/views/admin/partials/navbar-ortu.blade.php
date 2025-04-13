<nav class="sb-topnav navbar navbar-expand navbar-dark" style="background-color: #4c51bf">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="index.html">E SPP Chipta Dharama</a>

    <!-- Sidebar Toggle (hanya untuk Admin/Kepsek) -->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0 d-none d-lg-block" id="sidebarToggle" type="button">
        <i class="fas fa-bars"></i>
    </button>
    
    <!-- Navbar Profil -->
    <ul class="navbar-nav ms-auto me-3 me-lg-4"> <!-- ms-auto untuk menggeser ke kanan -->
        <li>
            <!-- Tombol hamburger untuk mobile -->
            <button class="btn btn-link text-white d-block d-lg-none" type="button" id="mobileDrawerBtn">
                <i class="fas fa-bars fa-lg"></i>
            </button>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user fa-fw"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="#!">Settings</a></li>
                <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                <li><hr class="dropdown-divider" /></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
                    </form>
                </li>
            </ul>
        </li>
    </ul>
    
</nav>
<style>
    .drawer-link {
        display: inline-block;
        padding: 10px 20px;
        margin: 5px 0;
        color: white;
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 16px;
    }

    .drawer-link i {
        width: 20px;
        text-align: center;
    }

    .drawer-link:hover {
        background-color: rgba(255, 255, 255, 0.2);
        transform: scale(1.05);
    }

    @media (min-width: 992px) {
        #mobileDrawer {
            display: none !important;
        }
    }
</style>


<!-- Overlay Drawer Menu -->
<div id="mobileDrawer" class="position-absolute start-0 w-100 shadow-lg px-4 pt-3 pb-2 text-white"
    style="top: 56px; z-index: 2000; display: none; background-color: #5a63d3; max-height: 300px; overflow-y: auto;">
    <ul class="list-unstyled mb-0 text-center">
        <li>
            <a href="{{ route('dashboard') }}" class="drawer-link">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('ortu.pembayaran') }}" class="drawer-link">
                <i class="fas fa-wallet me-2"></i> Pembayaran
            </a>
        </li>
        <li>
            <a href="{{ route('ortu.riwayatPembayaran') }}" class="drawer-link">
                <i class="fas fa-history me-2"></i> Riwayat Pembayaran
            </a>
        </li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="drawer-link btn btn-link text-danger d-inline-block" type="submit">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </button>
            </form>
        </li>
    </ul>
</div>




<script>
    document.addEventListener('DOMContentLoaded', function () {
        const drawer = document.getElementById('mobileDrawer');
        const toggleBtn = document.getElementById('mobileDrawerBtn');

        toggleBtn?.addEventListener('click', function () {
            const isVisible = drawer.style.display === 'block';
            drawer.style.display = isVisible ? 'none' : 'block';
        });
    });
</script>



