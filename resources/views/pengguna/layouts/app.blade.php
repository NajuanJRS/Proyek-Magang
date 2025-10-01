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

  {{-- Bootstrap JS --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')
    <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body p-4 p-lg-5">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="text-center mb-4">
            <h4 class="modal-title fw-bold" id="feedbackModalLabel">Berikan Umpan Balik Anda</h4>
            <p class="text-muted">Kami sangat menghargai setiap umpan balik yang Anda berikan untuk membantu kami berkembang.</p>
          </div>
          <form action="#" method="POST">
            @csrf
            <div class="row g-3">
              <div class="col-md-6">
                <input type="text" class="form-control" name="nama" placeholder="Nama" required>
              </div>
              <div class="col-md-6">
                <input type="tel" class="form-control" name="telepon" placeholder="Telepon" required>
              </div>
              <div class="col-12">
                <input type="email" class="form-control" name="email" placeholder="Email" required>
              </div>
              <div class="col-12">
                <textarea class="form-control" name="pesan" rows="5" placeholder="Masukan Umpan Balik Anda" required></textarea>
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
</body>

</html>
