@extends('pengguna.layouts.app')
@section('page_bg', 'ds-bg-plain')
@section('content')

  {{-- ====== BREADCRUMB ====== --}}
  <nav aria-label="breadcrumb" class="container my-2">
    <ol class="breadcrumb small mb-0">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
      <li class="breadcrumb-item"><a href="{{ url('/ppid') }}">PPID</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ $pageContent['title'] }}</li>
    </ol>
  </nav>

  <section class="py-4">
    <div class="container">
      <div class="row gx-lg-5 justify-content-center">
        {{-- KOLOM KIRI: DAFTAR FILE --}}
        <div class="col-lg-8">
          <article class="ds-article-card">
            <h2 class="ds-article-title mb-4">{{ $pageContent['title'] }}</h2>
            <div class="ds-download-list">
              @foreach($pageContent['files'] as $file)
                <div class="ds-download-item">
                  <div class="ds-download-icon"><i class="bi bi-file-earmark-pdf"></i></div>
                  <div class="ds-download-info">
                    <h6 class="ds-download-title">{{ $file->nama_file }}</h6>
                    <span class="ds-download-meta">File PDF</span>
                  </div>
                  <a href="{{ route('download.file', ['filename' => $file->file]) }}" class="btn btn-outline-primary ms-auto ds-download-btn">
                    <i class="bi bi-download me-2"></i>Download
                  </a>
                </div>
              @endforeach
            </div>
            {{-- ... Tombol Bagikan ... --}}
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

        {{-- KOLOM KANAN: SIDEBAR PPID (Sudah Benar) --}}
        <div class="col-lg-4">
          <div class="ds-sidebar-card">
            <h5 class="ds-sidebar-title">PPID</h5>
            <div class="ds-sidebar-list">
              @foreach($allPpidItems as $item)
                <a href="{{ $item->url }}" class="ds-sidebar-item-layanan {{ $item->active ? 'active' : '' }}">
                  <img src="{{ asset('storage/icon/' . $item->icon) }}" alt="{{ $item->nama_kategori }}">
                  <h6 class="ds-sidebar-item-title">{{ $item->nama_kategori }}</h6>
                </a>
              @endforeach
            </div>
          </div>
        </div>
        
      </div>
    </div>
  </section>
@endsection
