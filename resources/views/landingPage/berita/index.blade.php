@extends('layouts.app')

@section('page_bg', 'ds-bg-abstract')

@section('content')

  {{-- ====== DATA DUMMY & LOGIC PAGINATION (DIPERBAIKI) ====== --}}
  @php
    // Karena tidak ada database, kita buat data dummy di sini.
    $dummyBerita = [];
    $sampleImages = ['berita1.jpg', 'berita2.jpg', 'berita3.jpg', 'berita4.jpg', 'berita5.jpg'];

    for ($i = 1; $i <= 24; $i++) {
        $dummyBerita[] = [
            'title' => 'Judul Berita Menarik dan Informatif yang Ke-' . $i,
            'summary' => 'Ini adalah ringkasan singkat untuk berita unggulan. Deskripsi ini menjelaskan poin-poin utama dari artikel yang akan dibaca oleh pengunjung website...',
            'image' => $sampleImages[($i - 1) % count($sampleImages)], // Mengulang gambar sampel
            'date' => now()->subDays($i)->isoFormat('dddd, D MMMM YYYY'),
            'views' => rand(200, 1000),
            'url' => url('/berita/detail-berita-' . $i),
        ];
    }

    // Simulasi Pagination Laravel secara manual dari array
    use Illuminate\Pagination\LengthAwarePaginator;

    $currentPage = LengthAwarePaginator::resolveCurrentPage();

    // === PERBAIKAN LOGIKA DIMULAI DI SINI ===
    $offset = 0;
    $perPage = 12; // Default per halaman

    if ($currentPage == 1) {
        $perPage = 9;
        $offset = 0;
    } else {
        // Offset = (9 item di hal 1) + (12 item * (jumlah halaman sebelumnya))
        $offset = 9 + (($currentPage - 2) * 12);
    }
    // === PERBAIKAN LOGIKA SELESAI ===

    $currentPageItems = array_slice($dummyBerita, $offset, $perPage);

    $berita = new LengthAwarePaginator($currentPageItems, count($dummyBerita), $perPage);
    $berita->setPath(request()->url());
  @endphp


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

{{-- ====== KONTEN BERITA (REVISED MOBILE VIEW) ====== --}}
<section class="py-5">
  <div class="konten-berita">

    {{-- LOGIKA TAMPILAN: Halaman 1 berbeda dengan halaman selanjutnya --}}
    @if ($berita->currentPage() == 1)
      
      @php
        $items = $berita->items();
        $featuredNews = $items[0] ?? null;
        $regularNews = array_slice($items, 1);
      @endphp

      {{-- TAMPILAN DESKTOP / TABLET (Tidak Berubah) --}}
      <div class="d-none d-md-block">
        @if($featuredNews)
          <a href="{{ $featuredNews['url'] }}" class="ds-featured-news text-decoration-none text-dark mb-4">
            <img src="{{ asset('images/berita/' . $featuredNews['image']) }}" alt="{{ $featuredNews['title'] }}" class="ds-featured-img">
            <div class="ds-featured-body">
              <h2 class="ds-featured-title">{{ $featuredNews['title'] }}</h2>
              <p class="ds-featured-summary">{{ $featuredNews['summary'] }}</p>
              <div class="mt-auto ds-meta">
                <span><i class="bi bi-calendar-event me-1"></i> {{ \Carbon\Carbon::parse($featuredNews['date'])->isoFormat('D MMM YYYY') }}</span>
                <span class="text-primary"><i class="bi bi-eye me-1"></i> {{ $featuredNews['views'] }} Kali</span>
              </div>
            </div>
          </a>
          <hr class="my-4">
        @endif
        <div class="row g-3">
          @foreach($regularNews as $item)
          <div class="col-12 col-md-4 col-lg-3">
            <a href="{{ $item['url'] }}" class="ds-news-card">
              <img src="{{ asset('images/berita/' . $item['image']) }}" alt="{{ $item['title'] }}">
              <div class="ds-news-card-body">
                <h6 class="ds-news-title">{{ $item['title'] }}</h6>
                <div class="mt-auto ds-meta small">
                  <span><i class="bi bi-calendar-event me-1"></i> {{ \Carbon\Carbon::parse($item['date'])->isoFormat('D MMM YYYY') }}</span>
                  <span class="text-primary"><i class="bi bi-eye me-1"></i> {{ $item['views'] }}</span>
                </div>
              </div>
            </a>
          </div>
          @endforeach
        </div>
      </div>

      {{-- ==== PERUBAHAN TAMPILAN MOBILE DIMULAI DI SINI ==== --}}
      <div class="d-md-none">
        {{-- Berita Unggulan (tetap sama) --}}
        @if($featuredNews)
          <a class="ds-mfeat" href="{{ $featuredNews['url'] }}">
            <img src="{{ asset('images/berita/' . $featuredNews['image']) }}" alt="Berita unggulan">
            <h3 class="mt-2">{{ $featuredNews['title'] }}</h3>
          </a>
          <hr class="my-4">
        @endif

        {{-- Berita Lainnya (Grid 2 Kolom) --}}
        <div class="row g-3">
            @foreach($regularNews as $item)
                <div class="col-6">
                    <a href="{{ $item['url'] }}" class="ds-news-card h-100">
                      <img src="{{ asset('images/berita/' . $item['image']) }}" alt="{{ $item['title'] }}">
                      <div class="ds-news-card-body">
                        <h6 class="ds-news-title">{{ $item['title'] }}</h6>
                        <div class="mt-auto ds-meta small">
                          <span><i class="bi bi-calendar-event me-1"></i> {{ \Carbon\Carbon::parse($item['date'])->isoFormat('D MMM YYYY') }}</span>
                          <span class="text-primary"><i class="bi bi-eye me-1"></i> {{ $item['views'] }}</span>
                        </div>
                      </div>
                    </a>
                </div>
            @endforeach
        </div>
      </div>
      {{-- ==== PERUBAHAN TAMPILAN MOBILE SELESAI ==== --}}

    @else
      
      {{-- Halaman berikutnya: 12 berita grid (Sama untuk Desktop & Mobile) --}}
      <div class="row g-3">
        @foreach($berita as $item)
        <div class="col-6 col-md-4 col-lg-3">
          <a href="{{ $item['url'] }}" class="ds-news-card">
            <img src="{{ asset('images/berita/' . $item['image']) }}" alt="{{ $item['title'] }}">
            <div class="ds-news-card-body">
              <h6 class="ds-news-title">{{ $item['title'] }}</h6>
              <div class="mt-auto ds-meta small">
                <span><i class="bi bi-calendar-event me-1"></i> {{ \Carbon\Carbon::parse($item['date'])->isoFormat('D MMM YYYY') }}</span>
                <span class="text-primary"><i class="bi bi-eye me-1"></i> {{ $item['views'] }}</span>
              </div>
            </div>
          </a>
        </div>
        @endforeach
      </div>

    @endif
  </div>
</section>
    {{-- NAVIGASI PAGINATION --}}
    <div class="d-flex flex-column align-items-center mt-5">
      {{ $berita->links('vendor.pagination.custom-links-only') }}
      @if ($berita->hasPages())
        <p class="small text-muted mt-2">
          Showing {{ $berita->firstItem() }} to {{ $berita->lastItem() }} of {{ $berita->total() }} results
        </p>
      @endif
    </div>

  </div>
</section>

    </div>
  </section>

@endsection
