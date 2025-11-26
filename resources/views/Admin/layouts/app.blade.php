<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DINSOS PROV KALSEL')</title>
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container-fluid d-flex align-items-center">
        <button id="mobileSidebarToggle"
                class="btn btn-link text-white me-0 d-inline-flex d-lg-none"
                type="button"><i class="bi bi-list"></i></button>

        <a class="navbar-brand mobile-brand d-flex align-items-center d-lg-none">
            <img src="{{ asset('images/dinas-sosial.png') }}" class="mobile-logo" alt="Dinsos Kalsel">
        </a>

        <a class="navbar-brand desktop-brand d-none d-lg-flex align-items-center">
            <img src="{{ asset('img/Logo dinsos.png') }}" class="logo-full" id="logoFull" alt="Dinsos Kalsel">
            <img src="{{ asset('img/Logo mini.png') }}" class="d-none" id="logoMini" alt="Dinsos Kalsel">

            <button id="sidebarToggle"
                    class="btn btn-link text-white d-none d-lg-inline-flex ms-2"
                    type="button">
                <i class="bi bi-list"></i>
            </button>

            <span class="brand-text ms-2" id="brandText">Dinas Sosial Provinsi Kalimantan Selatan</span>
        </a>
        </div>
    </nav>

    @if (session('success'))
        <div id="session-success-toast" data-message="{{ session('success') }}" class="d-none"></div>
    @endif

    {{-- Content --}}
    <div class="content">
        @yield('content')
    </div>

    {{-- Sidebar --}}
    @php
        $activeMenu = '';

        if (request()->routeIs('admin.dashboard')) {
            $activeMenu = 'dashboard';
        } elseif (request()->routeIs('admin.slider.index') || request()->routeIs('admin.mitra.index')) {
            $activeMenu = 'menuBeranda';
        } elseif (
            request()->routeIs('admin.profile.index') ||
            request()->routeIs('admin.pejabat.index') ||
            request()->routeIs('admin.headerProfile.index') ||
            request()->routeIs('admin.galeri.index')
        ) {
            $activeMenu = 'menuProfil';
        } elseif (request()->routeIs('admin.headerLayanan.index') || request()->routeIs('admin.layanan.index')) {
            $activeMenu = 'menuLayanan';
        } elseif (request()->routeIs('admin.headerBerita.index') || request()->routeIs('admin.berita.index')) {
            $activeMenu = 'menuBerita';
        } elseif (
            request()->routeIs('admin.headerDownload.index') ||
            request()->routeIs('admin.kontenDownload.index') ||
            request()->routeIs('admin.fileDownload.index')
        ) {
            $activeMenu = 'menuDownload';
        } elseif (request()->routeIs('admin.headerPpid.index') || request()->routeIs('admin.ppid.index')) {
            $activeMenu = 'menuPPID';
        } elseif (request()->routeIs('admin.headerKontak.index') || request()->routeIs('admin.kontak.index')) {
            $activeMenu = 'menuKontak';
        } elseif (request()->routeIs('admin.faq.index')) {
            $activeMenu = 'faq';
        } elseif (request()->routeIs('admin.kotakMasuk.index')) {
            $activeMenu = 'kotakMasuk';
        } else {
            $activeMenu = '';
        }
    @endphp

    <div class="sidebar" id="sidebarMenu" data-active-menu="{{ $activeMenu }}">
        <div class="admin-profile mb-3 d-flex align-items-center" style="margin-left:-15px;">
            <img src="{{ asset('img/admin.png') }}" alt="Admin" class="rounded-circle me-3" width="64"
                height="64">
            <div>
                <div class="text-muted" style="font-size: 0.95rem;">Welcome,</div>
                <div style="font-weight: 500;">Admin</div>
            </div>
        </div>
        <p class="text-muted">Menu</p>
        <ul class="nav flex-column">

            <!-- Dashboard -->
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link d-flex align-items-center {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>

            <!-- Beranda -->
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center {{ request()->routeIs('admin.slider.index') || request()->routeIs('admin.mitra.index') ? 'active' : '' }}"
                    data-bs-toggle="collapse" href="#menuBeranda" role="button" aria-expanded="false"
                    aria-controls="menuBeranda">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-house"></i>
                        <span class="menu-title">Beranda</span>
                    </div>
                    <i class="bi bi-chevron-down small arrow-icon"></i>
                </a>
                <div class="collapse ps-2" id="menuBeranda" data-bs-parent="#sidebarMenu">
                    <ul class="nav flex-column ms-3">
                        <li><a href="{{ route('admin.slider.index') }}"
                                class="nav-link {{ request()->routeIs('admin.slider.index') ? 'active' : '' }}">Hero
                                Section</a>
                        </li>
                        <li><a href="{{ route('admin.mitra.index') }}"
                                class="nav-link {{ request()->routeIs('admin.mitra.index') ? 'active' : '' }}">Unit
                                Layanan
                                Dan Mitra</a></li>
                    </ul>
                </div>
            </li>

            <!-- Profil -->
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center {{ request()->routeIs('admin.headerProfile.index') || request()->routeIs('admin.pejabat.index') || request()->routeIs('admin.profile.index') ? 'active' : '' }}"
                    data-bs-toggle="collapse" href="#menuProfil" role="button" aria-expanded="false"
                    aria-controls="menuProfil">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-person"></i>
                        <span class="menu-title">Profil</span>
                    </div>
                    <i class="bi bi-chevron-down small arrow-icon"></i>
                </a>
                <div class="collapse ps-2" id="menuProfil" data-bs-parent="#sidebarMenu">
                    <ul class="nav flex-column ms-3">
                        <li><a href="{{ route('admin.headerProfile.index') }}"
                                class="nav-link {{ request()->routeIs('admin.headerProfile.index') ? 'active' : '' }}">Header</a>
                        </li>
                        <li><a href="{{ route('admin.profile.index') }}"
                                class="nav-link {{ request()->routeIs('admin.profile.index') ? 'active' : '' }}">Konten
                                Profil</a></li>
                        <li><a href="{{ route('admin.pejabat.index') }}"
                                class="nav-link {{ request()->routeIs('admin.pejabat.index') ? 'active' : '' }}">Profil
                                Pejabat</a></li>
                        <li><a href="{{ route('admin.galeri.index') }}"
                                class="nav-link {{ request()->routeIs('admin.galeri.index') ? 'active' : '' }}">
                                Galeri</a></li>
                    </ul>
                </div>
            </li>

            <!-- Layanan -->
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center {{ request()->routeIs('admin.headerLayanan.index') || request()->routeIs('admin.layanan.index') ? 'active' : '' }}"
                    data-bs-toggle="collapse" href="#menuLayanan" role="button" aria-expanded="false"
                    aria-controls="menuLayanan">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-file-earmark-text"></i>
                        <span class="menu-title">Layanan</span>
                    </div>
                    <i class="bi bi-chevron-down small arrow-icon"></i>
                </a>
                <div class="collapse ps-2" id="menuLayanan" data-bs-parent="#sidebarMenu">
                    <ul class="nav flex-column ms-3">
                        <li><a href="{{ route('admin.headerLayanan.index') }}"
                                class="nav-link {{ request()->routeIs('admin.headerLayanan.index') ? 'active' : '' }}">Header</a>
                        </li>
                        <li><a href="{{ route('admin.layanan.index') }}"
                                class="nav-link {{ request()->routeIs('admin.layanan.index') ? 'active' : '' }}">Konten
                                Layanan</a></li>
                    </ul>
                </div>
            </li>

            <!-- Berita -->
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center {{ request()->routeIs('admin.headerBerita.index') || request()->routeIs('admin.berita.index') ? 'active' : '' }}"
                    data-bs-toggle="collapse" href="#menuBerita" role="button" aria-expanded="false"
                    aria-controls="menuBerita">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-newspaper"></i>
                        <span class="menu-title">Berita</span>
                    </div>
                    <i class="bi bi-chevron-down small arrow-icon"></i>
                </a>
                <div class="collapse ps-2" id="menuBerita" data-bs-parent="#sidebarMenu">
                    <ul class="nav flex-column ms-3">
                        <li><a href="{{ route('admin.headerBerita.index') }}"
                                class="nav-link {{ request()->routeIs('admin.headerBerita.index') ? 'active' : '' }}">Header</a>
                        </li>
                        <li><a href="{{ route('admin.berita.index') }}"
                                class="nav-link {{ request()->routeIs('admin.berita.index') ? 'active' : '' }}">Konten
                                Berita</a></li>
                    </ul>
                </div>
            </li>

            <!-- Download -->
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center {{ request()->routeIs('admin.headerDownload.index') || request()->routeIs('admin.kontenDownload.index') || request()->routeIs('admin.fileDownload.index') ? 'active' : '' }}"
                    data-bs-toggle="collapse" href="#menuDownload" role="button" aria-expanded="false"
                    aria-controls="menuDownload">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-download"></i>
                        <span class="menu-title">Download</span>
                    </div>
                    <i class="bi bi-chevron-down small arrow-icon"></i>
                </a>
                <div class="collapse ps-2" id="menuDownload" data-bs-parent="#sidebarMenu">
                    <ul class="nav flex-column ms-3">
                        <li><a href="{{ route('admin.headerDownload.index') }}"
                                class="nav-link {{ request()->routeIs('admin.headerDownload.index') ? 'active' : '' }}">Header</a>
                        </li>
                        <li><a href="{{ route('admin.kontenDownload.index') }}"
                                class="nav-link {{ request()->routeIs('admin.kontenDownload.index') || request()->routeIs('admin.fileDownload.index') ? 'active' : '' }}">Konten
                                Download</a></li>
                    </ul>
                </div>
            </li>

            <!-- PPID -->
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center {{ request()->routeIs('admin.headerPpid.index') || request()->routeIs('admin.ppid.index') ? 'active' : '' }}"
                    data-bs-toggle="collapse" href="#menuPPID" role="button" aria-expanded="false"
                    aria-controls="menuPPID">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-people"></i>
                        <span class="menu-title">PPID</span>
                    </div>
                    <i class="bi bi-chevron-down small arrow-icon"></i>
                </a>
                <div class="collapse ps-2" id="menuPPID" data-bs-parent="#sidebarMenu">
                    <ul class="nav flex-column ms-3">
                        <li><a href="{{ route('admin.headerPpid.index') }}"
                                class="nav-link {{ request()->routeIs('admin.headerPpid.index') ? 'active' : '' }}">Header</a>
                        </li>
                        <li><a href="{{ route('admin.ppid.index') }}"
                                class="nav-link {{ request()->routeIs('admin.ppid.index') ? 'active' : '' }}">Konten
                                PPID</a></li>
                    </ul>
                </div>
            </li>

            <!-- Kontak -->
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center {{ request()->routeIs('admin.headerKontak.index') || request()->routeIs('admin.kontak.index') ? 'active' : '' }}"
                    data-bs-toggle="collapse" href="#menuKontak" role="button" aria-expanded="false"
                    aria-controls="menuKontak">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-envelope"></i>
                        <span class="menu-title">Kontak</span>
                    </div>
                    <i class="bi bi-chevron-down small arrow-icon"></i>
                </a>
                <div class="collapse ps-2" id="menuKontak" data-bs-parent="#sidebarMenu">
                    <ul class="nav flex-column ms-3">
                        <li><a href="{{ route('admin.headerKontak.index') }}"
                                class="nav-link {{ request()->routeIs('admin.headerKontak.index') ? 'active' : '' }}">Header</a>
                        </li>
                        <li><a href="{{ route('admin.kontak.index') }}"
                                class="nav-link {{ request()->routeIs('admin.kontak.index') ? 'active' : '' }}">Konten
                                Kontak</a></li>
                    </ul>
                </div>
            </li>

            <!-- FAQ -->
            <li class="nav-item">
                <a href="{{ route('admin.faq.index') }}"
                    class="nav-link d-flex align-items-center {{ request()->routeIs('admin.faq.index') ? 'active' : '' }}">
                    <i class="bi bi-question-circle"></i>
                    <span class="menu-title">FAQ</span>
                </a>
            </li>

            <!-- Kotak Masuk -->
            <li class="nav-item">
                <a href="{{ route('admin.kotakMasuk.index') }}"
                    class="nav-link d-flex align-items-center {{ request()->routeIs('admin.kotakMasuk.index') ? 'active' : '' }}">
                    <i class="bi bi-inbox"></i>
                    <span class="menu-title">Kotak Masuk</span>
                    <span class="badge bg-danger rounded-pill badge-unread {{ ($unreadKotakMasuk ?? 0) > 0 ? '' : 'd-none' }}">
                    {{ $unreadKotakMasuk ?? 0 }}
                    </span>
                </a>
            </li>

            <!-- Kelola Akun -->
            <li class="nav-item">
                <a href="{{ route('admin.adminUpdate.index') }}"
                    class="nav-link d-flex align-items-center {{ request()->routeIs('admin.kelolaAkun.index') ? 'active' : '' }}">
                    <i class="bi bi-person-circle"></i>
                    <span class="menu-title">Kelola Akun</span>
                </a>
            </li>

            <li>
                <a href="#" id="logoutButton" class="nav-link d-flex align-items-center logout-link">
                    <i class="bi bi-box-arrow-right"></i>
                    <span class="menu-title">Logout</span>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    @stack('scripts')

</body>

</html>
