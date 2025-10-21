<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dinas Sosial</title>

  {{-- Bootstrap CSS + Icons --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  {{-- CSS custom --}}
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
  @include('pengguna.layouts.navbar')

  <main class="site-main @yield('page_bg')">
    @yield('content')
  </main>

  @include('pengguna.layouts.footer')

  {{-- ====== MODAL UMPAN BALIK (GLOBAL) ====== --}}
  <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body p-4 p-lg-5">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

          <div class="text-center mb-4">
            <h4 class="modal-title fw-bold" id="feedbackModalLabel">Berikan Umpan Balik Anda</h4>
            <p class="text-muted">Kami sangat menghargai setiap umpan balik yang Anda berikan untuk membantu kami berkembang.</p>
          </div>

          {{-- Notifikasi akan ditampilkan di sini --}}
          @if(session('success'))
              <div class="alert alert-success">
                  {{ session('success') }}
              </div>
          @endif
          @if(session('error'))
              <div class="alert alert-danger">
                  {{ session('error') }}
              </div>
          @endif
          @if ($errors->any())
              <div class="alert alert-danger">
                  <ul class="mb-0">
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif

          <form action="{{ route('kontak.store') }}" method="POST" id="feedbackForm">
              @csrf
              <div class="row g-3">
                  <div class="col-md-6">
                      <input type="text" class="form-control" name="nama" placeholder="Nama" required value="{{ old('nama') }}">
                  </div>
                  <div class="col-md-6">
                      <input type="tel" class="form-control" name="telepon" placeholder="Telepon" required value="{{ old('telepon') }}">
                  </div>
                  <div class="col-12">
                      <input type="email" class="form-control" name="email" placeholder="Email" required value="{{ old('email') }}">
                  </div>
                  <div class="col-12">
                      <textarea class="form-control" name="isi_pesan" rows="5" placeholder="Masukan Umpan Balik Anda" required>{{ old('isi_pesan') }}</textarea>
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

  {{-- ====== MODAL GALERI (GLOBAL) ====== --}}
  <div class="ds-modal-overlay" id="galleryModal" hidden>
    <div class="ds-modal-content">
      <img src="" alt="" id="galleryModalImage" class="ds-modal-image">
      <div class="ds-modal-caption" id="galleryModalCaption"></div>
    </div>
  </div>

  {{-- Bootstrap JS --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  {{-- Script khusus per halaman --}}
  @stack('scripts')

  {{-- ============================================= --}}
  {{-- SCRIPT GLOBAL UNTUK MODAL FEEDBACK (DIPERBAIKI) --}}
  {{-- ============================================= --}}
  <script>
    document.addEventListener('DOMContentLoaded', function () {
        const feedbackModalEl = document.getElementById('feedbackModal');
        if (!feedbackModalEl) return;

        const modalInstance = new bootstrap.Modal(feedbackModalEl);
        const feedbackForm = document.getElementById('feedbackForm');

        // Kondisi untuk menampilkan modal secara otomatis SETELAH submit form
        @if (($errors->any() && old('isi_pesan')) || session('success') || session('error'))
            modalInstance.show();
        @endif

        // Tambahkan event listener yang berjalan SETELAH modal selesai ditutup
        feedbackModalEl.addEventListener('hidden.bs.modal', function () {
            // Cari semua elemen notifikasi (.alert) di dalam modal
            const alerts = feedbackModalEl.querySelectorAll('.alert');

            // Hapus setiap notifikasi yang ditemukan
            alerts.forEach(function(alert) {
                alert.remove();
            });

            // Jika form sebelumnya dikirim dengan sukses, kosongkan isinya.
            // Jika gagal karena validasi, biarkan input tetap ada untuk diperbaiki pengguna.
            @if (session('success'))
                if (feedbackForm) {
                    feedbackForm.reset();
                }
            @endif
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('galleryModal');
    if (!modal) return;

    const modalImage = document.getElementById('galleryModalImage');
    const modalCaption = document.getElementById('galleryModalCaption');

    // Fungsi untuk membuka modal
    function openModal(imageSrc, imageTitle) {
        modalImage.src = imageSrc;
        modalImage.alt = imageTitle;
        modalCaption.textContent = imageTitle;
        modal.hidden = false;
    }

    // Fungsi untuk menutup modal
    function closeModal() {
        modal.hidden = true;
    }

    // Tambahkan event listener ke semua kartu galeri
    document.querySelectorAll('.ds-galeri-card').forEach(card => {
        card.addEventListener('click', function(event) {
            event.preventDefault(); // Mencegah link default jika ada

            const image = this.querySelector('img');
            const title = this.querySelector('.ds-galeri-title');

            if (image && title) {
                openModal(image.src, title.textContent);
            }
        });
    });


    // Event listener untuk klik di luar area konten (pada overlay)
    modal.addEventListener('click', function(event) {
        if (event.target === modal) {
            closeModal();
        }
    });
});
document.addEventListener('DOMContentLoaded', function() {
    const shareButtonsContainer = document.querySelector('.ds-share-buttons');
    if (!shareButtonsContainer) {
        return;
    }

    const pageUrl = window.location.href;
    let pageTitle = document.title;

    const articleTitleElement = document.querySelector('.ds-article-title');
    if (articleTitleElement) {
        pageTitle = articleTitleElement.innerText;
    }

    const encodedUrl = encodeURIComponent(pageUrl);
    const encodedTitle = encodeURIComponent(pageTitle);

    const whatsappBtn = shareButtonsContainer.querySelector('.ds-share-btn-whatsapp');
    const facebookBtn = shareButtonsContainer.querySelector('.ds-share-btn-facebook');
    const instagramBtn = shareButtonsContainer.querySelector('.ds-share-btn-instagram');

    if (whatsappBtn) {
        whatsappBtn.href = `https://api.whatsapp.com/send?text=${encodedTitle} - ${encodedUrl}`;
        whatsappBtn.target = '_blank'; // Buka di tab baru
        whatsappBtn.rel = 'noopener';
    }

    if (facebookBtn) {
        const facebookUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodedUrl}`;
        facebookBtn.addEventListener('click', function(event) {
            event.preventDefault();
            // Buka di jendela popup baru yang lebih rapi
            window.open(facebookUrl, 'facebook-share-dialog', 'width=800,height=600');
        });
    }

    if (instagramBtn) {
        instagramBtn.addEventListener('click', function(event) {
            event.preventDefault();
            // Coba salin ke clipboard
            if (navigator.clipboard) {
                navigator.clipboard.writeText(pageUrl).then(() => {
                    alert('Link telah disalin! Silakan bagikan di Instagram Anda.');
                }).catch(() => {
                    // Gagal (kemungkinan karena bukan HTTPS), tampilkan fallback
                    prompt("Salin link ini untuk dibagikan di Instagram:", pageUrl);
                });
            } else {
                // Fallback untuk browser yang sangat lama
                prompt("Salin link ini untuk dibagikan di Instagram:", pageUrl);
            }
        });
    }
});
  </script>
  @push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fungsi untuk mengubah link YouTube menjadi iframe
    function embedYouTubeVideos() {
        // Cari semua elemen yang mungkin berisi konten (sesuaikan selector jika perlu)
        const contentAreas = document.querySelectorAll('.ds-article-content, .ds-featured-summary, .ds-mnews-title'); // Tambahkan selector lain jika perlu

        contentAreas.forEach(contentArea => {
            if (!contentArea) return;

            // Regex untuk mencari link YouTube (watch?v=...)
            const youtubeRegex = /(?:https?:\/\/)?(?:www\.)?(?:youtube\.com|youtu\.be)\/(?:watch\?v=)?([a-zA-Z0-9_-]{11})(?:\S+)?/g;

            // Regex untuk mencari link YouTube dalam tag <p> agar tidak merusak link lain
            const paragraphYoutubeRegex = /<p>(https?:\/\/(?:www\.)?(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]{11})[^<]*)<\/p>/g;


            let contentHTML = contentArea.innerHTML;

            // Ganti link YouTube di dalam <p> menjadi iframe
            contentHTML = contentHTML.replace(paragraphYoutubeRegex, (match, url, videoId) => {
                 // Hanya ganti jika link berdiri sendiri dalam paragraf
                if (url.trim().match(youtubeRegex)) {
                    return `<div class="youtube-video-wrapper">
                                <iframe src="https://www.youtube.com/embed/${videoId}"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen>
                                </iframe>
                            </div>`;
                }
                return match; // Kembalikan paragraf asli jika tidak cocok
            });

            contentArea.innerHTML = contentHTML;
        });
    }

    // Jalankan fungsi saat halaman dimuat
    embedYouTubeVideos();
});
</script>
@endpush
</body>
</html>

