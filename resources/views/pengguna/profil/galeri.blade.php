@extends('pengguna.layouts.app')

@section('page_bg', 'ds-bg-plain')

@section('content')

  {{-- ====== BREADCRUMB ====== --}}
  <nav aria-label="breadcrumb" class="container my-2">
    <ol class="breadcrumb small mb-0">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
      <li class="breadcrumb-item"><a href="{{ url('/profil') }}">Profil</a></li>
      <li class="breadcrumb-item active" aria-current="page">Galeri Kami</li>
    </ol>
  </nav>

  <section class="py-4">
    <div class="container">
      <div class="row gx-lg-5 justify-content-center">

        {{-- KOLOM KIRI: KONTEN UTAMA GALERI --}}
        <div class="col-lg-8">
          <article class="ds-article-card">
            <h2 class="ds-article-title mb-4">Galeri Kami</h2>

                {{-- Tampilan Desktop --}}
                <div class="d-none d-md-block">
                <div class="ds-galeri-grid">
                    @forelse($galeriItems as $item)
                    <div class="ds-galeri-card">
                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}">
                        <div class="ds-galeri-overlay">
                        <span class="ds-galeri-title">{{ $item->judul }}</span>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted">Belum ada gambar di galeri.</p>
                    @endforelse
                </div>
                </div>

                {{-- Tampilan Mobile --}}
                <div class="d-md-none">
                <div class="ds-galeri-grid-mobile">
                    @forelse($galeriItems as $item)
                    <div class="ds-galeri-card">
                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}">
                        <div class="ds-galeri-overlay">
                        <span class="ds-galeri-title">{{ $item->judul }}</span>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted">Belum ada gambar di galeri.</p>
                    @endforelse
                </div>
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

        {{-- KOLOM KANAN: SIDEBAR --}}
        <div class="col-lg-4">
          <div class="ds-sidebar-card">
            <h5 class="ds-sidebar-title">Jelajahi Profil</h5>
            <div class="ds-sidebar-list">
              @foreach($allProfiles as $item)
                <a href="{{ $item->url }}" class="ds-sidebar-item-layanan {{ $item->active ? 'active' : '' }}">
                  <img src="{{ asset('storage/' . $item->icon_konten) }}" alt="{{ $item->judul_konten }}">
                  <h6 class="ds-sidebar-item-title">{{ $item->judul_konten }}</h6>
                </a>
              @endforeach
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

@endsection
