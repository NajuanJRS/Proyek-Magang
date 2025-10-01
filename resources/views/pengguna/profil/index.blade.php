@extends('pengguna.layouts.app')

{{-- aktifkan background abstrak hanya di halaman ini (opsional) --}}
@section('page_bg', 'ds-bg-abstract')

@section('content')

  {{-- ====== BREADCRUMB ====== --}}
  <nav aria-label="breadcrumb" class="container my-2">
    <ol class="breadcrumb small mb-0">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
      <li class="breadcrumb-item active" aria-current="page">Profil</li>
    </ol>
  </nav>

  {{-- ====== HERO (gambar statis, teks di tengah) ====== --}}
  <section class="ds-hero ds-hero-profil">
    <img src="{{ asset('images/hero/hero-profil.jpg') }}" alt="Hero Profil" class="ds-hero-bg" loading="lazy">
    <div class="ds-hero-overlay"></div>
    <div class="container ds-hero-inner text-center text-white">
      <h1 class="ds-hero-title">Profil Dinas Sosial Provinsi Kalimantan Selatan</h1>
      <p class="ds-hero-sub">Selamat datang di halaman Profil Dinas Sosial Provinsi Kalimantan Selatan, tempat Anda bisa mengenal lebih dekat peran kami dalam mewujudkan kesejahteraan sosial.</p>
    </div>
  </section>

  {{-- ====== GRID KARTU (pakai komponen kartu dari Beranda) ====== --}}
  @php
    $cards = [
      ['title' => 'Sejarah Dinas Sosial',                      'img' => 'sejarah.png',        'url' => url('/profil/sejarah')],
      ['title' => 'Visi dan Misi Dinas Sosial',               'img' => 'visi-misi.png',      'url' => url('/profil/visi-misi')],
      ['title' => 'Tugas Pokok dan Fungsi',                   'img' => 'tupoksi.png',        'url' => url('/profil/tugas-pokok-fungsi')],
      ['title' => 'Struktur Organisasi',                      'img' => 'struktur.png',       'url' => url('/profil/struktur-organisasi')],
      ['title' => 'Ruang Lingkup',                            'img' => 'ruang-lingkup.png',  'url' => url('/profil/ruang-lingkup')],
      ['title' => 'Profil Singkat Pejabat',                   'img' => 'pejabat.png',        'url' => url('/profil/pejabat')],
      ['title' => 'Peraturan, Keputusan, dan Kebijakan',      'img' => 'peraturan.png',      'url' => url('/profil/peraturan')],
    ];
  @endphp

  <section class="ds-layanan py-5">
    <div class="konten-utama">

        {{-- DESKTOP/TABLET: grid 4 kolom (lg) dan 2 kolom (md) --}}
        <div class="d-none d-md-block">
        <div class="row ds-layanan-row g-3 justify-content-start">
            @foreach($cards as $c)
            <div class="col-12 col-md-6 col-lg-3 d-flex">
                {{-- Tag <a> sekarang membungkus seluruh kartu --}}
                <a href="{{ $c['url'] }}" class="card ds-layanan-card text-center w-100 text-decoration-none text-dark">
                <div class="ds-layanan-icon-wrapper">
                    <img src="{{ asset('images/profil/'.$c['img']) }}" alt="{{ $c['title'] }}">
                </div>
                <div class="card-body">
                    <h6 class="card-title fw-semibold">{{ $c['title'] }}</h6>
                </div>
                </a>
            </div>
            @endforeach
        </div>
        </div>

{{-- MOBILE: grid 2 kolom, kartu kompak & seluruh kartu bisa ditekan --}}
<div class="d-md-none">
  <div class="row g-2 ds-layanan-row-mobile">
    @foreach($cards as $c)
      <div class="col-6">
        <a href="{{ $c['url'] }}" class="card ds-layanan-card ds-card-compact text-center h-100">
          <div class="ds-layanan-icon-wrapper">
            <img src="{{ asset('images/profil/'.$c['img']) }}" alt="{{ $c['title'] }}">
          </div>
          <div class="card-body p-3 d-flex flex-column">
            <h6 class="card-title fw-semibold mb-0 ds-title-compact">{{ $c['title'] }}</h6>
          </div>
        </a>
      </div>
    @endforeach
  </div>
</div>

    </div>
  </section>

@endsection
