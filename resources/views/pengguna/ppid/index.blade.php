@extends('pengguna.layouts.app')

@section('page_bg', 'ds-bg-abstract')

@section('content')

  {{-- ====== BREADCRUMB ====== --}}
  <nav aria-label="breadcrumb" class="container my-2">
    <ol class="breadcrumb small mb-0">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
      <li class="breadcrumb-item active" aria-current="page">PPID</li>
    </ol>
  </nav>

  {{-- ====== HERO (dinamis) ====== --}}
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

  {{-- ====== GRID KARTU (gabungan statis & dinamis) ====== --}}
@php
    // Siapkan kartu dinamis dari controller
    $dynamicCard = null;
    if (isset($keterbukaanCard)) {
        $dynamicCard = [
            'title' => $keterbukaanCard->nama_kategori,
            'img'   => $keterbukaanCard->icon,
            'url'   => route('ppid.show', $keterbukaanCard->slug) // <-- PERUBAHAN DI SINI
        ];
    }
    // Gabungkan dengan kartu statis
    $cards = [
      ['title' => 'Profil PPID', 'img' => 'Profil_PPID.png', 'url' => url('/ppid/profil')],
      $dynamicCard, // Sisipkan kartu dinamis di tengah
      ['title' => 'Prosedur Permohonan & Keberatan', 'img' => 'Tata_Cara_Memperoleh_Informasi_dan_Pengajuan_Keberatan.png', 'url' => url('/ppid/prosedur-permohonan-keberatan')],
    ];
    // Hilangkan entri yang mungkin kosong
    $cards = array_filter($cards);
@endphp

  <section class="ds-layanan py-5">
    <div class="konten-utama">
        {{-- DESKTOP --}}
        <div class="d-none d-md-block">
        <div class="row ds-layanan-row g-3 justify-content-center">
            @foreach($cards as $c)
            <div class="col-12 col-md-6 col-lg-3 d-flex">
                <a href="{{ $c['url'] }}" class="card ds-layanan-card text-center w-100 text-decoration-none text-dark">
                <div class="ds-layanan-icon-wrapper">
                    <img src="{{ asset('storage/icon/'.$c['img']) }}" alt="{{ $c['title'] }}">
                </div>
                <div class="card-body">
                    <h6 class="card-title fw-semibold">{{ $c['title'] }}</h6>
                </div>
                </a>
            </div>
            @endforeach
        </div>
        </div>
        {{-- MOBILE --}}
        <div class="d-md-none">
          <div class="row g-2 ds-layanan-row-mobile justify-content-center">
            @foreach($cards as $c)
              <div class="col-6">
                <a href="{{ $c['url'] }}" class="card ds-layanan-card ds-card-compact text-center h-100 text-decoration-none text-dark">
                  <div class="ds-layanan-icon-wrapper">
                    <img src="{{ asset('storage/icon/'.$c['img']) }}" alt="{{ $c['title'] }}">
                  </div>
                  <div class="card-body p-3">
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
