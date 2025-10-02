@extends('pengguna.layouts.app')

@section('page_bg', 'ds-bg-abstract')  {{-- <- aktifkan background di halaman ini --}}

@section('content')

{{-- =====================
     HERO SECTION (SLIDER)
===================== --}}
<section class="ds-hero position-relative">
  <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="6000">
    <div class="carousel-inner">
      @foreach ($heroSlides as $index => $slide)
        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
          <div class="ds-hero-slide" style="background-image:url('{{ asset('storage/header/' . $slide->gambar) }}');"></div>
          <div class="ds-hero-overlay"></div>
          <div class="container ds-hero-content">
            <div class="col-12 col-lg-7">
              <h1 class="ds-hero-title-beranda">{!! $slide->headline !!}</h1>
              <p class="ds-hero-sub-beranda mb-3 mb-md-4">{{ $slide->sub_heading }}</p>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
      <span class="visually-hidden">Sebelumnya</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
      <span class="visually-hidden">Berikutnya</span>
    </button>
    <div class="carousel-indicators ds-hero-indicators">
      @foreach ($heroSlides as $index => $slide)
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"></button>
      @endforeach
    </div>
  </div>
</section>

{{-- =====================
     LAYANAN UTAMA
===================== --}}
@php
  // Data ini nantinya juga bisa ditarik dari database tabel 'layanan'
  $services = [
    ['title' => 'Pemulangan Orang Telantar', 'img' => 'pemulangan_orang_telantar.png', 'url' => url('/layanan/pemulangan-orang-telantar')],
    ['title' => 'Penerbitan Surat Tanda Pendaftaran Lembaga Kesejahteraan Sosial', 'img' => 'penerbitan_surat_tanda_pendaftaran_lembaga_kesejahteraan_sosial.png', 'url' => url('/layanan/pendaftaran-lks')],
    ['title' => 'Prosedur Pengangkatan Anak', 'img' => 'prosedur_pengangkatan_anak.png', 'url' => url('/layanan/prosedur-pengangkatan-anak')],
    ['title' => 'Penyaluran Logistik Bufferstock Bencana', 'img' => 'penyaluran_logistik_bufferstock_bencana.png', 'url' => url('/layanan/penyaluran-logistik-bencana')],
  ];
@endphp
<section class="ds-layanan py-5">
  <div class="konten-utama">
    <div class="text-center mb-4">
      <h2 class="ds-section-title">Layanan Utama</h2>
    </div>
    {{-- Tampilan Desktop --}}
    <div class="d-none d-md-block">
      <div class="row ds-layanan-row g-3 justify-content-center">
        @foreach($services as $s)
          <div class="col-12 col-md-6 col-lg-3 d-flex">
            <a href="{{ $s['url'] }}" class="card ds-layanan-card text-center w-100 text-decoration-none text-dark">
              <div class="ds-layanan-icon-wrapper">
                <img src="{{ asset('images/layanan/'.$s['img']) }}" alt="{{ $s['title'] }}">
              </div>
              <div class="card-body">
                <h6 class="card-title fw-semibold">{{ $s['title'] }}</h6>
              </div>
            </a>
          </div>
        @endforeach
      </div>
    </div>
    {{-- Tampilan Mobile --}}
    <div class="d-md-none">
      <div class="ds-vstack">
        @foreach($services as $s)
          <a href="{{ $s['url'] }}" class="ds-card-h d-flex align-items-center">
            <img src="{{ asset('images/layanan/'.$s['img']) }}" alt="{{ $s['title'] }}">
            <div class="flex-grow-1">
              <h6 class="mb-0 fw-semibold">{{ $s['title'] }}</h6>
            </div>
          </a>
        @endforeach
      </div>
    </div>
    <div class="text-center mt-4">
      <a href="{{ url('/layanan') }}" class="btn btn-primary">Lihat Semua Layanan</a>
    </div>
  </div>
</section>

{{-- =====================
     PORTAL BERITA (TELAH DIPERBAIKI)
===================== --}}
<section class="ds-news py-5">
  <div class="konten-berita">
    <div class="text-center mb-4">
      <h2 class="fw-semibold">Portal Berita</h2>
    </div>

    @if($berita->isNotEmpty())
        @php $unggulan = $berita->first(); @endphp
        
        {{-- DESKTOP --}}
        <div class="d-none d-md-block">
            <a href="{{ route('berita.show', $unggulan->slug) }}" class="ds-featured-news text-decoration-none text-dark mb-4">
                <img src="{{ asset('storage/berita/' . $unggulan->gambar1) }}" alt="{{ $unggulan->judul }}" class="ds-featured-img">
                <div class="ds-featured-body">
                    <h2 class="ds-featured-title">{{ $unggulan->judul }}</h2>
                    <p class="ds-featured-summary">{{ Str::limit(strip_tags($unggulan->isi_berita1), 200) }}</p>
                    <div class="mt-auto ds-meta">
                        <span><i class="bi bi-calendar-event me-1"></i> {{ \Carbon\Carbon::parse($unggulan->tgl_posting)->isoFormat('D MMM YYYY') }}</span>
                        <span class="text-primary"><i class="bi bi-eye me-1"></i> {{ $unggulan->dibaca }} Kali</span>
                    </div>
                </div>
            </a>
            <hr class="my-4">
            <div class="row g-3">
                @foreach($berita->slice(1, 4) as $item)
                <div class="col-md-4 col-lg-3">
                    <a href="{{ route('berita.show', $item->slug) }}" class="ds-news-card">
                        <img src="{{ asset('storage/berita/' . $item->gambar1) }}" alt="{{ $item->judul }}">
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

        {{-- MOBILE --}}
        <div class="d-md-none">
            <a class="ds-mfeat" href="{{ route('berita.show', $unggulan->slug) }}">
              <img src="{{ asset('storage/berita/' . $unggulan->gambar1) }}" alt="{{ $unggulan->judul }}">
              <h3 class="mt-2">{{ $unggulan->judul }}</h3>
            </a>
            <div class="ds-mnews-list mt-3">
                @foreach($berita->slice(1) as $item)
                    <a href="{{ route('berita.show', $item->slug) }}" class="ds-mnews-item">
                        <img src="{{ asset('storage/berita/' . $item->gambar1) }}" alt="{{ $item->judul }}">
                        <div class="ds-mnews-title">{{ $item->judul }}</div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <div class="text-center mt-4">
        <a href="{{ route('berita.index') }}" class="btn btn-primary">Lihat Semua Berita</a>
    </div>
  </div>
</section>

{{-- =====================
     VISI & MISI
===================== --}}
<section class="ds-visi-misi-card py-5">
  <div class="container">
    <div class="text-center mb-4">
      <h2 class="ds-section-title">Visi & Misi Kami</h2>
    </div>

    <div class="ds-vm-card p-4">
      <h4 class="text-primary text-center mb-3">Visi</h4>
      <p class="text-center mb-4">
        Kalsel Maju (Kalimantan Selatan Makmur, Sejahtera, dan Berkelanjutan)
      </p>

      <h4 class="text-primary text-center mb-3">Misi</h4>

      <!-- wrapper agar list berada di tengah -->
      <div class="misi-wrapper">
        <ol>
          <li>Mengembangkan Sumber Daya Manusia yang Berkualitas dan Berbudi Pekerti Luhur</li>
          <li>Mendorong Pertumbuhan Ekonomi yang Merata</li>
          <li>Memperkuat Sarana Prasarana Dasar dan Perekonomian</li>
          <li>Tata Kelola Pemerintah yang Lebih Fokus Pada Pelayanan Publik</li>
          <li>Menjaga Kelestarian Lingkungan Hidup dan Memperkuat Ketahanan Bencana</li>
        </ol>
      </div>
    </div>
      <div class="text-center mt-4">
        <a href="{{ url('/profil') }}" class="btn btn-primary">Selengkapnya Tentang Kami</a>
      </div>
  </div>
</section>


{{-- ======================
     UNIT & MITRA KERJA
====================== --}}
@php
  $mitra = [
    'mitra1.png','mitra2.png','mitra3.png','mitra4.png'
  ];
@endphp

<section class="ds-mitra py-5">
  <div class="container">
    <h2 class="ds-section-title text-center mb-4">Unit Layanan & Mitra Kerja Kami</h2>

    {{-- DESKTOP/TABLET: grid statis --}}
    <div class="d-none d-md-flex ds-partner-grid">
      @foreach($mitra as $m)
        <div class="ds-partner-item">
          <img src="{{ asset('images/mitra/'.$m) }}" alt="Mitra {{ $loop->index+1 }}">
        </div>
      @endforeach
    </div>

    {{-- MOBILE: horizontal scroll --}}
    <div class="d-md-none ds-partner-scroll">
      <div class="ds-partner-track">
        @foreach($mitra as $m)
          <div class="ds-partner-item">
            <img src="{{ asset('images/mitra/'.$m) }}" alt="Mitra {{ $loop->index+1 }}">
          </div>
        @endforeach
      </div>
    </div>
  </div>
</section>



@endsection
