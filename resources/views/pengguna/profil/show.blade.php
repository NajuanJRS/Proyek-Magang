@extends('pengguna.layouts.app')

@section('page_bg', 'ds-bg-plain') {{-- Menggunakan background polos --}}

@section('content')

  {{-- ====== BREADCRUMB ====== --}}
  <nav aria-label="breadcrumb" class="container my-2">
    <ol class="breadcrumb small mb-0">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
      <li class="breadcrumb-item"><a href="{{ url('/profil') }}">Profil</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($profileContent['title'], 35) }}</li>
    </ol>
  </nav>

  <section class="py-4">
    <div class="container">
      <div class="row gx-lg-5 justify-content-center">

        {{-- KOLOM KIRI: KONTEN UTAMA PROFIL --}}
        <div class="col-lg-8">
          <article class="ds-article-card">
            {{-- JUDUL KONTEN --}}
            <h1 class="ds-article-title">{{ $profileContent['title'] }}</h1>

            <hr class="my-4">

            {{-- ISI KONTEN --}}
            <div class="ds-article-content">
              {!! $profileContent['content'] !!}
            </div>

            {{-- TOMBOL BAGIKAN --}}
            <hr class="my-4">
            <div class="d-flex align-items-center gap-3">
              <span class="fw-semibold">Bagikan:</span>
              <div class="ds-share-buttons">
                <a href="#" class="ds-share-btn-whatsapp" aria-label="Bagikan ke WhatsApp"><i class="bi bi-whatsapp"></i></a>
                <a href="#" class="ds-share-btn-facebook" aria-label="Bagikan ke Facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="ds-share-btn-instagram" aria-label="Bagikan ke Instragram"><i class="bi bi-instagram"></i></a>
              </div>
            </div>
          </article>
        </div>

        {{-- KOLOM KANAN: SIDEBAR JELAJAHI PROFIL --}}
        <div class="col-lg-4">
          {{-- Menggunakan class yang sama dengan sidebar berita & layanan --}}
          <div class="ds-sidebar-card">
            <h5 class="ds-sidebar-title">Jelajahi Profil</h5>
            <div class="ds-sidebar-list">
              @foreach($allProfiles as $item)
                {{-- Menggunakan class yang sama dengan sidebar layanan --}}
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
