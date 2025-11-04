@extends('admin.layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-xl-10 col-lg-11">
                        <div class="card shadow-sm rounded-4">
                            <div class="card-body px-5 py-4">

                                <h4 class="card-title mb-5">Kelola Akun Admin</h4>

                                {{-- Validasi Error --}}
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form class="forms-sample" method="POST"
                                    action="{{ route('admin.adminUpdate.update', $adminUpdate->id_user) }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-4">
                                        <label class="form-label" for="username">Username</label>
                                        <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name', $adminUpdate->name) }}" id="name" name="name"
                                            placeholder="name">
                                        </div>
                                    </div>

                                    {{-- Password Saat Ini --}}
                                    <div class="mb-4">
                                        <label class="form-label" for="current_password">Password Saat Ini</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                                            <input type="password"
                                                class="form-control @error('current_password') is-invalid @enderror"
                                                id="current_password" name="current_password" placeholder="Masukkan password sekarang">
                                            <span class="input-group-text" style="cursor:pointer;" onclick="toggleCurrentPassword()">
                                                <i class="bi bi-eye-slash" id="toggleIconCurrent"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label" for="password">Password Baru</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                id="password" name="password" placeholder="Masukkan password baru">
                                            <span class="input-group-text" style="cursor:pointer;" onclick="togglePassword()">
                                                <i class="bi bi-eye-slash" id="toggleIcon"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                            <input type="password"
                                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                                id="password_confirmation" name="password_confirmation"
                                                placeholder="Ketik ulang password baru">
                                            <span class="input-group-text" style="cursor:pointer;" onclick="toggleConfirmPassword()">
                                                <i class="bi bi-eye-slash" id="toggleIconConfirm"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-info me-2">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
