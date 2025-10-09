<!-- resources/views/layouts/footer.blade.php -->
<footer class="ds-footer my-4">
  <!-- Bar atas: teks + ikon medsos -->
  <div class="ds-footer-top">
    <div class="container d-flex align-items-center justify-content-between py-2">
        <span class="text-body-secondary medium d-block d-md-inline mb-2 mb-md-0">
         Terhubung dengan kami<br class="d-md-none">di media sosial:
        </span>
      <div class="ds-social d-flex align-items-center gap-4">
        <a href="https://facebook.com/" target="_blank" rel="noopener" aria-label="Facebook" class="text-body-secondary"><i class="bi bi-facebook"></i></a>
        <a href="https://instagram.com/" target="_blank" rel="noopener" aria-label="Instagram" class="text-body-secondary"><i class="bi bi-instagram"></i></a>
        <a href="https://wa.me/6280000000000" target="_blank" rel="noopener" aria-label="WhatsApp" class="text-body-secondary"><i class="bi bi-whatsapp"></i></a>
        <a href="https://youtube.com/" target="_blank" rel="noopener" aria-label="YouTube" class="text-body-secondary"><i class="bi bi-youtube"></i></a>
      </div>
    </div>
  </div>

  <!-- Isi 3 kolom -->
  <div class="container py-3 py-md-4">
    <div class="row gy-4">
      <!-- Kolom 1: logo + deskripsi -->
      <div class="col-lg-5">
        <div class="d-flex align-items-start">
          <img src="{{ asset('images/dinas-sosial-ft.png') }}" alt="Dinas Sosial Kalimantan Selatan" class="me-3" style="height:80px; width:auto;">
        </div>
        <p class="mt-3 mb-0 text-body-secondary medium">
          Dinas Sosial Provinsi Kalimantan Selatan adalah lembaga pemerintah daerah yang bertanggung jawab
          merumuskan dan melaksanakan kebijakan di bidang kesejahteraan sosial, pemberdayaan, dan
          perlindungan masyarakat.
        </p>
      </div>

      <!-- Kolom 2: tautan -->
      <div class="col-lg-3">
        <h6 class="fw-semibold mb-2">Tautan Link</h6>
        <ul class="list-unstyled ds-linklist">
            <li><a href="#" class="link-underline-opacity-0">Kementerian Sosial</a></li>
            <li><a href="#" class="link-underline-opacity-0">kalselprov.go.id</a></li>
            <li><a href="#" class="link-underline-opacity-0">LAPOR!</a></li>
            <li><a href="#" class="link-underline-opacity-0">BPBD Kalsel</a></li>
            <li><a href="{{ url('/faq') }}" class="link-underline-opacity-0">FAQ</a></li>
            <li><a href="#" class="link-underline-opacity-0" data-bs-toggle="modal" data-bs-target="#feedbackModal">Umpan Balik</a></li>
        </ul>
      </div>

      <!-- Kolom 3: kontak -->
        <div class="col-lg-4">
        <h6 class="fw-semibold mb-2">Hubungi Kami</h6>
        @if($kontakInfo)
            <div class="medium text-body-secondary">
            <div class="mb-2">Dinas Sosial Provinsi Kalimantan Selatan</div>

            <div class="d-flex mb-2">
                <i class="bi bi-geo-alt me-2"></i>
                {{-- Menampilkan alamat dari database --}}
                <div>{!! $kontakInfo->alamat !!}</div>
            </div>

            <div class="d-flex mb-2">
                <i class="bi bi-telephone me-2"></i>
                {{-- Menampilkan telepon dari database --}}
                <div>{{ $kontakInfo->nomor_telepon }}</div>
            </div>

            <div class="d-flex">
                <i class="bi bi-envelope me-2"></i>
                {{-- Menampilkan email dari database --}}
                <div><a href="mailto:{{ $kontakInfo->email }}" class="link-underline-opacity-0">{{ $kontakInfo->email }}</a></div>
            </div>
            </div>
        @endif
        </div>
    </div>
  </div>
</footer>
