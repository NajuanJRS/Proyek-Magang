@extends('pengguna.layouts.app')

@section('page_bg', 'ds-bg-plain')

@section('content')

  {{-- ====== BREADCRUMB ====== --}}
  <nav aria-label="breadcrumb" class="container my-2">
    <ol class="breadcrumb small mb-0">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
      <li class="breadcrumb-item"><a href="{{ url('/profil') }}">Profil</a></li>
      <li class="breadcrumb-item active" aria-current="page">Struktur Organisasi</li>
    </ol>
  </nav>

  <section class="py-4">
    <div class="container">
      <div class="row gx-lg-5 justify-content-center">

        {{-- KOLOM KIRI: KONTEN UTAMA --}}
        <div class="col-lg-8">
          <article class="ds-article-card">
            <h2 class="ds-article-title">{{ $pageData['title'] }}</h2>
            <hr class="my-4">

            {{-- GAMBAR YANG BISA DI-KLIK --}}
            <div class="ds-image-zoom-wrapper" data-bs-toggle="modal" data-bs-target="#imageModal">
              <img src="{{ asset('images/profil/' . $pageData['image']) }}" alt="{{ $pageData['title'] }}" class="img-fluid rounded shadow-sm">
              <div class="ds-image-zoom-overlay">
                <i class="bi bi-zoom-in"></i>
                <span>Klik untuk memperbesar</span>
              </div>
            </div>

            {{-- TOMBOL BAGIKAN --}}
            <hr class="my-4">
            <div class="d-flex align-items-center gap-3">
              <span class="fw-semibold">Bagikan:</span>
              <div class="ds-share-buttons">
                <a href="#" class="ds-share-btn-whatsapp" aria-label="Bagikan ke WhatsApp"><i class="bi bi-whatsapp"></i></a>
                <a href="#" class="ds-share-btn-facebook" aria-label="Bagikan ke Facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="ds-share-btn-instagram   " aria-label="Bagikan ke Instagram"><i class="bi bi-instagram"></i></a>
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

  {{-- ====== MODAL UNTUK ZOOM GAMBAR ====== --}}
  <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="imageModalLabel">{{ $pageData['title'] }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
          <img src="{{ asset('images/profil/' . $pageData['image']) }}" alt="{{ $pageData['title'] }}" class="img-fluid">
        </div>
      </div>
    </div>
  </div>

@endsection
