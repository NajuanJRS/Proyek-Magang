@extends('layouts.app')

@section('page_bg', 'ds-bg-plain')

@section('content')

  {{-- ====== BREADCRUMB ====== --}}
  <nav aria-label="breadcrumb" class="container my-2">
    <ol class="breadcrumb small mb-0">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
      <li class="breadcrumb-item"><a href="{{ url('/ppid') }}">PPID</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ $pageContent['title'] }}</li>
    </ol>
  </nav>

  <section class="py-4">
    <div class="container">
      <div class="row gx-lg-5 justify-content-center">

        {{-- KOLOM KIRI: KONTEN UTAMA --}}
        <div class="col-lg-8">
          <article class="ds-article-card">
            <h1 class="ds-article-title">{{ $pageContent['title'] }}</h1>
            <hr class="my-4">

            {{-- ISI KONTEN TEKS --}}
            <div class="ds-article-content">
              {!! $pageContent['content'] !!}
            </div>

            {{-- GAMBAR STRUKTUR ORGANISASI (BISA DI-KLIK) --}}
            <h3 class="mt-5">Struktur PPID</h3>
            <div class="ds-image-zoom-wrapper mt-3" data-bs-toggle="modal" data-bs-target="#imageModal">
              <img src="{{ asset('images/ppid/' . $pageContent['image']) }}" alt="Struktur Organisasi PPID" class="img-fluid rounded shadow-sm">
              <div class="ds-image-zoom-overlay">
                <i class="bi bi-zoom-in"></i>
                <span>Klik untuk memperbesar</span>
              </div>
            </div>

            {{-- === TAMBAHKAN KONTEN BARU DI SINI === --}}
            <div class="ds-article-content mt-4">
                {!! $pageContent['additional_content'] !!}
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

        {{-- KOLOM KANAN: SIDEBAR PPID --}}
        <div class="col-lg-4">
          <div class="ds-sidebar-card">
            <h5 class="ds-sidebar-title">PPID</h5>
            <div class="ds-sidebar-list">
              @foreach($allPpidItems as $item)
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

  {{-- ====== MODAL UNTUK ZOOM GAMBAR ====== --}}
  <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="imageModalLabel">Struktur PPID</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
          <img src="{{ asset('images/ppid/' . $pageContent['image']) }}" alt="Struktur Organisasi PPID" class="img-fluid">
        </div>
      </div>
    </div>
  </div>

@endsection
