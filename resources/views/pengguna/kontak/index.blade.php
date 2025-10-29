@extends('pengguna.layouts.app')

@section('page_bg', 'ds-bg-abstract')

@section('content')

  <nav aria-label="breadcrumb" class="container my-2">
    <ol class="breadcrumb small mb-0">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
      <li class="breadcrumb-item active" aria-current="page">Kontak</li>
    </ol>
  </nav>

  @if($header)
    <section class="ds-hero ds-hero-profil">
        <img src="{{ asset('storage/' . $header->gambar) }}" alt="{{ $header->headline }}" class="ds-hero-bg" loading="lazy">
        <div class="ds-hero-overlay"></div>
        <div class="container ds-hero-inner text-center text-white">
        <h1 class="ds-hero-title">{!! $header->headline !!}</h1>
        <p class="ds-hero-sub">{{ $header->sub_heading }}</p>
        </div>
    </section>
  @endif

  <section class="py-5">
    <div class="container">
      <div class="ds-contact-card">
        <h2 class="text-center fw-semibold mb-4">Dinas Sosial Pemerintah Provinsi Kalimantan Selatan</h2>
        @if($kontak)
          <div class="row justify-content-center mt-4 mt-lg-5">
            <div class="col-lg-11 px-3 px-lg-5">
              <div class="row g-4 g-lg-5">
                <div class="col-md-6">
                  <div class="ds-contact-item">
                    <i class="bi bi-geo-alt-fill ds-contact-icon"></i>
                    <div>
                      <h6 class="ds-contact-title">Alamat Kantor</h6>
                      <div class="mb-0">{!! $kontak->alamat !!}</div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="ds-contact-item">
                    <i class="bi bi-telephone-fill ds-contact-icon"></i>
                    <div>
                      <h6 class="ds-contact-title">Telepon</h6>
                      <p class="mb-0">{{ $kontak->nomor_telepon }}</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                    <div class="ds-contact-item">
                        <i class="bi bi-clock-fill ds-contact-icon"></i>
                        <div>
                            <h6 class="ds-contact-title">Jam Pelayanan</h6>
                            <div class="mb-0">{!! $kontak->jam_pelayanan !!}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                  <div class="ds-contact-item">
                    <i class="bi bi-envelope-fill ds-contact-icon"></i>
                    <div>
                      <h6 class="ds-contact-title">Email</h6>
                      <p class="mb-0">{{ $kontak->email }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="my-4 pt-3 d-grid gap-2 d-md-flex justify-content-md-center">
              <a href="{{ url('/faq') }}" class="btn btn-primary fw-semibold px-4 py-2">
                  <i class="bi bi-question-circle me-2"></i>Kunjungi Halaman FAQ
              </a>
              <button type="button" class="btn btn-primary fw-semibold px-4 py-2" data-bs-toggle="modal" data-bs-target="#feedbackModal">
                  <i class="bi bi-chat-left-text me-2"></i>Berikan Umpan Balik Anda
              </button>
          </div>
            <div class="ds-map-container">
                <iframe
                    src="{{ $kontak->map_url ?? '' }}"
                    width="600"
                    height="450"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Lokasi Dinas Sosial Provinsi Kalimantan Selatan">
                </iframe>
            </div>
        @else
          <div class="text-center py-5">
              <p class="text-muted">Informasi kontak belum tersedia.</p>
          </div>
        @endif
      </div>
    </div>
  </section>
@endsection
