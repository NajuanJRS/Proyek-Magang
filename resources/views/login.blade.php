<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DINSOS PROV KALSEL</title>
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <div class="d-flex flex-column justify-content-center align-items-center" style="min-height:100vh;">
        <div class="login-card position-relative">
            <div class="text-center">
                <img src="{{ asset('img/Logo mini.png') }}" alt="Logo">
                <h3 class="mb-1">Selamat Datang!</h3>
                <div class="login-title mb-3">Login</div>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('success'))
                <div id="session-success-toast" data-message="{{ session('success') }}" class="d-none">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{ route('login') }}" method="POST" autocomplete="off">
                @csrf
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Username"
                        required>
                </div>
                <div class="input-group mb-2">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                        required>
                    <span class="input-group-text" style="cursor:pointer;" onclick="togglePassword()">
                        <i class="bi bi-eye-slash" id="toggleIcon"></i>
                    </span>
                </div>
                <button type="submit" name="submit" class="btn login-btn w-100">Login</button>
            </form>
        </div>
        <p class="copyright-text">Copyright © 2025 Dinas Sosial Provinsi Kalimantan Selatan</p>
    </div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const successAlertElement = document.getElementById('session-success-toast');
    if (successAlertElement) {
        const message = successAlertElement.getAttribute('data-message');
        if (message) {
            Swal.fire({
                title: 'Berhasil!',
                text: message,
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        }
    }
</script>
<script src="{{ asset('js/custom.js') }}"></script>
</body>

</html>
