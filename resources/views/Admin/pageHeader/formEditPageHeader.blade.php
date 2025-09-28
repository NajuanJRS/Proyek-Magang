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
                                <h4 class="card-title">Tambah Page Header</h4>

                                <form class="forms-sample" method="POST" action="{{ route('admin.pageHeader.update', $pageHeader->id_page) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group">
                                        <div class="form-group">
                                        <label for="nama_menu">Menu</label>
                                        <select class="form-control" id="id_menu" name="id_menu" required>
                                            <option value="">-- Nama Menu --</option>
                                            @foreach($menuHeader as $m)
                                            <option value="{{ $m->id_menu }}" {{ $m->id_menu == $pageHeader->id_menu ? 'selected' : '' }}>
                                                {{ $m->nama_menu }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="judul">judul</label>
                                        <input class="form-control" id="judul" name="judul" value="{{ old('judul', $pageHeader->judul) }}" placeholder="Masukkan Judul Header">
                                    </div>
                                    <div class="form-group">
                                        <label for="gambar_header">Unggah Gambar (Opsional)</label>
                                        <input type="file" class="form-control" id="gambar_header" name="gambar_header">
                                        @if($pageHeader->gambar_header)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/gambarHeader/' . $pageHeader->gambar_header) }}" alt="Gambar Slider" width="120" style="border-radius: 8px;">
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="deskripsi">Deskripsi :</label>
                                        <textarea class="form-control my-editor" id="deskripsi" name="deskripsi" rows="10" placeholder="Masukkan Deskripsi Layanan">{{ old('deskripsi', $pageHeader->deskripsi) }}</textarea>
                                    </div>

                                    <button type="submit" class="btn btn-gradient-info me-2">Simpan</button>
                                    <a href="{{ route('admin.pageHeader.index') }}" class="btn btn-gradient-danger">Batal</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="footer">
                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2025 <a href="#" target="_blank">Dinas Sosial Kalsel</a>. All rights reserved.</span>
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
