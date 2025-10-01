@extends('pengguna.layouts.app')

@section('page_bg', 'ds-bg-abstract')  {{-- <- aktifkan background di halaman ini --}}

@section('content')

{{-- =====================
     HERO SECTION (SLIDER)
===================== --}}
@php
  $heroSlides = [
    [
      'image'    => asset('images/beranda/foto-beranda1.jpg'),
      'headline' => 'Membangun Kesejahteraan Sosial<br>untuk Kalimantan Selatan',
      'sub'      => 'Akses informasi layanan, program bantuan, dan berita terbaru kami secara mudah dan transparan.',
    ],
    [
      'image'    => asset('images/beranda/foto-beranda2.jpg'),
      'headline' => 'Layanan Tepat Sasaran, Informasi Terintegrasi',
      'sub'      => 'Kami berkomitmen menghadirkan pelayanan sosial yang inklusif, akuntabel, dan transparan.',
    ],
  ];
@endphp

<section class="ds-hero position-relative">
  <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="6000">
    <div class="carousel-inner">
      @foreach ($heroSlides as $i => $s)
        <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
          <div class="ds-hero-slide" style="background-image:url('{{ $s['image'] }}');"></div>
          <div class="ds-hero-overlay"></div>

          <div class="container ds-hero-content">
            <div class="col-12 col-lg-7">
              <h1 class="ds-hero-title-beranda">{!! $s['headline'] !!}</h1>
              <p class="ds-hero-sub-beranda mb-3 mb-md-4">{{ $s['sub'] }}</p>
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
      @foreach ($heroSlides as $i => $s)
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $i }}" class="{{ $i===0 ? 'active' : '' }}"></button>
      @endforeach
    </div>
  </div>
</section>

{{-- Nanti lanjut Bagian 2: Layanan Utama --}}
{{-- =====================
     LAYANAN UTAMA
===================== --}}
@php
  $services = [
    [
      'title' => 'Pemulangan Orang Telantar',
      'img'   => 'pemulangan_orang_telantar.png',
      'url'   => url('/layanan/pemulangan-orang-telantar'),
    ],
    [
      'title' => 'Penerbitan Surat Tanda Pendaftaran Lembaga Kesejahteraan Sosial',
      'img'   => 'penerbitan_surat_tanda_pendaftaran_lembaga_kesejahteraan_sosial.png',
      'url'   => url('/layanan/penerbitan-surat-tanda-pendaftaran'),
    ],
    [
      'title' => 'Prosedur Pengangkatan Anak',
      'img'   => 'prosedur_pengangkatan_anak.png',
      'url'   => url('/layanan/prosedur-pengangkatan-anak'),
    ],
    [
      'title' => 'Penyaluran Logistik Bufferstock Bencana',
      'img'   => 'penyaluran_logistik_bufferstock_bencana.png',
      'url'   => url('/layanan/penyaluran-logistik-bufferstock-bencana'),
    ],
  ];
@endphp

<section class="ds-layanan py-5">
  <div class="konten-utama">
    <div class="text-center mb-4">
      <h2 class="ds-section-title">Layanan Utama</h2>
    </div>

{{-- DESKTOP/TABLET: grid (diperbarui) --}}
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

{{-- MOBILE: kartu horizontal tapi ditumpuk vertikal --}}
<div class="d-md-none">
  <div class="ds-vstack">
    @foreach($services as $s)
      {{-- Mengubah align-items-start menjadi align-items-center agar lebih rapi --}}
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
     PORTAL BERITA
===================== --}}
@php
  // Sementara hard-coded; nanti bisa diganti dari DB
  $berita = [
    [
      'slug'  => 'rapat-pembahasan-perubahan-pergub-kesos',
      'judul' => 'Rapat Pembahasan Usulan Perubahan Pasal 6 dan Pasal 7 pada Pergub Kesejahteraan Sosial',
      'ringkasan' => 'Rapat dilaksanakan menindaklanjuti usulan perubahan Pergub No. 077/2022 tentang Tata Cara Penyelenggaraan Kesejahteraan Sosial Rapat ini dilaksanakan karena adanya usulan perubahan Pasal 6 dan Pasal 7 pada Peraturan Gubernur Kalimantan Selatan Nomor 037 Tahun 2024 tentang Tata Cara Pelaksanaan Penyelenggaraan Kesejahteraan Sosial. Diharapkan dengan dilaksanakan rapat ini dapat meningkatkan Kesejahteraan Sosial di Provinsi Kalimantan Selatan.
                      Dalam rapat ini dihadiri oleh Kepala UPTD Dinas Sosial Prov.Kalsel beserta...',
      'tanggal'   => '22 Agustus 2025',
      'views'     => 321,
      'gambar'    => asset('images/berita/berita1.jpg'),
    ],
    [
      'slug'  => 'kaji-tiru-diy',
      'judul' => 'kaji tiru (benchmarking) ke Dinas Sosial Daerah Istimewa Yogyakarta',
      'tanggal' => '22 Agustus 2025',
      'views'   => 321,
      'gambar'  => asset('images/berita/berita2.jpg'),
    ],
    [
      'slug'  => 'upacara-hari-pahlawan-79',
      'judul' => 'Upacara Peringatan Hari Pahlawan ke-79',
      'tanggal' => '22 Agustus 2025',
      'views'   => 352,
      'gambar'  => asset('images/berita/berita3.jpg'),
    ],
    [
      'slug'  => 'e-sila-pandu',
      'judul' => 'E-Sila Pandu',
      'tanggal' => '2 Agustus 2025',
      'views'   => 264,
      'gambar'  => asset('images/berita/berita4.jpg'),
    ],
    [
      'slug'  => 'rapat-evaluasi-kinerja-2024',
      'judul' => 'Rapat Evaluasi Capaian Kinerja Dinas Sosial Provinsi Kalimantan Selatan',
      'tanggal' => '22 Agustus 2025',
      'views'   => 404,
      'gambar'  => asset('images/berita/berita5.jpg'),
    ],
  ];
@endphp

<section class="ds-news py-5">
  <div class="konten-berita">
    <div class="text-center mb-4">
      <h2 class="fw-semibold">Portal Berita</h2>
    </div>

    {{-- DESKTOP / TABLET (tetap seperti versi sebelumnya) --}}
    <div class="d-none d-md-block">
      @php $unggulan = $berita[0] ?? null; @endphp
      @if($unggulan)
        <article class="ds-featured-news mb-4">
          <img src="{{ $unggulan['gambar'] }}" alt="Berita unggulan" class="ds-featured-img">
          <div class="ds-featured-body">
            <h3 class="ds-featured-title">
              <a href="{{ url('/berita/'.$unggulan['slug']) }}" class="ds-news-link">{{ $unggulan['judul'] }}</a>
            </h3>
            @if(!empty($unggulan['ringkasan']))
              <p class="ds-featured-summary">{{ $unggulan['ringkasan'] }}</p>
            @endif
            <div class="ds-meta mt-auto">
              <span><i class="bi bi-clock me-1"></i>{{ $unggulan['tanggal'] }}</span>
              <span class="text-primary"><i class="bi bi-eye me-1"></i>{{ $unggulan['views'] }} Kali</span>
            </div>
          </div>
        </article>
      @endif

      <div class="row g-3">
        @foreach(array_slice($berita, 1, 4) as $b)
          <div class="col-12 col-sm-6 col-lg-3">
            <a href="{{ url('/berita/'.$b['slug']) }}" class="ds-news-card">
              <img src="{{ $b['gambar'] }}" alt="{{ $b['judul'] }}">
              <div class="ds-news-card-body">
                <h4 class="ds-news-title">{{ $b['judul'] }}</h4>
                <div class="ds-meta mt-auto">
                  <span><i class="bi bi-clock me-1"></i>{{ $b['tanggal'] }}</span>
                  <span class="text-primary"><i class="bi bi-eye me-1"></i>{{ $b['views'] }} Kali</span>
                </div>
              </div>
            </a>
          </div>
        @endforeach
      </div>
    </div>

    {{-- MOBILE: unggulan (gambar + judul), lalu list vertikal (thumb + judul) --}}
    <div class="d-md-none">
      {{-- Unggulan --}}
      @if($unggulan)
        <a class="ds-mfeat" href="{{ url('/berita/'.$unggulan['slug']) }}">
          <img src="{{ $unggulan['gambar'] }}" alt="Berita unggulan">
          <h3 class="mt-2">{{ $unggulan['judul'] }}</h3>
        </a>
      @endif

        {{-- List berita lain (tanpa tanggal & views) --}}
        <div class="ds-mnews-list mt-3">
            @foreach(array_slice($berita, 1) as $b)
                <a href="{{ url('/berita/'.$b['slug']) }}" class="ds-mnews-item">
                <img src="{{ $b['gambar'] }}" alt="{{ $b['judul'] }}">
                <div class="ds-mnews-title">{{ $b['judul'] }}</div>
                </a>
            @endforeach
        </div>
  </div>
    <div class="text-center mt-4">
        <a href="{{ url('/berita') }}" class="btn btn-primary">Lihat Semua Berita</a>
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
