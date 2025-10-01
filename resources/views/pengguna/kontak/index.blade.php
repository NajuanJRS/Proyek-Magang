@extends('pengguna.layouts.app')

@section('page_bg', 'ds-bg-abstract')

@section('content')

  {{-- ====== BREADCRUMB ====== --}}
  <nav aria-label="breadcrumb" class="container my-2">
    <ol class="breadcrumb small mb-0">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
      <li class="breadcrumb-item active" aria-current="page">Kontak</li>
    </ol>
  </nav>

  {{-- ====== HERO ====== --}}
  <section class="ds-hero ds-hero-profil">
    <img src="{{ asset('images/hero/hero-profil.jpg') }}" alt="Hero Kontak" class="ds-hero-bg" loading="lazy">
    <div class="ds-hero-overlay"></div>
    <div class="container ds-hero-inner text-center text-white">
      <h1 class="ds-hero-title">Hubungi Kami</h1>
      <p class="ds-hero-sub">Kami siap mendengar pertanyaan, masukan, atau laporan Anda. Silakan hubungi kami melalui salah satu saluran di bawah ini atau kunjungi kantor kami langsung pada jam pelayanan.</p>
    </div>
  </section>

  {{-- ====== KONTEN KONTAK ====== --}}
  <section class="py-5">
    <div class="container">
      {{-- Kartu utama yang membungkus semua konten --}}
      <div class="ds-contact-card">
        <h2 class="text-center fw-semibold mb-4">Dinas Sosial Pemerintah Provinsi Kalimantan Selatan</h2>

        {{-- Kontainer untuk memusatkan grid di bawah judul --}}
        <div class="row justify-content-center mt-4 mt-lg-5">
            <div class="col-lg-11">
                {{-- Grid untuk informasi kontak --}}
                <div class="row g-4 g-lg-5">
                    {{-- Alamat Kantor --}}
                    <div class="col-md-6">
                        <div class="ds-contact-item">
                            <i class="bi bi-geo-alt-fill ds-contact-icon"></i>
                            <div>
                                <h6 class="ds-contact-title">Alamat Kantor</h6>
                                <p class="mb-0">Jl. Letjend. R. Soeprapto No. 8, Antasan Besar, Kecamatan Banjarmasin Tengah, Kota Banjarmasin, Kalimantan Selatan 70231</p>
                            </div>
                        </div>
                    </div>

                    {{-- Telepon --}}
                    <div class="col-md-6">
                        <div class="ds-contact-item">
                            <i class="bi bi-telephone-fill ds-contact-icon"></i>
                            <div>
                                <h6 class="ds-contact-title">Telepon</h6>
                                <p class="mb-0">(0511) 3350825</p>
                            </div>
                        </div>
                    </div>

                    {{-- Jam Pelayanan --}}
                    <div class="col-md-6">
                        <div class="ds-contact-item">
                            <i class="bi bi-clock-fill ds-contact-icon"></i>
                            <div>
                                <h6 class="ds-contact-title">Jam Pelayanan</h6>
                                <p class="mb-0">Senin - Jum'at: 08:00 - 16:00 WITA<br>Sabtu, Minggu, & Hari Libur Nasional: Tutup</p>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Email --}}
                    <div class="col-md-6">
                        <div class="ds-contact-item">
                            <i class="bi bi-envelope-fill ds-contact-icon"></i>
                            <div>
                                <h6 class="ds-contact-title">Email</h6>
                                <p class="mb-0">dinsos@kalselprov.go.id</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tombol FAQ (sesuai gambar) --}}
            <div class="text-center mt-4 mb-4">
                <a href="{{ url('/faq') }}" class="btn btn-primary">Kunjungi Halaman FAQ</a>
            </div>

        {{-- Peta Lokasi --}}
        <div class="ds-map-container">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3983.1334947814785!2d114.5870920741484!3d-3.3171626412167408!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2de423c4843d005d%3A0xab2c5cd62a3300f1!2sDinas%20Sosial%20Provinsi%20Kalimantan%20Selatan!5e0!3m2!1sid!2sid!4v1756190443278!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Lokasi Dinas Sosial Provinsi Kalimantan Selatan"></iframe>
        </div>
      </div>
    </div>
  </section>

@endsection
