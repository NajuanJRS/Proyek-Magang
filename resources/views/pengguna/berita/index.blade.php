@extends('pengguna.layouts.app')

@section('page_bg', 'ds-bg-abstract')

@section('content')

  {{-- ====== BREADCRUMB ====== --}}
  <nav aria-label="breadcrumb" class="container my-2">
    <ol class="breadcrumb small mb-0">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
      <li class="breadcrumb-item active" aria-current="page">Berita</li>
    </ol>
  </nav>

  {{-- ====== HERO ====== --}}
  <section class="ds-hero ds-hero-profil">
    <img src="{{ asset('images/hero/hero-profil.jpg') }}" alt="Hero Berita" class="ds-hero-bg" loading="lazy">
    <div class="ds-hero-overlay"></div>
    <div class="container ds-hero-inner text-center text-white">
      <h1 class="ds-hero-title">Berita & Kegiatan</h1>
      <p class="ds-hero-sub">Ikuti berita, kegiatan, dan pengumuman terbaru dari Dinas Sosial Provinsi Kalimantan Selatan.</p>
    </div>
  </section>

  {{-- ====== KONTEN BERITA ====== --}}
  <section class="py-5">
    <div class="konten-berita">

      {{-- LOGIKA TAMPILAN: Halaman 1 berbeda dengan halaman selanjutnya --}}
      @if ($berita->currentPage() == 1 && $berita->isNotEmpty())
        
        @php
          $featuredNews = $berita->first();
          $regularNews = $berita->slice(1);
        @endphp

        {{-- TAMPILAN DESKTOP --}}
        <div class="d-none d-md-block">
          @if($featuredNews)
            <a href="{{ route('berita.show', $featuredNews->id_berita) }}" class="ds-featured-news text-decoration-none text-dark mb-4">
              <img src="{{ asset('storage/berita/' . $featuredNews->gambar1) }}" alt="{{ $featuredNews->judul }}" class="ds-featured-img">
              <div class="ds-featured-body">
                <h2 class="ds-featured-title">{{ $featuredNews->judul }}</h2>
                <p class="ds-featured-summary">{{ Str::limit(strip_tags($featuredNews->isi_berita1), 200) }}</p>
                <div class="mt-auto ds-meta">
                  <span><i class="bi bi-calendar-event me-1"></i> {{ \Carbon\Carbon::parse($featuredNews->tgl_posting)->isoFormat('D MMM YYYY') }}</span>
                  <span class="text-primary"><i class="bi bi-eye me-1"></i> {{ $featuredNews->dibaca }} Kali</span>
                </div>
              </div>
            </a>
            <hr class="my-4">
          @endif
          <div class="row g-3">
            @foreach($regularNews as $item)
            <div class="col-12 col-md-4 col-lg-3">
              <a href="{{ route('berita.show', $item->id_berita) }}" class="ds-news-card h-100">
                <img src="{{ asset('storage/berita/' . $item->gambar1) }}" alt="{{ $item->judul }}">
                <div class="ds-news-card-body">
                  <h6 class="ds-news-title">{{ $item->judul }}</h6>
                  <div class="mt-auto ds-meta small">
                    <span><i class="bi bi-calendar-event me-1"></i> {{ \Carbon\Carbon::parse($item->tgl_posting)->isoFormat('D MMM YYYY') }}</span>
                    <span class="text-primary"><i class="bi bi-eye me-1"></i> {{ $item->dibaca }}</span>
                  </div>
                </div>
              </a>
            </div>
            @endforeach
          </div>
        </div>

        {{-- TAMPILAN MOBILE --}}
        <div class="d-md-none">
          @if($featuredNews)
            <a class="ds-mfeat" href="{{ route('berita.show', $featuredNews->id_berita) }}">
              <img src="{{ asset('storage/berita/' . $featuredNews->gambar1) }}" alt="{{ $featuredNews->judul }}">
              <h3 class="mt-2">{{ $featuredNews->judul }}</h3>
            </a>
            <hr class="my-4">
          @endif
          <div class="row g-3">
            @foreach($regularNews as $item)
              <div class="col-6">
                <a href="{{ route('berita.show', $item->id_berita) }}" class="ds-news-card h-100">
                  <img src="{{ asset('storage/berita/' . $item->gambar1) }}" alt="{{ $item->judul }}">
                  <div class="ds-news-card-body">
                    <h6 class="ds-news-title">{{ $item->judul }}</h6>
                    <div class="mt-auto ds-meta small">
                      <span><i class="bi bi-calendar-event me-1"></i> {{ \Carbon\Carbon::parse($item->tgl_posting)->isoFormat('D MMM YYYY') }}</span>
                      <span class="text-primary"><i class="bi bi-eye me-1"></i> {{ $item->dibaca }}</span>
                    </div>
                  </div>
                </a>
              </div>
            @endforeach
          </div>
        </div>

      @else

        {{-- TAMPILAN HALAMAN SELANJUTNYA (Grid) --}}
        <div class="row g-3">
          @foreach($berita as $item)
          <div class="col-6 col-md-4 col-lg-3">
            <a href="{{ route('berita.show', $item->id_berita) }}" class="ds-news-card h-100">
              <img src="{{ asset('storage/berita/' . $item->gambar1) }}" alt="{{ $item->judul }}">
              <div class="ds-news-card-body">
                <h6 class="ds-news-title">{{ $item->judul }}</h6>
                <div class="mt-auto ds-meta small">
                  <span><i class="bi bi-calendar-event me-1"></i> {{ \Carbon\Carbon::parse($item->tgl_posting)->isoFormat('D MMM YYYY') }}</span>
                  <span class="text-primary"><i class="bi bi-eye me-1"></i> {{ $item->dibaca }}</span>
                </div>
              </div>
            </a>
          </div>
          @endforeach
        </div>

      @endif

      {{-- NAVIGASI PAGINATION --}}
      <div class="d-flex flex-column align-items-center mt-5">
        {{ $berita->links('pengguna.vendor.pagination.custom-links-only') }}
        @if ($berita->hasPages())
          <p class="small text-muted mt-2">
            Showing {{ $berita->firstItem() }} to {{ $berita->lastItem() }} of {{ $berita->total() }} results
          </p>
        @endif
      </div>

    </div>
  </section>

@endsection
