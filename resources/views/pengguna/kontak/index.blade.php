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

    {{-- ====== HERO (dinamis dari database) ====== --}}
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

  {{-- ====== KONTEN KONTAK ====== --}}
  <section class="py-5">
    <div class="container">
      {{-- Kartu utama yang membungkus semua konten --}}
      <div class="ds-contact-card">
        <h2 class="text-center fw-semibold mb-4">Dinas Sosial Pemerintah Provinsi Kalimantan Selatan</h2>

        {{-- Kontainer untuk memusatkan grid di bawah judul --}}
        <div class="row justify-content-center mt-4 mt-lg-5">
          <div class="col-lg-11 px-3 px-lg-5">
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
        </div> {{-- <-- Tag penutup untuk .row.justify-content-center --}}

        {{-- Tombol FAQ & Umpan Balik --}}
        <div class="my-4 pt-3 d-grid gap-2 d-md-flex justify-content-md-center">
            {{-- Tombol FAQ --}}
            <a href="{{ url('/faq') }}" class="btn btn-primary fw-semibold px-4 py-2">
                <i class="bi bi-question-circle me-2"></i>Kunjungi Halaman FAQ
            </a>
            {{-- Tombol Umpan Balik (Baru) --}}
            <button type="button" class="btn btn-primary fw-semibold px-4 py-2" data-bs-toggle="modal" data-bs-target="#feedbackModal">
                <i class="bi bi-chat-left-text me-2"></i>Berikan Umpan Balik Anda
            </button>
        </div>

        {{-- Peta Lokasi --}}
        <div class="ds-map-container">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3983.1334947814785!2d114.5870920741484!3d-3.3171626412167408!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2de423c4843d005d%3A0xab2c5cd62a3300f1!2sDinas%20Sosial%20Provinsi%20Kalimantan%20Selatan!5e0!3m2!1sid!2sid!4v1756190443278!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Lokasi Dinas Sosial Provinsi Kalimantan Selatan"></iframe>
        </div>
      </div> {{-- <-- Tag penutup untuk .ds-contact-card --}}
    </div> {{-- <-- Tag penutup untuk .container --}}
  </section>

    {{-- ====== MODAL UNTUK UMPAN BALIK ====== --}}
    <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-body p-4 p-lg-5">
            {{-- Tombol "X" untuk menutup modal --}}
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            <div class="text-center mb-4">
            <h4 class="modal-title fw-bold" id="feedbackModalLabel">Berikan Umpan Balik Anda</h4>
            <p class="text-muted">Kami sangat menghargai setiap umpan balik yang Anda berikan untuk membantu kami berkembang.</p>
            </div>
            
            <form action="#" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                <label for="feedbackName" class="form-label visually-hidden">Nama</label>
                <input type="text" class="form-control" id="feedbackName" name="nama" placeholder="Nama" required>
                </div>
                <div class="col-md-6">
                <label for="feedbackPhone" class="form-label visually-hidden">Telepon</label>
                <input type="tel" class="form-control" id="feedbackPhone" name="telepon" placeholder="Telepon" required>
                </div>
                <div class="col-12">
                <label for="feedbackEmail" class="form-label visually-hidden">Email</label>
                <input type="email" class="form-control" id="feedbackEmail" name="email" placeholder="Email" required>
                </div>
                <div class="col-12">
                <label for="feedbackMessage" class="form-label visually-hidden">Umpan Balik</label>
                <textarea class="form-control" id="feedbackMessage" name="pesan" rows="5" placeholder="Masukan Umpan Balik Anda" required></textarea>
                </div>
            </div>
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary w-100 fw-semibold">Kirim</button>
            </div>
            </form>
        </div>
        </div>
    </div>
    </div>

@endsection