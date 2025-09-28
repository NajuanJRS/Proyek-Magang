<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    <div class="container-scroller">

        @include('Admin.navigasi.adminNavigasi')
        @include('Admin.sidebar.sidebar')
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Formulir Kontak & Alamat</h4>
                                <p class="card-description"> Masukkan informasi kontak yang akan ditampilkan di halaman depan. </p>

                                <form class="forms-sample" method="POST" action="{{ route('admin.kontak.update', $kontak->id_kontak) }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group">
                                        <label for="nomor_telepon">Nomor Telepon</label>
                                        <input type="nomor_telepon" class="form-control" name="nomor_telepon" value="{{ old('nomor_telepon', $kontak->nomor_telepon) }}" id="nomor_telepon" placeholder="Contoh: 081234567890">
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $kontak->email) }}" placeholder="Contoh: info@kalselprov.go.id">
                                    </div>

                                    <div class="form-group">
                                        <label for="map">Map</label>
                                        <input type="url" class="form-control" id="map" name="map" placeholder="Tempelkan URL SRC dari Google Maps Embed" value="{{ old('map', $kontak->map) }}">
                                        <small class="form-text text-muted">
                                            <b>Cara mendapatkan URL:</b> Buka Google Maps > Cari Lokasi > Bagikan (Share) > Sematkan Peta (Embed a map) > Salin URL dari dalam atribut `src="..."`.
                                        </small>
                                    </div>

                                    <div class="form-group">
                                        <label for="alamat">Alamat :</label>
                                        <textarea class="form-control my-editor" id="alamat" name="alamat" rows="10" placeholder="Masukkan Alamat">{{ old('alamat', $kontak->alamat) }}</textarea>
                                    </div>

                                    <button type="submit" class="btn btn-gradient-info me-2">Simpan</button>
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
            <!-- Tambahkan script TinyMCE -->
<script src="https://cdn.tiny.cloud/1/gn30cjhxbd9tmt6en4rk9379il5jrfkmkmajtm1qx0kamzvo/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script src="{{ asset('js/custom.js') }}"></script>
</body>
</html>
