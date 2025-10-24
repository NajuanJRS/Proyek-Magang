@extends('pengguna.layouts.app')

@section('page_bg', 'ds-bg-abstract')

@section('content')

  {{-- ====== BREADCRUMB ====== --}}
  <nav aria-label="breadcrumb" class="container my-2">
    <ol class="breadcrumb small mb-0">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
      <li class="breadcrumb-item"><a href="{{ url('/profil') }}">Profil</a></li>
      <li class="breadcrumb-item active" aria-current="page">Profil Singkat Pejabat</li>
    </ol>
  </nav>

  <section class="py-4">
    <div class="container">
      <div class="row gx-lg-5 justify-content-center">

        {{-- KOLOM KIRI: KONTEN UTAMA --}}
        <div class="col-lg-8">
            <article class="ds-article-card">
                <h2 class="ds-article-title mb-4">Pejabat Dinas Sosial Kalimantan Selatan</h2>

                {{-- KARTU KEPALA DINAS (GAYA BARU) --}}
                @if($pejabatKepala)
                    <div class="ds-kadis-card-new mb-5">
                        {{-- Menampilkan gambar background dari tabel header --}}
                        @if($kadisBackground)
                            <div class="ds-kadis-background" style="background-image: url('{{ asset('storage/' . $kadisBackground->gambar) }}');"></div>
                        @else
                            {{-- Fallback jika gambar tidak ditemukan --}}
                            <div class="ds-kadis-background" style="background-color: #e9ecef;"></div>
                        @endif

                        <div class="ds-kadis-info">
                            <img src="{{ asset('storage/' . $pejabatKepala->gambar) }}" class="ds-kadis-photo-new" alt="{{ $pejabatKepala->nama_pejabat }}">
                            <div class="ds-kadis-nameplate">
                                <h4 class="mb-0">{{ $pejabatKepala->nama_pejabat }}</h4>
                                <p class="text-muted mb-0">{{ $pejabatKepala->jabatan->nama_jabatan }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- GRID PEJABAT LAINNYA (DINAMIS) --}}
                <div class="row g-3">
                    @foreach($pejabatLainnya as $p)
                        <div class="col-6 col-md-4">
                            <div class="ds-pejabat-card h-100">
                                <div class="ds-pejabat-photo-wrapper">
                                    <img src="{{ asset('storage/' . $p->gambar) }}" alt="{{ $p->nama_pejabat }}" class="ds-pejabat-photo">
                                </div>
                                <div class="ds-pejabat-info">
                                    <h6 class="mb-0 fw-bold">{{ $p->nama_pejabat }}</h6>
                                    <p class="mb-0 small text-muted">{{ $p->jabatan->nama_jabatan }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- ... Tombol Bagikan ... --}}
            </article>
        </div>

        {{-- KOLOM KANAN: SIDEBAR JELAJAHI PROFIL --}}
        <div class="col-lg-4">
          <div class="ds-sidebar-card">
            <h5 class="ds-sidebar-title">Jelajahi Profil</h5>
            <div class="ds-sidebar-list">
              @foreach($allProfiles as $item)
                <a href="{{ $item->url }}" class="ds-sidebar-item-layanan {{ $item->active ? 'active' : '' }}">
                  <img src="{{ asset('storage/' . $item->icon_konten) }}" alt="{{ $item->judul_konten }}">
                  <h6 class="ds-sidebar-item-title">{{ $item->judul_konten }}</h6>
                </a>
              @endforeach
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

@endsection

