@extends('pengguna.layouts.app')

{{-- aktifkan background abstrak hanya di halaman ini (opsional) --}}
@section('page_bg', 'ds-bg-abstract')

@section('content')

  {{-- ====== BREADCRUMB ====== --}}
  <nav aria-label="breadcrumb" class="container my-2">
    <ol class="breadcrumb small mb-0">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
      <li class="breadcrumb-item active" aria-current="page">Layanan</li>
    </ol>
  </nav>

  {{-- ====== HERO (gambar statis, teks di tengah) ====== --}}
    @if($header)
    <section class="ds-hero ds-hero-profil">
        <img src="{{ asset('storage/header/' . $header->gambar) }}" alt="{{ $header->headline }}" class="ds-hero-bg" loading="lazy">
        <div class="ds-hero-overlay"></div>
        <div class="container ds-hero-inner text-center text-white">
        <h1 class="ds-hero-title">{!! $header->headline !!}</h1>
        <p class="ds-hero-sub">{{ $header->sub_heading }}</p>
        </div>
    </section>
    @endif

  {{-- ====== GRID KARTU (daftar layanan) ====== --}}
  @php
    $cards = [
      ['title' => 'Pemulangan Orang Telantar', 'img' => 'pemulangan_orang_telantar.png', 'url' => url('/layanan/pemulangan-orang-telantar')],
      ['title' => 'Penerbitan Surat Tanda Pendaftaran Lembaga Kesejahteraan Sosial', 'img' => 'penerbitan_surat_tanda_pendaftaran_lembaga_kesejahteraan_sosial.png', 'url' => url('/layanan/pendaftaran-lks')],
      ['title' => 'Prosedur Pengangkatan Anak', 'img' => 'prosedur_pengangkatan_anak.png', 'url' => url('/layanan/prosedur-pengangkatan-anak')],
      ['title' => 'Penyaluran Logistik Bufferstock Bencana', 'img' => 'penyaluran_logistik_bufferstock_bencana.png', 'url' => url('/layanan/penyaluran-logistik-bencana')],
      ['title' => 'Penetapan Penerima Bantuan Usaha Ekonomi Produktif (UEP) Bagi Keluarga Fakir Miskin', 'img' => 'penetapan_penerima_bantuan_uep.png', 'url' => url('/layanan/penetapan-bantuan-uep')],
      ['title' => 'Prosedur Pengusulan Gelar Pahlawan Nasional', 'img' => 'prosedur_pengusulan_gelar_pahlawan_nasional.png', 'url' => url('/layanan/pengusulan-gelar-pahlawan')],
      ['title' => 'Penetapan Penerima Bantuan Rehabilitasi Sosial Rumah Tidak Layak Huni Bagi Keluarga Fakir Miskin', 'img' => 'penetapan_penerima_bantuan_rehabilitasi_sosial_rtlhs.png', 'url' => url('/layanan/penetapan-bantuan-rtlhs')],
      ['title' => 'Penerbitan Surat Pertimbangan Teknis Penyelenggaraan Undian Gratis Berhadiah (UGB)', 'img' => 'penerbitan_surat_pertimbangan_teknis_penyelenggaraan_ugb.png', 'url' => url('/layanan/penerbitan-surat-ugb')],
      ['title' => 'Penerbitan Surat Pertimbangan Teknis Penyelenggaraan Pengumpulan Uang atau Barang (PUB)', 'img' => 'penerbitan_surat_pertimbangan_teknis_penyelenggaraan_pub.png', 'url' => url('/layanan/penerbitan-surat-pub')],
      ['title' => 'Prosedur Seleksi Klien pada Panti Sosial Dinas Sosial Provinsi Kalimantan Selatan', 'img' => 'prosedur_seleksi_klien_pada_panti_sosial.png', 'url' => url('/layanan/prosedur-seleksi-klien-panti')],
    ];
  @endphp

  <section class="ds-layanan py-5">
    <div class="konten-utama">

      {{-- DESKTOP/TABLET: grid 4 kolom (lg) dan 2 kolom (md) --}}
<div class="d-none d-md-block">
  <div class="row ds-layanan-row g-3 justify-content-start">
    @foreach($cards as $c)
      <div class="col-12 col-md-6 col-lg-3 d-flex">
        <a href="{{ $c['url'] }}" class="card ds-layanan-card text-center w-100 text-decoration-none text-dark">
          <div class="ds-layanan-icon-wrapper">
            <img src="{{ asset('images/layanan/'.$c['img']) }}" alt="{{ $c['title'] }}">
          </div>
          <div class="card-body">
            <h6 class="card-title fw-semibold">{{ $c['title'] }}</h6>
          </div>
        </a>
      </div>
    @endforeach
  </div>
</div>

      {{-- MOBILE: grid 2 kolom, kartu kompak & seluruh kartu bisa ditekan --}}
      <div class="d-md-none">
        <div class="row g-2 ds-layanan-row-mobile">
          @foreach($cards as $c)
            <div class="col-6">
              <a href="{{ $c['url'] }}" class="card ds-layanan-card ds-card-compact text-center h-100">
                <div class="ds-layanan-icon-wrapper">
                   {{-- Mengarah ke folder 'images/layanan/' --}}
                  <img src="{{ asset('images/layanan/'.$c['img']) }}" alt="{{ $c['title'] }}">
                </div>
                <div class="card-body p-3 d-flex flex-column">
                  <h6 class="card-title fw-semibold mb-0 ds-title-compact">{{ $c['title'] }}</h6>
                </div>
              </a>
            </div>
          @endforeach
        </div>
      </div>

    </div>
  </section>

@endsection
