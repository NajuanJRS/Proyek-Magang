@extends('pengguna.layouts.app')

{{-- aktifkan background abstrak hanya di halaman ini (opsional) --}}
@section('page_bg', 'ds-bg-abstract')

@section('content')

  {{-- ====== BREADCRUMB ====== --}}
  <nav aria-label="breadcrumb" class="container my-2">
    <ol class="breadcrumb small mb-0">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
      <li class="breadcrumb-item active" aria-current="page">PPID</li>
    </ol>
  </nav>

{{-- ====== HERO (dinamis dari database) ====== --}}
@if($header)
  <section class="ds-hero ds-hero-profil">
    <img src="{{ asset('storage/header/' . $header->gambar) }}" alt="{{ $header->headline }}" class="ds-hero-bg" loading="lazy">
    <div class="ds-hero-overlay"></div>
    <div class="container ds-hero-inner text-center text-white">
      <h1 class="ds-hero-title">{!! $header->headline !!}</h1>
      <p class="ds-hero-sub">{{ $header->sub_heading }}</p>
    </div>
  </section>
@endif

  {{-- ====== GRID KARTU (daftar menu PPID) ====== --}}
  @php
    $cards = [
      ['title' => 'Profil PPID', 'img' => 'Profil_PPID.png', 'url' => url('/ppid/profil')],
      ['title' => 'Keterbukaan Informasi Publik', 'img' => 'Keterbukaan_Informasi_Publik.png', 'url' => url('/ppid/informasi-publik')],
      ['title' => 'Prosedur Permohonan & Keberatan', 'img' => 'Tata_Cara_Memperoleh_Informasi_dan_Pengajuan_Keberatan.png', 'url' => url('/ppid/prosedur-permohonan-keberatan')],
    ];
  @endphp

  <section class="ds-layanan py-5">
    <div class="konten-utama">

      {{-- DESKTOP/TABLET: grid --}}
        <div class="d-none d-md-block">
        <div class="row ds-layanan-row g-3 justify-content-center">
            @foreach($cards as $c)
            <div class="col-12 col-md-6 col-lg-3 d-flex">
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
            {{-- Menggunakan col-6 agar tetap 2 kolom, bisa diubah ke col-12 jika ingin 1 kolom --}}
            <div class="col-6">
              <a href="{{ $c['url'] }}" class="card ds-layanan-card ds-card-compact text-center h-100">
                <div class="ds-layanan-icon-wrapper">
                   {{-- Ikon PPID sepertinya ada di folder 'images/profil/' --}}
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
