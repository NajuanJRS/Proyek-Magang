@extends('pengguna.layouts.app')

@section('page_bg', 'ds-bg-abstract')

@section('content')

  {{-- ====== BREADCRUMB ====== --}}
  <nav aria-label="breadcrumb" class="container my-2">
    <ol class="breadcrumb small mb-0">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
      <li class="breadcrumb-item"><a href="{{ url('/kontak') }}">Kontak</a></li>
      <li class="breadcrumb-item active" aria-current="page">FAQ</li>
    </ol>
  </nav>

  {{-- ====== KONTEN FAQ ====== --}}
  <section class="ds-faq-section py-5">
    <div class="container">
      {{-- Judul Halaman --}}
      <div class="text-center">
        <h1 class="ds-faq-title">FAQ (Pertanyaan Umum)</h1>
        <p class="ds-faq-subtitle">Temukan jawaban cepat untuk pertanyaan umum seputar layanan, program, dan prosedur di Dinas Sosial. Ketik pertanyaan Anda di bawah atau jelajahi berdasarkan kategori.</p>
      </div>

      {{-- Form Pencarian --}}
      <div class="ds-faq-search-wrapper mx-auto my-4">
        <form action="#" method="GET" class="input-group">
          <input type="search" name="keyword" class="form-control" placeholder="Masukkan kata kunci..." aria-label="Cari FAQ">
          <button class="btn btn-primary" type="submit" aria-label="Tombol cari">
            <i class="bi bi-search"></i>
          </button>
        </form>
      </div>

      {{-- Filter Kategori (Sekarang menggunakan link `<a>`) --}}
      <div class="ds-faq-filters d-flex justify-content-center flex-wrap gap-2 mb-4">
        @foreach($kategoriList as $slug => $nama)
          <a href="{{ route('faq.index', ['kategori' => $slug]) }}"
             class="btn btn-sm ds-faq-filter-btn {{ $kategoriAktif == $slug ? 'active' : '' }}">
            {{ $nama }}
          </a>
        @endforeach
      </div>

      {{-- Daftar Pertanyaan (Akordeon) --}}
      <div class="ds-faq-accordion-wrapper mx-auto">
        <div class="accordion" id="faqAccordion">
          @forelse($faqs as $index => $faq)
            <div class="accordion-item">
              <h2 class="accordion-header" id="heading-{{ $index }}">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $index }}" aria-expanded="false" aria-controls="collapse-{{ $index }}">
                  {{ $faq['q'] }}
                </button>
              </h2>
              <div id="collapse-{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $index }}" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                  {{ $faq['a'] }}
                </div>
              </div>
            </div>
          @empty
            <div class="text-center text-muted py-5">
                <p>Tidak ada pertanyaan yang ditemukan untuk kategori ini.</p>
            </div>
          @endforelse
        </div>
      </div>

    </div>
  </section>
@endsection
