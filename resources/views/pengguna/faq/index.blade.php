@extends('pengguna.layouts.app')

@section('page_bg', 'ds-bg-abstract')

@section('content')

  <nav aria-label="breadcrumb" class="container my-2">
    <ol class="breadcrumb small mb-0">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
      <li class="breadcrumb-item"><a href="{{ url('/kontak') }}">Kontak</a></li>
      <li class="breadcrumb-item active" aria-current="page">FAQ</li>
    </ol>
  </nav>

  <section class="ds-faq-section py-5">
    <div class="container">
      <div class="text-center">
        <h2 class="ds-faq-title">FAQ (Pertanyaan Umum)</h2>
        <p class="ds-faq-subtitle">Temukan jawaban cepat untuk pertanyaan umum seputar layanan, program, dan prosedur di Dinas Sosial. Ketik pertanyaan Anda di bawah atau jelajahi berdasarkan kategori.</p>
      </div>

      <div class="ds-faq-search-wrapper mx-auto my-4">
        <form action="{{ route('faq.index', ['kategori' => $kategoriAktif]) }}" method="GET" class="input-group">
          <input type="search" name="keyword" class="form-control" placeholder="Masukkan kata kunci..." aria-label="Cari FAQ" value="{{ $keyword ?? '' }}">
          <button class="btn btn-primary" type="submit" aria-label="Tombol cari">
            <i class="bi bi-search"></i>
          </button>
        </form>
      </div>

<div class="ds-faq-filters d-flex justify-content-center flex-wrap gap-2 mb-4">
  <a href="{{ route('faq.index', ['kategori' => 'semua', 'keyword' => $keyword]) }}"
     class="btn btn-sm ds-faq-filter-btn {{ $kategoriAktif == 'semua' ? 'active' : '' }}">
    Semua <span class="ds-filter-count">{{ $faqCounts['semua'] ?? 0 }}</span>
  </a>
  @foreach($kategoriList as $kategori)
      <a href="{{ route('faq.index', ['kategori' => $kategori->slug, 'keyword' => $keyword]) }}"
         class="btn btn-sm ds-faq-filter-btn {{ $kategoriAktif == $kategori->slug ? 'active' : '' }}">
        {{ $kategori->nama_kategori_faq }} <span class="ds-filter-count">{{ $faqCounts[$kategori->slug] ?? 0 }}</span>
      </a>
  @endforeach
</div>

      <div class="ds-faq-accordion-wrapper mx-auto">
        <div class="accordion" id="faqAccordion">
          @forelse($faqs as $index => $faq)
            <div class="accordion-item">
              <h2 class="accordion-header" id="heading-{{ $index }}">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $index }}" aria-expanded="false" aria-controls="collapse-{{ $index }}">
                  {{ $faq->pertanyaan }}
                </button>
              </h2>
              <div id="collapse-{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $index }}" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                  {!! $faq->jawaban !!}
                </div>
              </div>
            </div>
          @empty
            <div class="text-center text-muted py-5">
              <p>Tidak ada pertanyaan yang cocok dengan pencarian Anda "{{ $keyword ?? '' }}" {{$kategoriAktif != 'semua' ? 'dalam kategori ini' : ''}}.</p>
            </div>
          @endforelse
        </div>
      </div>
    </div>
  </section>
@endsection
