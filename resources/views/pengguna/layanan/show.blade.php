@extends('pengguna.layouts.app')

@section('page_bg', 'ds-bg-plain')

@section('content')

  {{-- ====== BREADCRUMB ====== --}}
  <nav aria-label="breadcrumb" class="container my-2">
    <ol class="breadcrumb small mb-0">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
      <li class="breadcrumb-item"><a href="{{ url('/layanan') }}">Layanan</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ $activeCategory->judul_konten }}</li>
    </ol>
  </nav>

  <section class="py-4">
    <div class="container">
      <div class="row gx-lg-5 justify-content-center">

        {{-- KOLOM KIRI: KONTEN UTAMA LAYANAN --}}
        <div class="col-lg-8">
          <article class="ds-article-card">
            {{-- JUDUL KONTEN --}}
            <h2 class="ds-article-title">{{ $activeCategory->judul_konten }}</h2>

            <hr class="my-4">

            {{-- ISI KONTEN (DINAMIS DAN FLEKSIBEL) --}}
            <div class="ds-article-content">
                @if($layananContent)
                    {{-- Blok Konten 1 --}}
                    @if($layananContent->isi_konten1)
                        {!! \App\Helpers\ContentHelper::embedYoutubeVideos($profileContent->isi_konten1) !!}
                    @endif
                    @if($layananContent->gambar1)
                        <figure class="my-4 text-center">
                            <img src="{{ asset('storage/konten/' . $layananContent->gambar1) }}" class="img-fluid rounded shadow-sm">
                        </figure>
                    @endif

                    {{-- Blok Konten 2 --}}
                    @if($layananContent->isi_konten2)
                        {!! \App\Helpers\ContentHelper::embedYoutubeVideos($profileContent->isi_konten2) !!}
                    @endif
                    @if($layananContent->gambar2)
                        <figure class="my-4 text-center">
                            <img src="{{ asset('storage/konten/' . $layananContent->gambar2) }}" class="img-fluid rounded shadow-sm">
                        </figure>
                    @endif

                    {{-- Blok Konten 3 --}}
                    @if($layananContent->isi_konten3)
                        {!! \App\Helpers\ContentHelper::embedYoutubeVideos($profileContent->isi_konten3) !!}
                    @endif
                    @if($layananContent->gambar3)
                        <figure class="my-4 text-center">
                            <img src="{{ asset('storage/konten/' . $layananContent->gambar3) }}" class="img-fluid rounded shadow-sm">
                        </figure>
                    @endif
                @else
                    <p class="text-muted text-center">Konten untuk layanan ini belum tersedia.</p>
                @endif
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

        {{-- KOLOM KANAN: SIDEBAR JELAJAHI LAYANAN --}}
        <div class="col-lg-4">
          <div class="ds-sidebar-card">
            <h5 class="ds-sidebar-title">Jelajahi Layanan</h5>
            <div class="ds-sidebar-list">
              @foreach($allServices as $item)
                <a href="{{ $item->url }}" class="ds-sidebar-item-layanan {{ $item->active ? 'active' : '' }}">
                  <img src="{{ asset('storage/icon/' . $item->icon_konten) }}" alt="{{ $item->judul_konten }}">
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
