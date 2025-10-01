@extends('layouts.app')

@section('page_bg', 'ds-bg-plain')

@section('content')

  {{-- ====== DATA DUMMY UNTUK SIDEBAR ====== --}}
  @php
    $sidebarArticles = [
      ['title' => 'Upacara Peringatan Hari Pahlawan ke-79', 'image' => 'berita3.jpg', 'url' => '#'],
      ['title' => 'E-Sila Pandu', 'image' => 'berita4.jpg', 'url' => '#'],
      ['title' => 'Rapat Evaluasi Capaian Kinerja Dinas Sosial', 'image' => 'berita5.jpg', 'url' => '#'],
      ['title' => 'CERAMAH KEAGAMAAN', 'image' => 'berita2.jpg', 'url' => '#'],
    ];
  @endphp


  {{-- ====== BREADCRUMB ====== --}}
  <nav aria-label="breadcrumb" class="container my-2">
    <ol class="breadcrumb small mb-0">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
      <li class="breadcrumb-item"><a href="{{ url('/berita') }}">Berita</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($article['title'], 35) }}</li>
    </ol>
  </nav>

  <section class="py-4">
    <div class="container">
      <div class="row gx-lg-5 justify-content-center">

        {{-- KOLOM KIRI: KONTEN UTAMA BERITA --}}
        <div class="col-lg-8">
          <article class="ds-article-card">
            {{-- JUDUL DAN META --}}
            <h2 class="ds-article-title">{{ $article['title'] }}</h2>
            <div class="ds-article-meta">
                <div class="meta-author">{{ $article['author'] }}</div>
                <div class="meta-date">{{ $article['date'] }}</div>
            </div>
            
            <hr class="my-4">

            {{-- KONTEN BERITA (FLEKSIBEL) --}}
            <div class="ds-article-content">
              @if (!empty($article['content']))
                @foreach($article['content'] as $index => $chunk)
                  
                  @if ($chunk['type'] == 'image')
                    <figure class="my-4 text-center">
                      <img src="{{ asset('images/berita/' . $chunk['url']) }}"
                           alt="{{ $chunk['caption'] ?? 'Gambar Berita ' . ($index + 1) }}"
                           class="img-fluid rounded shadow-sm">
                      @if (!empty($chunk['caption']))
                        <figcaption class="figure-caption mt-2">{{ $chunk['caption'] }}</figcaption>
                      @endif
                    </figure>
                  
                  @elseif ($chunk['type'] == 'text')
                    <p>{{ $chunk['content'] }}</p>
                  @endif

                @endforeach
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

        {{-- KOLOM KANAN: SIDEBAR --}}
        <div class="col-lg-4">
          <div class="ds-sidebar-card sidebar-sticky">
            <h5 class="ds-sidebar-title">Berita & Artikel Lainnya</h5>
            <div class="ds-sidebar-list">
              @foreach($sidebarArticles as $item)
                <a href="{{ $item['url'] }}" class="ds-sidebar-item">
                  <img src="{{ asset('images/berita/' . $item['image']) }}" alt="{{ $item['title'] }}">
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
