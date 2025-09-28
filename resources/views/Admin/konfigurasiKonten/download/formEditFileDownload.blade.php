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
                                <h4 class="card-title">Edit File</h4>

                                <form class="forms-sample" method="POST" action="{{ route('admin.download.update', $fileDownload->id_file) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                     <div class="form-group">
                                            <label for="icon">Unggah Icon</label>
                                            <input type="file" class="form-control" id="icon" name="icon">
                                            @if ($fileDownload->icon)
                                                <div class="mt-2">
                                                    <img src="{{ asset('storage/icon/' . $fileDownload->icon) }}"
                                                        alt="Gambar Icon" width="120" style="border-radius: 8px;">
                                                </div>
                                            @endif
                                    </div>

                                    <div class="form-group">
                                        <div class="form-group">
                                        <label for="id_kategori">kategori</label>
                                        <select class="form-control" id="id_kategori" name="id_kategori" required>
                                            <option value="">-- Pilih kategori --</option>
                                            @foreach($kategori as $k)
                                            <option value="{{ $k->id_kategori }}" {{ $k->id_kategori == $fileDownload->id_kategori ? 'selected' : '' }}>
                                                {{ $k->nama_kategori }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                        <div class="form-group">
                                            <label for="nama_file">Nama File</label>
                                            <input class="form-control" id="nama_file" name="nama_file"
                                                value="{{ old('nama_file', $fileDownload->nama_file) }}" placeholder="Masukkan nama file">
                                        </div>

                                        <div class="form-group">
                                            <label for="file">Unggah File (Opsional)</label>
                                            <input type="file" class="form-control" id="file" name="file">
                                            <small class="form-text text-muted">
                                                Kosongkan jika tidak ingin mengganti file.
                                            </small>

                                            @if($fileDownload->file)
                                                <div class="mt-2">
                                                    <a href="{{ asset('storage/upload/file/' . $fileDownload->file) }}" target="_blank">
                                                        {{ $fileDownload->file }}
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-gradient-info me-2">Simpan</button>
                                    <a href="{{ route('admin.download.index') }}"
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
</body>

</html>
