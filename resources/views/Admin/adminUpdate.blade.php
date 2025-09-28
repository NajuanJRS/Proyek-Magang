<!DOCTYPE html>
<html lang="en">
<body>
    <div class="container-scroller">

        @include('Admin.navigasi.adminNavigasi')
        @include('Admin.sidebar.sidebar')
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-md-10 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Update Admin</h4>
                                <p class="card-description"> Ubah username atau password admin. </p>

                                <form class="forms-sample" method="POST" action="{{ route('admin.adminUpdate.update', $adminUpdate->id_user) }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text"
                                               class="form-control @error('name') is-invalid @enderror"
                                               value="{{ old('name', $adminUpdate->name) }}"
                                               id="name" name="name" placeholder="name">
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Password Baru</label>
                                        <input type="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               id="password" name="password" placeholder="Masukkan password baru">
                                        @error('password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="password_confirmation">Konfirmasi Password</label>
                                        <input type="password"
                                               class="form-control @error('password_confirmation') is-invalid @enderror"
                                               id="password_confirmation" name="password_confirmation" placeholder="Ketik ulang password baru">
                                        @error('password_confirmation')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-gradient-primary me-2">Simpan Perubahan</button>
                                    <a href="{{ route('admin.adminUpdate.index') }}" class="btn btn-light">Batal</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="footer">
                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2023 <a href="https://www.bootstrapdash.com/" target="_blank">BootstrapDash</a>. All rights reserved.</span>
                    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="mdi mdi-heart text-danger"></i></span>
                </div>
            </footer>
        </div>

    </div>
</body>
</html>
