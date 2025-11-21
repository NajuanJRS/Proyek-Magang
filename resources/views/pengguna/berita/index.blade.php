@extends('pengguna.layouts.app')

@section('page_bg', 'ds-bg-abstract')

@section('content')

  <nav aria-label="breadcrumb" class="container my-2">
    <ol class="breadcrumb small mb-0">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
      <li class="breadcrumb-item active" aria-current="page">Berita</li>
    </ol>
  </nav>

    @if($header)
    <section class="ds-hero ds-hero-profil">
        <img src="{{ asset('media/' . $header->gambar) }}" alt="{{ $header->headline }}" class="ds-hero-bg">
        <div class="ds-hero-overlay"></div>
        <div class="container ds-hero-inner text-center text-white">
        <h1 class="ds-hero-title">{!! $header->headline !!}</h1>
        <p class="ds-hero-sub">{{ $header->sub_heading }}</p>
        </div>
    </section>
    @endif

  <section class="py-5">
    <div class="konten-berita">

      @if ($berita->currentPage() == 1 && $berita->isNotEmpty())

        @php
          $featuredNews = $berita->first();
          $regularNews = $berita->slice(1);
        @endphp

        <div class="d-none d-md-block">
          @if($featuredNews)
            <a href="{{ route('berita.show', $featuredNews->slug) }}" class="ds-featured-news text-decoration-none text-dark mb-4">
              <img src="{{ asset('media/' . $featuredNews->gambar1) }}" alt="{{ $featuredNews->judul }}" class="ds-featured-img" loading="lazy">
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
              <a href="{{ route('berita.show', $item->slug) }}" class="ds-news-card h-100">
                <img src="{{ asset('media/' . $item->gambar1) }}" alt="{{ $item->judul }}" loading="lazy">
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

        <div class="d-md-none">
          @if($featuredNews)
            <a class="ds-mfeat" href="{{ route('berita.show', $featuredNews->slug) }}">
              <img src="{{ asset('media/' . $featuredNews->gambar1) }}" alt="{{ $featuredNews->judul }}" loading="lazy">
              <h3 class="mt-2">{{ $featuredNews->judul }}</h3>
            </a>
            <hr class="my-4">
          @endif
          <div class="row g-3">
            @foreach($regularNews as $item)
              <div class="col-6">
                <a href="{{ route('berita.show', $item->slug) }}" class="ds-news-card h-100">
                  <img src="{{ asset('media/' . $item->gambar1) }}" alt="{{ $item->judul }}" loading="lazy">
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
            <a href="{{ route('berita.show', $item->slug) }}" class="ds-news-card h-100">
              <img src="{{ asset('media/' . $item->gambar1) }}" alt="{{ $item->judul }}" loading="lazy">
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
      <div class="d-flex flex-column align-items-center mt-5">
        {{ $berita->links('pengguna.vendor.pagination.custom-links-only') }}
        @if ($berita->total() > 0)
            <p class="small text-muted mt-2">
                Menampilkan {{ $berita->count() }} dari {{ $berita->total() }} berita
            </p>
        @endif
      </div>
    </div>
  </section>

@endsection
