@extends('admin.layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-xl-10 col-lg-11">
                        <div class="card shadow-sm rounded-4">
                            <div class="card-body px-5 py-4">

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <h4 class="mb-5">Tambah Berita</h4>

                                <form method="POST" action="{{ route('admin.berita.store') }}" enctype="multipart/form-data">
                                    @csrf

                                    {{-- Judul --}}
                                    <label for="judul" class="mb-2">Judul</label>
                                    <div class="mb-4">
                                        <input type="text" class="form-control" id="judul" name="judul"
                                            placeholder="Masukkan Judul Berita">
                                    </div>

                                    {{-- Isi Berita 1 --}}
                                    <label for="isi_berita1" class="mb-2">Isi Berita 1</label>
                                    <div class="mb-4">
                                        <textarea class="form-control my-editor" id="isi_berita1" name="isi_berita1" rows="6"
                                            placeholder="Masukkan Isi Berita"></textarea>
                                    </div>

                                    {{-- Gambar 1 --}}
                                    <label for="gambar1" class="mb-2">Unggah Gambar 1</label>
                                    <div class="mb-4">
                                        <input type="file" id="gambar1" name="gambar1" accept="image/*">
                                    </div>

                                    {{-- Tombol toggle berita 2 --}}
                                    <div class="mb-4">
                                        <button type="button" class="btn btn-sm btn-info" id="toggle-tombol2">
                                            + Tambah Berita 2
                                        </button>
                                    </div>

                                    {{-- Berita 2 --}}
                                    <div id="tombol2" style="display: none;">
                                        <label for="isi_berita2" class="mb-2">Isi Berita 2</label>
                                        <div class="mb-4">
                                            <textarea class="form-control my-editor" id="isi_berita2" name="isi_berita2" rows="6"
                                                placeholder="Masukkan Isi Berita"></textarea>
                                        </div>

                                        <label for="gambar2" class="mb-2">Unggah Gambar 2</label>
                                        <div class="mb-4">
                                            <input type="file" id="gambar2" name="gambar2" accept="image/*">
                                        </div>

                                        <div class="mb-4">
                                            <button type="button" class="btn btn-sm btn-info    " id="toggle-tombol3">
                                                + Tambah Berita 3
                                            </button>
                                        </div>
                                    </div>

                                    {{-- Berita 3 --}}
                                    <div id="tombol3" style="display: none;">
                                        <label for="isi_berita3" class="mb-2">Isi Berita 3</label>
                                        <div class="mb-4">
                                            <textarea class="form-control my-editor" id="isi_berita3" name="isi_berita3" rows="6"
                                                placeholder="Masukkan Isi Berita"></textarea>
                                        </div>

                                        <label for="gambar3" class="mb-2">Unggah Gambar 3</label>
                                        <div class="mb-4">
                                            <input type="file" id="gambar3" name="gambar3" accept="image/*">
                                        </div>
                                    </div>

                                    {{-- Tombol submit --}}
                                    <button type="submit" class="btn btn-info me-2">Simpan</button>
                                    <a href="{{ route('admin.berita.index') }}" class="btn btn-danger">Batal</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
