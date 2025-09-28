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
                    <div class="col-md-16 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <h4 class="card-title">Tambah Berita</h4>

                                <form class="forms-sample" method="POST" action="{{ route('admin.berita.store') }}"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <!-- Berita 1 -->
                                    <div class="form-group">
                                        <label for="judul">Judul</label>
                                        <input class="form-control" id="judul" name="judul"
                                            placeholder="Masukkan Judul Berita">
                                    </div>

                                    <div class="form-group">
                                        <label for="isi_berita1">Isi Berita 1:</label>
                                        <textarea class="form-control my-editor" id="isi_berita1" name="isi_berita1" rows="10"
                                            placeholder="Masukkan Isi Berita"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="gambar1">Unggah Gambar 1</label>
                                        <input type="file" class="form-control" id="gambar1" name="gambar1">
                                    </div>

                                    <!-- Tombol untuk membuka form berikutnya -->
                                    <div class="mb-3">
                                        <button type="button" class="btn btn-sm btn-gradient-primary"
                                            id="toggle-tombol2">+ Tambah Berita 2</button>
                                    </div>

                                    <!-- Berita 2 (hidden by default) -->
                                    <div id="tombol2" style="display: none;">
                                        <div class="form-group">
                                            <label for="isi_berita2">Isi Berita 2:</label>
                                            <textarea class="form-control my-editor" id="isi_berita2" name="isi_berita2" rows="10"
                                                placeholder="Masukkan Isi Berita"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="gambar2">Unggah Gambar 2</label>
                                            <input type="file" class="form-control" id="gambar2" name="gambar2">
                                        </div>

                                        <!-- Tombol untuk buka tombol3 -->
                                        <div class="mb-3">
                                            <button type="button" class="btn btn-sm btn-gradient-primary"
                                                id="toggle-tombol3">+ Tambah Berita 3</button>
                                        </div>
                                    </div>

                                    <!-- Berita 3 (hidden by default) -->
                                    <div id="tombol3" style="display: none;">
                                        <div class="form-group">
                                            <label for="isi_berita3">Isi Berita 3:</label>
                                            <textarea class="form-control my-editor" id="isi_berita3" name="isi_berita3" rows="10"
                                                placeholder="Masukkan Isi Berita"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="gambar3">Unggah Gambar 3</label>
                                            <input type="file" class="form-control" id="gambar3" name="gambar3">
                                        </div>
                                    </div>

                                    <!-- Tombol submit -->
                                    <button type="submit" class="btn btn-gradient-info me-2">Simpan</button>
                                    <a href="{{ route('admin.berita.index') }}"
                                        class="btn btn-gradient-danger">Batal</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="footer">
                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2025 <a
                            href="#" target="_blank">Dinas Sosial Kalsel</a>. All rights reserved.</span>
                    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i
                            class="mdi mdi-heart text-danger"></i></span>
                </div>
            </footer>
        </div>
    </div>
    <!-- Tambahkan script TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/gn30cjhxbd9tmt6en4rk9379il5jrfkmkmajtm1qx0kamzvo/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

</body>

</html>
