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
                                <h4 class="card-title">Tambah Pejabat</h4>

                                <form class="forms-sample" method="POST" action="{{ route('admin.pejabat.store') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="nama_pejabat">Nama Pejabat</label>
                                        <input class="form-control" id="nama_pejabat" name="nama_pejabat"
                                            placeholder="Masukkan Nama Pejabat">
                                    </div>

                                    <div class="form-group">
                                        <label for="nip">NIP</label>
                                        <input class="form-control" id="nip" name="nip"
                                            placeholder="Masukkan NIP">
                                    </div>

                                    <div class="form-group">
                                        <label for="id_jabatan">Jabatan</label>
                                        <select class="form-control" id="id_jabatan" name="id_jabatan" required>
                                            <option value="">-- Pilih Jabatan --</option>
                                            @foreach ($jabatan as $j)
                                                <option value="{{ $j->id_jabatan }}" data-nama="{{ $j->nama_jabatan }}"
                                                    {{ old('id_jabatan', $pejabat->id_jabatan) == $j->id_jabatan ? 'selected' : '' }}>
                                                    {{ $j->nama_jabatan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Form tambahan -->
                                    <div class="form-group" id="form-kata-sambutan" style="display: none;">
                                        <label for="kata_sambutan">Kata Sambutan</label>
                                        <textarea class="form-control my-editor" id="kata_sambutan" name="kata_sambutan" rows="10"
                                            placeholder="Masukkan Kata Sambutan">{{ old('kata_sambutan', $pejabat->kata_sambutan) }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="gambar">Unggah Gambar</label>
                                        <input type="file" class="form-control" id="gambar" name="gambar">
                                    </div>

                                    <button type="submit" class="btn btn-gradient-info me-2">Simpan</button>
                                    <a href="{{ route('admin.pejabat.index') }}"
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
