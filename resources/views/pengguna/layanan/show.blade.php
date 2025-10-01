@extends('pengguna.layouts.app')

@section('page_bg', 'ds-bg-plain') {{-- Menggunakan background polos --}}

@section('content')

  {{-- ====== BREADCRUMB ====== --}}
  <nav aria-label="breadcrumb" class="container my-2">
    <ol class="breadcrumb small mb-0">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
      <li class="breadcrumb-item"><a href="{{ url('/layanan') }}">Layanan</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($service['title'], 35) }}</li>
    </ol>
  </nav>

  <section class="py-4">
    <div class="container">
      <div class="row gx-lg-5 justify-content-center">

        {{-- KOLOM KIRI: KONTEN UTAMA LAYANAN --}}
        <div class="col-lg-8">
          <article class="ds-article-card">
            {{-- JUDUL LAYANAN --}}
            <h1 class="ds-article-title">{{ $service['title'] }}</h1>
            
            <hr class="my-4">

            {{-- KONTEN LAYANAN (Persyaratan, Prosedur, dll) --}}
            <div class="ds-article-content">
              {!! $service['content'] !!} {{-- Menggunakan {!! !!} agar tag HTML dirender --}}
            </div>

            {{-- TOMBOL BAGIKAN --}}
            <hr class="my-4">
            <div class="d-flex align-items-center gap-3">
              <span class="fw-semibold">Bagikan:</span>
              <div class="ds-share-buttons">
                <a href="#" class="ds-share-btn-whatsapp" aria-label="Bagikan ke WhatsApp"><i class="bi bi-whatsapp"></i></a>
                <a href="#" class="ds-share-btn-facebook" aria-label="Bagikan ke Facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="ds-share-btn-instagram" aria-label="Bagikan ke Telegram"><i class="bi bi-instagram"></i></a>
              </div>
            </div>

          </article>
        </div>

        {{-- KOLOM KANAN: SIDEBAR JELAJAHI LAYANAN --}}
        <div class="col-lg-4">
        <div class="ds-sidebar-card">
            <h5 class="ds-sidebar-title">Jelajahi Layanan</h5>
            <div class="ds-sidebar-list">
            @foreach($allServices as $item)
                <a href="{{ $item['url'] }}" class="ds-sidebar-item-layanan {{ $item['active'] ? 'active' : '' }}">
                {{-- Menggunakan ikon dari gambar --}}
                <img src="{{ asset('images/layanan/' . $item['img']) }}" alt="">
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
