@extends('layouts.app')

@section('page_bg', 'ds-bg-abstract')

@section('content')

  {{-- ====== BREADCRUMB ====== --}}
  <nav aria-label="breadcrumb" class="container my-2">
    <ol class="breadcrumb small mb-0">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
      <li class="breadcrumb-item active" aria-current="page">Hasil Pencarian</li>
    </ol>
  </nav>

  <section class="py-5">
    <div class="container">

      {{-- =================================== --}}
      {{-- TAMPILAN DESKTOP (LG & DI ATASNYA) --}}
      {{-- =================================== --}}
      <div class="d-none d-lg-block">
        <div class="row g-4 g-lg-5">
          {{-- KOLOM KIRI: JUDUL + HASIL PENCARIAN --}}
          <div class="col-lg-8">
            <div class="ds-results-card">
              {{-- Judul Halaman --}}
              <div class="mb-4">
                <h1 class="fw-bold">Hasil Pencarian</h1>
                @if($keyword)
                  <p class="lead text-muted">Menampilkan hasil untuk: "{{ $keyword }}"</p>
                @endif
              </div>
              {{-- Kontainer Hasil Pencarian --}}
              <div class="ds-search-results-container">
                @forelse ($results as $result)
                  <div class="ds-search-result-item">
                    <a href="{{ $result['url'] }}" class="ds-result-title">{{ $result['title'] }}</a>
                    <div class="ds-result-meta">
                      <span>{{ $result['date'] }}</span> -
                      <span class="fw-semibold">{{ $result['category'] }}</span>
                    </div>
                    <p class="ds-result-summary">{{ $result['summary'] }}</p>
                  </div>
                @empty
                  <div class="text-center py-5">
                    <p class="text-muted">Tidak ada hasil yang ditemukan.</p>
                  </div>
                @endforelse
              </div>
            </div>
          </div>
          {{-- KOLOM KANAN: FILTER KATEGORI --}}
          <div class="col-lg-4">
            <div class="ds-filter-card sidebar-sticky">
              <h5 class="ds-filter-title">Filter Kategori</h5>
              <ul class="ds-filter-list list-unstyled">
                @foreach ($filters as $filter)
                  <li>
                    {{-- Link filter sekarang dinamis --}}
                    <a href="{{ route('pencarian.index', ['keyword' => $keyword, 'kategori' => $filter['slug']]) }}"
                       class="{{ $activeFilter == $filter['slug'] ? 'active' : '' }}">
                      <span>{{ $filter['name'] }}</span>
                      <span class="ds-filter-count">{{ $filter['count'] }}</span>
                    </a>
                  </li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      </div>

      {{-- =================================== --}}
      {{-- TAMPILAN MOBILE (MD & DI BAWAHNYA) --}}
      {{-- =================================== --}}
      <div class="d-lg-none">
        {{-- Judul Halaman --}}
        <div class="mb-4 text-center">
          <h2 class="fw-bold">Hasil Pencarian</h2>
          @if($keyword)
            <p class="lead text-muted">Menampilkan hasil untuk: "{{ $keyword }}"</p>
          @endif
        </div>

        {{-- Filter Kategori (Tanpa Kartu & Judul) --}}
        <div class="ds-faq-filters d-flex justify-content-center flex-wrap gap-2 mb-4">
            @foreach ($filters as $filter)
                {{-- Link filter sekarang dinamis --}}
                <a href="{{ route('pencarian.index', ['keyword' => $keyword, 'kategori' => $filter['slug']]) }}"
                   class="btn btn-sm ds-faq-filter-btn {{ $activeFilter == $filter['slug'] ? 'active' : '' }}">
                    {{ $filter['name'] }}
                </a>
            @endforeach
        </div>

        {{-- Hasil Pencarian (Bentuk Kartu) --}}
        <div class="ds-results-card">
            <div class="ds-search-results-container">
                @forelse ($results as $result)
                  <div class="ds-search-result-item">
                    <a href="{{ $result['url'] }}" class="ds-result-title">{{ $result['title'] }}</a>
                    <div class="ds-result-meta">
                      <span>{{ $result['date'] }}</span> -
                      <span class="fw-semibold">{{ $result['category'] }}</span>
                    </div>
                    <p class="ds-result-summary">{{ $result['summary'] }}</p>
                  </div>
                @empty
                  <div class="text-center py-5">
                    <p class="text-muted">Tidak ada hasil yang ditemukan.</p>
                  </div>
                @endforelse
            </div>
        </div>
      </div>

    </div>
</section>
@endsection
