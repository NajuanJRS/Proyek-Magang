<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dinsos Prov Kalsel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container-fluid d-flex align-items-center">
            <a class="navbar-brand d-flex align-items-center">
                <!-- Logo besar -->
                <img src="{{ asset('img/Logo dinsos.png') }}" alt="Logo Utama" class="logo-full" id="logoFull">
                <!-- Logo mini -->
                <img src="{{ asset('img/Logo mini.png') }}" alt="Logo Mini" class="d-none" id="logoMini">

                <!-- Tombol hamburger (desktop: minimize, mobile: buka sidebar overlay) -->
                <button id="sidebarToggle" class="btn btn-link text-white ms-1 d-none d-lg-inline-flex" type="button"
                    aria-label="Toggle sidebar">
                    <i class="bi bi-list"></i>
                </button>

                <!-- Tombol khusus mobile untuk membuka sidebar sebagai overlay -->
                <button id="mobileSidebarToggle" class="btn btn-link text-white ms-1 d-inline-flex d-lg-none"
                    type="button" aria-label="Open menu">
                    <i class="bi bi-list"></i>
                </button>

                <span class="brand-text ms-1" id="brandText">Dinas Sosial Provinsi Kalimantan Selatan</span>
            </a>
        </div>
    </nav>

    {{-- Content --}}
    <div class="content">
        @yield('content')
    </div>

    {{-- Sidebar --}}
    @php
        // Tentukan menu yang terbuka berdasarkan route
        $openMenu = '';
        if (request()->routeIs('admin.slider.index') || request()->routeIs('admin.mitra.index')) {
            $openMenu = 'menuBeranda';
        } elseif (request()->routeIs('admin.profile.index') || request()->routeIs('admin.pejabat.index')) {
            $openMenu = 'menuProfil';
        }
    @endphp

    <div class="sidebar" id="sidebarMenu">
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
            <!-- Beranda -->
<li class="nav-item">
    <a class="nav-link d-flex justify-content-between align-items-center {{ request()->routeIs('admin.slider.index') || request()->routeIs('admin.mitra.index') ? 'active' : '' }}"
        data-bs-toggle="collapse" href="#menuBeranda" role="button"
        aria-expanded="false" aria-controls="menuBeranda"
        onclick="toggleArrow(this)">
        <span><i class="bi bi-house"></i> Beranda</span>
        <i class="bi bi-chevron-down small arrow-icon"></i>
    </a>
    <div class="collapse ps-2" id="menuBeranda" data-bs-parent="#sidebarMenu">
        <ul class="nav flex-column ms-3">
            <li>
                <a href="{{ route('admin.slider.index') }}"
                   class="nav-link {{ request()->routeIs('admin.slider.index') ? 'active' : '' }}">
                   Hero Section
                </a>
            </li>
            <li>
                <a href="{{ route('admin.mitra.index') }}"
                   class="nav-link {{ request()->routeIs('admin.mitra.index') ? 'active' : '' }}">
                   Unit Layanan dan Mitra
                </a>
            </li>
        </ul>
    </div>
</li>


            <!-- Profil -->
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center {{ request()->routeIs('admin.headerProfile.index') || request()->routeIs('admin.pejabat.index') || request()->routeIs('admin.profile.index') ? 'active' : '' }}"
                    data-bs-toggle="collapse" href="#menuProfil" role="button" aria-expanded="false"
                    aria-controls="menuProfil" onclick="toggleArrow(this)">
                    <span><i class="bi bi-person"></i> Profil</span>
                    <i class="bi bi-chevron-down small arrow-icon"></i>
                </a>
                <div class="collapse ps-2" id="menuProfil" data-bs-parent="#sidebarMenu">
                    <ul class="nav flex-column ms-3">
                        <li><a href="{{ route('admin.headerProfile.index') }}"
                                class="nav-link {{ request()->routeIs('admin.headerProfile.index') ? 'active' : '' }}">Header</a>
                        </li>
                        <li><a href="{{ route('admin.profile.index') }}"
                                class="nav-link {{ request()->routeIs('admin.profile.index') ? 'active' : '' }}">Kelola
                                Profil</a></li>
                        <li><a href="{{ route('admin.pejabat.index') }}"
                                class="nav-link {{ request()->routeIs('admin.pejabat.index') ? 'active' : '' }}">Profil
                                Pejabat</a></li>
                    </ul>
                </div>
            </li>


            <!-- Menu lainnya -->
            <li>
                <a href="#" class="nav-link"><i class="bi bi-file-earmark-text"></i> Layanan</a>
            </li>
            <li>
                <a href="#" class="nav-link"><i class="bi bi-newspaper"></i> Berita</a>
            </li>
            <li>
                <a href="#" class="nav-link"><i class="bi bi-download"></i> Download</a>
            </li>
            <li>
                <a href="#" class="nav-link"><i class="bi bi-people"></i> PPID</a>
            </li>
            <li>
                <a href="#" class="nav-link"><i class="bi bi-envelope"></i> Kontak</a>
            </li>
            <li>
                <a href="#" class="nav-link"><i class="bi bi-question-circle"></i> FAQ</a>
            </li>
            <li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: block;">
                    @csrf
                    <button type="submit" class="nav-link w-100 text-start" style="border: none; color: inherit;">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Tambahkan script TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/gn30cjhxbd9tmt6en4rk9379il5jrfkmkmajtm1qx0kamzvo/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
</body>

</html>
