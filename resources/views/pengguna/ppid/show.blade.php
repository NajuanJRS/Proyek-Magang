@extends('pengguna.layouts.app')

@section('page_bg', 'ds-bg-plain')

@section('content')

  <nav aria-label="breadcrumb" class="container my-2">
    <ol class="breadcrumb small mb-0">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
      <li class="breadcrumb-item"><a href="{{ url('/ppid') }}">PPID</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($activeCategory['slug'], 35) }}</li>
    </ol>
  </nav>

  <section class="py-4">
    <div class="container">
      <div class="row gx-lg-5 justify-content-center">
        <div class="col-lg-8">
          <article class="ds-article-card">
            <h2 class="ds-article-title">{{ $activeCategory->judul_konten }}</h2>
            <hr class="my-4">

            <div class="ds-article-content">
                @if($pageContent)
                    {{-- Blok Konten 1 --}}
                    @if($pageContent->gambar1)
                        <figure class="my-4 text-center">
                            <img src="{{ asset('storage/' . $pageContent->gambar1) }}" class="img-fluid rounded shadow-sm">
                        </figure>
                    @endif
                    @if($pageContent->isi_konten1)
                        {!! \App\Helpers\ContentHelper::embedYoutubeVideos($pageContent->isi_konten1) !!}
                    @endif

                    @if($pageContent->gambar2)
                        <div class="ds-image-zoom-wrapper mt-3" data-bs-toggle="modal" data-bs-target="#imageModal">
                        <img src="{{ asset('storage/' . $pageContent->gambar2) }}" alt="Gambar Konten" class="img-fluid rounded shadow-sm">
                        <div class="ds-image-zoom-overlay">
                            <i class="bi bi-zoom-in"></i>
                            <span>Klik untuk memperbesar</span>
                        </div>
                        </div>
                    @endif
                    @if($pageContent->isi_konten2)
                        {!! \App\Helpers\ContentHelper::embedYoutubeVideos($pageContent->isi_konten2) !!}
                    @endif

                    @if($pageContent->gambar3)
                        <figure class="my-4 text-center">
                            <img src="{{ asset('storage/' . $pageContent->gambar3) }}" class="img-fluid rounded shadow-sm">
                        </figure>
                    @endif
                    @if($pageContent->isi_konten3)
                        {!! \App\Helpers\ContentHelper::embedYoutubeVideos($pageContent->isi_konten3) !!}
                    @endif
                @else
                    <p class="text-muted text-center">Konten untuk halaman ini belum tersedia.</p>
                @endif
            </div>

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

        <div class="col-lg-4">
          <div class="ds-sidebar-card">
            <h5 class="ds-sidebar-title">PPID</h5>
            <div class="ds-sidebar-list">
              @foreach($allPpidItems as $item)
                <a href="{{ $item->url }}" class="ds-sidebar-item-layanan {{ $item->active ? 'active' : '' }}">
                  <img src="{{ asset('storage/' . $item->icon) }}" alt="{{ $item->judul }}">
                  <h6 class="ds-sidebar-item-title">{{ $item->judul }}</h6>
                </a>
              @endforeach
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

    @if($pageContent && $pageContent->gambar1)
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="imageModalLabel">{{ $activeCategory->judul_konten }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
            <img src="{{ asset('storage/' . $pageContent->gambar1) }}" alt="{{ $activeCategory->judul_konten }}" class="img-fluid">
        </div>
        </div>
    </div>
    </div>
    @endif

@endsection
