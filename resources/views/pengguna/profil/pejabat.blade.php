@extends('pengguna.layouts.app')

@section('page_bg', 'ds-bg-plain')

@section('content')

  {{-- ====== BREADCRUMB ====== --}}
  <nav aria-label="breadcrumb" class="container my-2">
    <ol class="breadcrumb small mb-0">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
      <li class="breadcrumb-item"><a href="{{ url('/profil') }}">Profil</a></li>
      <li class="breadcrumb-item active" aria-current="page">Pejabat</li>
    </ol>
  </nav>

  <section class="py-4">
    <div class="container">
      <div class="row gx-lg-5 justify-content-center">

        {{-- KOLOM KIRI: KONTEN UTAMA --}}
        <div class="col-lg-8">
            <article class="ds-article-card">
                <h1 class="ds-article-title mb-4">Pejabat Dinas Sosial Kalimantan Selatan</h1>

                {{-- KARTU KEPALA DINAS --}}
                <div class="ds-kadis-card mb-5" style="background-image: url('{{ asset('images/profil/' . $pejabat['kepala']['background']) }}');">
                    <div class="ds-kadis-overlay"></div>
                    <div class="ds-kadis-content">
                        <div class="ds-kadis-photo">
                            <img src="{{ asset('images/profil/' . $pejabat['kepala']['foto']) }}" alt="{{ $pejabat['kepala']['nama'] }}">
                        </div>
                        <div class="ds-kadis-text">
                            <h4 class="mb-1">{{ $pejabat['kepala']['nama'] }}</h4>
                            <p class="text-white mb-3">{{ $pejabat['kepala']['jabatan'] }}</p>
                            <p class="ds-kadis-sambutan mb-0 fst-italic">"{{ $pejabat['kepala']['sambutan'] }}"</p>
                        </div>
                    </div>
                </div>

{{-- GRID PEJABAT LAINNYA --}}
<div class="row g-3">
    @foreach($pejabat['lainnya'] as $p)
        {{-- Mengubah kolom menjadi 2 di mobile (col-6) dan 3 di desktop (col-md-4) --}}
        <div class="col-6 col-md-4">
            <div class="ds-pejabat-card h-100">
                <div class="ds-pejabat-photo-wrapper">
                    <img src="{{ asset('images/profil/' . $p['foto']) }}" alt="{{ $p['nama'] }}" class="ds-pejabat-photo">
                </div>
                <div class="ds-pejabat-info">
                    <h6 class="mb-0 fw-bold">{{ $p['nama'] }}</h6>
                    <p class="mb-0 small text-muted">{{ $p['jabatan'] }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>

                {{-- TOMBOL BAGIKAN --}}
                <hr class="my-4">
                <div class="d-flex align-items-center gap-3">
                  <span class="fw-semibold">Bagikan:</span>
                  <div class="ds-share-buttons">
                    <a href="#" class="ds-share-btn-whatsapp" aria-label="Bagikan ke WhatsApp"><i class="bi bi-whatsapp"></i></a>
                    <a href="#" class="ds-share-btn-facebook" aria-label="Bagikan ke Facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="ds-share-btn-instagram" aria-label="Bagikan ke Instagram"><i class="bi bi-instagram"></i></a>
                  </div>
                </div>
            </article>
        </div>

        {{-- KOLOM KANAN: SIDEBAR JELAJAHI PROFIL --}}
        <div class="col-lg-4">
          <div class="ds-sidebar-card">
            <h5 class="ds-sidebar-title">Jelajahi Profil</h5>
            <div class="ds-sidebar-list">
              @foreach($allProfiles as $item)
                <a href="{{ $item['url'] }}" class="ds-sidebar-item-layanan {{ $item['active'] ? 'active' : '' }}">
                  <img src="{{ asset('images/profil/' . $item['img']) }}" alt="">
                  <h6 class="ds-sidebar-item-title">{{ $item['title'] }}</h6>
                </a>
              @endforeach
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

@endsection
