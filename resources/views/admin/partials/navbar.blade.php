<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <style>
        /* Default: tampilkan full title */
        .short-title {
            display: none;
        }

        /* Kalau layar kecil (max-width 576px misalnya) */
        @media (max-width: 576px) {
            .full-title {
                display: none;
            }
            .short-title {
                display: inline;
            }
        }
        </style>

            <a class="navbar-brand ps-3" href="">
                <span class="d-none d-md-inline">E SPP Chipta Dharma</span>
                <span class="d-inline d-md-none">E SPP</span>
            </a>

    {{-- <a class="navbar-brand ps-3" href="index.html">E SPP Chipta Dharma</a> --}}
    <!-- Sidebar Toggle-->
    @if (Auth::user()->nama == "Admin" || Auth::user()->nama == "Kepsek")
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    @endif
    <div class="ms-auto"></div>
    {{-- <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
            class="fas fa-bars"></i></button>
    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <div class="input-group">
            <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..."
                aria-describedby="btnNavbarSearch" />
            <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i
                    class="fas fa-search"></i></button>
        </div>
    </form>
     --}}
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle m,x-" id="navbarDropdown" href="#" role="button"
                data-bs-toggle="dropdown" aria-expanded="false"> <span class="btn btn-outline-light  fw-bold mx-3"> {{ Auth::user()->nama}}</span> <i class="fas fa-user fa-fw"></i></a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="{{ route('profile.index') }}">Profil</a></li>
                {{-- <li><a class="dropdown-item" href="#!">Activity Log</a></li> --}}
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <li>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            this.closest('form').submit();">Keluar</a>

                    </form>
            </ul>
        </li>
    </ul>
</nav>
