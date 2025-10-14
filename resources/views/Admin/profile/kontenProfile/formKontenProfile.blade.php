@extends('admin.layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-xl-10 col-lg-11">
                        <div class="card shadow-sm rounded-4">
                            <div class="card-body px-5 py-4">

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

                                <h4 class="mb-5">Tambah Konten Profil & Kategori</h4>

                                <form method="POST" action="{{ route('admin.profile.store') }}"
                                    enctype="multipart/form-data">
                                    @csrf

                                    {{-- ========== Bagian KATEGORI KONTEN ========== --}}
                                    <h5 class="mb-3">Data Kategori Konten</h5>

                                    {{-- Judul Konten --}}
                                    <label for="judul_konten" class="mb-2">Judul Konten</label>
                                    <div class="mb-4">
                                        <input type="text" class="form-control" id="judul_konten" name="judul_konten"
                                            placeholder="Masukkan judul utama konten" required>
                                    </div>

                                    {{-- Icon Konten --}}
                                    <label for="icon_konten" class="mb-2">Unggah Icon Konten</label>
                                    <div class="mb-4">
                                        <input type="file" id="icon_konten" name="icon_konten" accept="image/*"
                                            onchange="previewImage(event, 'previewIcon')">
                                        <br>
                                        <img id="previewIcon" src="#" alt="Preview Konten Icon"
                                            style="display:none; width: 150px; margin-top:10px; border-radius:8px;">
                                    </div>

                                    <hr class="my-4">

                                    {{-- ========== Bagian KONTEN DETAIL ========== --}}
                                    <h5 class="mb-3">Data Isi Konten</h5>

                                    {{-- Isi konten 1 --}}
                                    <label for="isi_konten1" class="mb-2">Isi Konten 1</label>
                                    <div class="mb-4">
                                        <textarea class="form-control my-editor" id="isi_konten1" name="isi_konten1" rows="6"
                                            placeholder="Masukkan isi konten pertama"></textarea>
                                    </div>

                                    {{-- Gambar 1 --}}
                                    <label for="gambar1" class="mb-2">Unggah Gambar 1</label>
                                    <div class="mb-4">
                                        <input type="file" id="gambar1" name="gambar1" accept="image/*"
                                            onchange="previewImage(event, 'preview1')">
                                        <br>
                                        <img id="preview1" src="#" alt="Preview Gambar 1"
                                            style="display:none; width: 150px; margin-top:10px; border-radius:8px;">
                                    </div>

                                    {{-- Tombol toggle konten 2 --}}
                                    <div class="mb-4">
                                        <button type="button" class="btn btn-sm btn-info" id="toggle-tombol2">
                                            + Tambah konten 2
                                        </button>
                                    </div>

                                    {{-- konten 2 --}}
                                    <div id="tombol2" style="display: none;">
                                        <label for="isi_konten2" class="mb-2">Isi Konten 2</label>
                                        <div class="mb-4">
                                            <textarea class="form-control my-editor" id="isi_konten2" name="isi_konten2" rows="6"
                                                placeholder="Masukkan isi konten kedua"></textarea>
                                        </div>

                                        {{-- Gambar 2 --}}
                                        <label for="gambar2" class="mb-2">Unggah Gambar 2</label>
                                        <div class="mb-4">
                                            <input type="file" id="gambar2" name="gambar2" accept="image/*"
                                                onchange="previewImage(event, 'preview2')">
                                            <br>
                                            <img id="preview2" src="#" alt="Preview Gambar 2"
                                                style="display:none; width: 150px; margin-top:10px; border-radius:8px;">
                                        </div>

                                        <div class="mb-4">
                                            <button type="button" class="btn btn-sm btn-info" id="toggle-tombol3">
                                                + Tambah konten 3
                                            </button>
                                        </div>
                                    </div>

                                    {{-- konten 3 --}}
                                    <div id="tombol3" style="display: none;">
                                        <label for="isi_konten3" class="mb-2">Isi Konten 3</label>
                                        <div class="mb-4">
                                            <textarea class="form-control my-editor" id="isi_konten3" name="isi_konten3" rows="6"
                                                placeholder="Masukkan isi konten ketiga"></textarea>
                                        </div>
                                        {{-- Gambar 3 --}}
                                        <label for="gambar3" class="mb-2">Unggah Gambar 3</label>
                                        <div class="mb-4">
                                            <input type="file" id="gambar3" name="gambar3" accept="image/*"
                                                onchange="previewImage(event, 'preview3')">
                                            <br>
                                            <img id="preview3" src="#" alt="Preview Gambar 3"
                                                style="display:none; width: 150px; margin-top:10px; border-radius:8px;">
                                        </div>
                                    </div>

                                    {{-- Tombol Submit --}}
                                    <button type="submit" class="btn btn-info me-2">Simpan</button>
                                    <a href="{{ route('admin.profile.index') }}" class="btn btn-danger">Batal</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
