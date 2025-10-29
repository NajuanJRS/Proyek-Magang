<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dinas Sosial Provinsi Kalimantan Selatan</title>
  <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
  @include('pengguna.layouts.navbar')

  <main class="site-main @yield('page_bg')">
    @yield('content')
  </main>

  @include('pengguna.layouts.footer')

  <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body p-4 p-lg-5">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

          <div class="text-center mb-4">
            <h4 class="modal-title fw-bold" id="feedbackModalLabel">Berikan Umpan Balik Anda</h4>
            <p class="text-muted">Kami sangat menghargai setiap umpan balik yang Anda berikan untuk membantu kami berkembang.</p>
          </div>

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

  <div class="ds-modal-overlay" id="galleryModal" hidden>
    <div class="ds-modal-content">
      <img src="" alt="" id="galleryModalImage" class="ds-modal-image">
      <div class="ds-modal-caption" id="galleryModalCaption"></div>
    </div>
  </div>

  <script nonce="{{ csp_nonce() }}" src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  @stack('scripts')

  <script>
    document.addEventListener('DOMContentLoaded', function () {
        const feedbackModalEl = document.getElementById('feedbackModal');
        if (!feedbackModalEl) return;

        const modalInstance = new bootstrap.Modal(feedbackModalEl);
        const feedbackForm = document.getElementById('feedbackForm');

        @if (($errors->any() && old('isi_pesan')) || session('success') || session('error'))
            modalInstance.show();
        @endif

        feedbackModalEl.addEventListener('hidden.bs.modal', function () {
            const alerts = feedbackModalEl.querySelectorAll('.alert');

            alerts.forEach(function(alert) {
                alert.remove();
            });

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

    function openModal(imageSrc, imageTitle) {
        modalImage.src = imageSrc;
        modalImage.alt = imageTitle;
        modalCaption.textContent = imageTitle;
        modal.hidden = false;
    }

    function closeModal() {
        modal.hidden = true;
    }

    document.querySelectorAll('.ds-galeri-card').forEach(card => {
        card.addEventListener('click', function(event) {
            event.preventDefault();

            const image = this.querySelector('img');
            const title = this.querySelector('.ds-galeri-title');

            if (image && title) {
                openModal(image.src, title.textContent);
            }
        });
    });

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
        whatsappBtn.target = '_blank';
        whatsappBtn.rel = 'noopener';
    }

    if (facebookBtn) {
        const facebookUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodedUrl}`;
        facebookBtn.addEventListener('click', function(event) {
            event.preventDefault();
            window.open(facebookUrl, 'facebook-share-dialog', 'width=800,height=600');
        });
    }

    if (instagramBtn) {
        instagramBtn.addEventListener('click', function(event) {
            event.preventDefault();
            if (navigator.clipboard) {
                navigator.clipboard.writeText(pageUrl).then(() => {
                    alert('Link telah disalin! Silakan bagikan di Instagram Anda.');
                }).catch(() => {
                    prompt("Salin link ini untuk dibagikan di Instagram:", pageUrl);
                });
            } else {
                prompt("Salin link ini untuk dibagikan di Instagram:", pageUrl);
            }
        });
    }
});
  </script>
  @push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    function embedYouTubeVideos() {
        const contentAreas = document.querySelectorAll('.ds-article-content, .ds-featured-summary, .ds-mnews-title');

        contentAreas.forEach(contentArea => {
            if (!contentArea) return;

            const youtubeRegex = /(?:https?:\/\/)?(?:www\.)?(?:youtube\.com|youtu\.be)\/(?:watch\?v=)?([a-zA-Z0-9_-]{11})(?:\S+)?/g;

            const paragraphYoutubeRegex = /<p>(https?:\/\/(?:www\.)?(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]{11})[^<]*)<\/p>/g;


            let contentHTML = contentArea.innerHTML;

            contentHTML = contentHTML.replace(paragraphYoutubeRegex, (match, url, videoId) => {
                if (url.trim().match(youtubeRegex)) {
                    return `<div class="youtube-video-wrapper">
                                <iframe src="https://www.youtube.com/embed/${videoId}"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen>
                                </iframe>
                            </div>`;
                }
                return match;
            });

            contentArea.innerHTML = contentHTML;
        });
    }

    embedYouTubeVideos();
});
</script>
@endpush
</body>
</html>

