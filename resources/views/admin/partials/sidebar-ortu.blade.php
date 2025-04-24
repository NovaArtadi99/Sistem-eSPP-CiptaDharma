<div id="layoutSidenav_nav" style="background-color: #4c51bf">
    <nav  style="background-color: #353bb5" class="sb-sidenav accordion sb-sidenav-{{ Auth::user()->roles->first()->name == 'SiswaOrangTua' ? 'gray' : 'dark' }}"
        id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Dashboard
                    {{ Auth::user()->roles->first()->name == 'SiswaOrangTua' ? 'ORANG TUA' : 'ADMIN' }}</div>
                    <a class="{{ Request::routeIs('dashboard') ? 'nav-link active' : 'nav-link' }}" href="{{ route('dashboard') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>

                    @role(['SiswaOrangTua'])
                        <div class="sb-sidenav-menu-heading">Data Master</div>
                        <a class="{{ Request::routeIs('ortu.pembayaran') ? 'nav-link active' : 'nav-link' }}" href="{{ route('ortu.pembayaran') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-credit-card"></i></div>
                            Pembayaran
                        </a>
                        <a class="{{ Request::routeIs('ortu.riwayatPembayaran') ? 'nav-link active' : 'nav-link' }}" href="{{ route('ortu.riwayatPembayaran') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-history"></i></div>
                            Riwayat Pembayaran
                        </a>
                    @endrole

                    @role(['Petugas'])
                        <div class="sb-sidenav-menu-heading">Data Master</div>
                        <a class="{{ Request::routeIs('siswa.index') ? 'nav-link active' : 'nav-link' }}" href="{{ route('siswa.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                            Siswa
                        </a>
                        <a class="{{ Request::routeIs('biaya.index') ? 'nav-link active' : 'nav-link' }}" href="{{ route('biaya.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-money-bill"></i></div>
                            Biaya
                        </a>

                        <a class="nav-link collapsed {{ Request::routeIs('tagihan.index', 'pembayaran.index') ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#collapseTagihan"
                            aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-file-invoice-dollar"></i></div>
                            Data Tagihan
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse {{ Request::routeIs('tagihan.index', 'pembayaran.index') ? 'show' : '' }}" id="collapseTagihan">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="{{ Request::routeIs('tagihan.index') ? 'nav-link active' : 'nav-link' }}" href="{{ route('tagihan.index') }}">Tagihan</a>
                                <a class="{{ Request::routeIs('pembayaran.index') ? 'nav-link active' : 'nav-link' }}" href="{{ route('pembayaran.index') }}">Pembayaran</a>
                            </nav>
                        </div>
                    @endrole

                    @role(['Petugas','KepalaSekolah'])
                        <a class="nav-link collapsed {{ Request::routeIs('laporanPetugas.index', 'laporanSiswa.index', 'laporanSpp.index') ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLaporan"
                            aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                            Data Laporan
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse {{ Request::routeIs('laporanPetugas.index', 'laporanSiswa.index', 'laporanSpp.index') ? 'show' : '' }}" id="collapseLaporan">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="{{ Request::routeIs('laporanPetugas.index') ? 'nav-link active' : 'nav-link' }}" href="{{ route('laporanPetugas.index') }}">Laporan Petugas</a>
                                <a class="{{ Request::routeIs('laporanSiswa.index') ? 'nav-link active' : 'nav-link' }}" href="{{ route('laporanSiswa.index') }}">Laporan Siswa</a>
                                <a class="{{ Request::routeIs('laporanSpp.index') ? 'nav-link active' : 'nav-link' }}" href="{{ route('laporanSpp.index') }}">Laporan SPP</a>
                            </nav>
                        </div>
                    @endrole

                    @role(['Petugas'])
                        <a class="{{ Request::routeIs('petugas.index') ? 'nav-link active' : 'nav-link' }}" href="{{ route('petugas.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-user-tie"></i></div>
                            Data Petugas
                        </a>
                    @endrole



            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Masuk sebagai: {{ Auth::user()->nama }}</div>
        </div>
    </nav>
</div>
