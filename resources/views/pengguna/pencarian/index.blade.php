@extends('pengguna.layouts.app')

@section('page_bg', 'ds-bg-plain')

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
                <h2 class="fw-bold">Hasil Pencarian</h2>
                @if(isset($keyword) && $keyword)
                  <p class="lead text-muted">Menampilkan hasil untuk: "{{ $keyword }}"</p>
                @endif
              </div>
              {{-- Kontainer Hasil Pencarian --}}
              <div class="ds-search-results-container">
                {{-- Tampilkan hasil selain FAQ --}}
                @forelse ($results as $result)
                  @if($result['type'] == 'dokumen')
                    {{-- Tampilan untuk Dokumen --}}
                    {{-- PERBAIKAN: Menambahkan margin-bottom (mb-3) untuk jarak --}}
                    <div class="ds-download-item no-border mb-3">
                      <div class="ds-download-icon">
                        <i class="bi bi-file-earmark-text"></i>
                      </div>
                      <div class="ds-download-info">
                        <h6 class="ds-download-title">{{ $result['title'] }}</h6>
                        <span class="ds-download-meta">{{ $result['category'] }}</span>
                      </div>
                      <a href="{{ $result['url'] }}" class="btn btn-outline-primary ms-auto ds-download-btn">
                        <i class="bi bi-download me-2"></i>Download
                      </a>
                    </div>
                  @else
                    {{-- Tampilan untuk hasil pencarian biasa --}}
                    <div class="ds-search-result-item">
                      <a href="{{ $result['url'] }}" class="ds-result-title">{{ $result['title'] }}</a>
                      <div class="ds-result-meta">
                        <span class="fw-semibold">{{ $result['category'] }}</span>
                      </div>
                    </div>
                  @endif
                @empty
                  {{-- Pesan ini hanya muncul jika TIDAK ADA hasil selain FAQ --}}
                  @if($faq_results->isEmpty())
                    <div class="text-center py-5">
                      <p class="text-muted">Tidak ada hasil yang ditemukan untuk kategori ini.</p>
                    </div>
                  @endif
                @endforelse

                {{-- Tampilkan hasil FAQ dalam bentuk Akordeon --}}
                @if($faq_results->isNotEmpty())
                  {{-- PERBAIKAN: Garis pemisah hanya muncul jika ada hasil lain di atasnya --}}
                  <div class="mt-4 @if($results->isNotEmpty()) pt-4 border-top @endif">
                    <div class="accordion" id="faqAccordion-desktop">
                      @foreach($faq_results as $index => $faq)
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-desktop-{{ $index }}">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-desktop-{{ $index }}" aria-expanded="false" aria-controls="collapse-desktop-{{ $index }}">
                            {{ $faq['title'] }}
                          </button>
                        </h2>
                        <div id="collapse-desktop-{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading-desktop-{{ $index }}" data-bs-parent="#faqAccordion-desktop">
                          <div class="accordion-body">
                            {!! $faq['answer'] !!}
                          </div>
                        </div>
                      </div>
                      @endforeach
                    </div>
                  </div>
                @endif
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
                    <a href="{{ route('pencarian.index', ['keyword' => $keyword, 'kategori' => $filter['slug']]) }}"
                       class="{{ $kategoriAktif == $filter['slug'] ? 'active' : '' }}">
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
          @if(isset($keyword) && $keyword)
            <p class="lead text-muted">Menampilkan hasil untuk: "{{ $keyword }}"</p>
          @endif
        </div>

        {{-- Filter Kategori --}}
        <div class="ds-faq-filters d-flex justify-content-center flex-wrap gap-2 mb-4">
            @foreach ($filters as $filter)
                <a href="{{ route('pencarian.index', ['keyword' => $keyword, 'kategori' => $filter['slug']]) }}"
                   class="btn btn-sm ds-faq-filter-btn {{ $kategoriAktif == $filter['slug'] ? 'active' : '' }}">
                    {{ $filter['name'] }}
                </a>
            @endforeach
        </div>

        {{-- Hasil Pencarian (Bentuk Kartu) --}}
        <div class="ds-results-card">
          <div class="ds-search-results-container">
            {{-- PERBAIKAN: Logika tampilan di-copy dari versi desktop --}}
            @forelse ($results as $result)
              @if($result['type'] == 'dokumen')
                <div class="ds-download-item no-border mb-3">
                  <div class="ds-download-icon">
                    <i class="bi bi-file-earmark-text"></i>
                  </div>
                  <div class="ds-download-info">
                    <h6 class="ds-download-title">{{ $result['title'] }}</h6>
                    <span class="ds-download-meta">{{ $result['category'] }}</span>
                  </div>
                  <a href="{{ $result['url'] }}" class="btn btn-outline-primary ms-auto ds-download-btn">
                    <i class="bi bi-download me-2"></i>Download
                  </a>
                </div>
              @else
                <div class="ds-search-result-item">
                  <a href="{{ $result['url'] }}" class="ds-result-title">{{ $result['title'] }}</a>
                  <div class="ds-result-meta">
                    <span class="fw-semibold">{{ $result['category'] }}</span>
                  </div>
                </div>
              @endif
            @empty
              @if($faq_results->isEmpty())
                <div class="text-center py-5">
                  <p class="text-muted">Tidak ada hasil yang ditemukan untuk kategori ini.</p>
                </div>
              @endif
            @endforelse

            @if($faq_results->isNotEmpty())
              <div class="mt-4 @if($results->isNotEmpty()) pt-4 border-top @endif">
                <div class="accordion" id="faqAccordion-mobile">
                  @foreach($faq_results as $index => $faq)
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="heading-mobile-{{ $index }}">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-mobile-{{ $index }}" aria-expanded="false" aria-controls="collapse-mobile-{{ $index }}">
                        {{ $faq['title'] }}
                      </button>
                    </h2>
                    <div id="collapse-mobile-{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading-mobile-{{ $index }}" data-bs-parent="#faqAccordion-mobile">
                      <div class="accordion-body">
                        {!! $faq['answer'] !!}
                      </div>
                    </div>
                  </div>
                  @endforeach
                </div>
              </div>
            @endif
          </div>
        </div>
      </div>

    </div>
</section>
@endsection

