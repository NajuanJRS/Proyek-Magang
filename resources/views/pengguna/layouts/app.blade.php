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
</body>

</html>
