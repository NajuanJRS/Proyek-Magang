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

                                <h4 class="mb-5">Edit Berita</h4>

                                <form method="POST" action="{{ route('admin.berita.update', $berita->id_berita) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    {{-- Judul --}}
                                    <label for="judul" class="mb-2">Judul</label>
                                    <div class="mb-4">
                                        <input type="text" class="form-control" id="judul" name="judul"
                                            value="{{ old('judul', $berita->judul) }}" placeholder="Masukkan Judul Berita">
                                    </div>

                                    {{-- Isi Berita 1 --}}
                                    <label for="isi_berita1" class="mb-2">Isi Berita 1</label>
                                    <div class="mb-4">
                                        <textarea class="form-control my-editor" id="isi_berita1" name="isi_berita1" rows="6">{{ old('isi_berita1', $berita->isi_berita1) }}</textarea>
                                    </div>

                                    {{-- Gambar 1 --}}
                                    <label for="gambar1" class="mb-2">Unggah Gambar 1</label>
                                    <div class="mb-4">
                                        <input type="file" id="gambar1" name="gambar1" accept="image/*"
                                            onchange="previewImage(event, 'preview1')">

                                        {{-- Gambar Lama --}}
                                        @if ($berita->gambar1)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/berita/' . $berita->gambar1) }}"
                                                    alt="Gambar Berita 1"
                                                    style="max-width: 200px; border-radius: 8px; border: 1px solid #ddd; padding: 4px;">
                                            </div>
                                        @endif

                                        {{-- Preview Baru --}}
                                        <div class="mt-2">
                                            <img id="preview1" src="#" alt="Preview Gambar 1"
                                                style="display:none; max-width:200px; border-radius:8px; border:1px solid #ddd; padding:4px;">
                                        </div>
                                    </div>


                                    {{-- Tombol toggle berita 2 --}}
                                    <div class="mb-4">
                                        <button type="button" class="btn btn-sm btn-info" id="toggle-tombol2">
                                            + Tambah Berita 2
                                        </button>
                                    </div>

                                    {{-- Berita 2 --}}
                                    <div id="tombol2"
                                        style="display: {{ $berita->isi_berita2 || $berita->gambar2 ? 'block' : 'none' }};">
                                        <label for="isi_berita2" class="mb-2">Isi Berita 2</label>
                                        <div class="mb-4">
                                            <textarea class="form-control my-editor" id="isi_berita2" name="isi_berita2" rows="6">{{ old('isi_berita2', $berita->isi_berita2) }}</textarea>
                                        </div>

                                        {{-- Gambar 2 --}}
                                        <label for="gambar2" class="mb-2">Unggah Gambar 2</label>
                                        <div class="mb-4">
                                            <input type="file" id="gambar2" name="gambar2" accept="image/*">
                                            @if ($berita->gambar2)
                                                <div class="mt-3">
                                                    <img src="{{ asset('storage/berita/' . $berita->gambar2) }}"
                                                        alt="Gambar Berita 2"
                                                        style="max-width: 200px; border-radius: 8px; border:1px solid #ddd; padding: 4px;">
                                                </div>
                                                <div class="form-check mt-2">
                                                    <input class="form-check-input" type="checkbox" name="hapus_gambar2"
                                                        value="1" id="hapus_gambar2">
                                                    <label class="form-check-label" for="hapus_gambar2">
                                                        Hapus gambar 2
                                                    </label>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="mb-4">
                                            <button type="button" class="btn btn-sm btn-info" id="toggle-tombol3">
                                                + Tambah Berita 3
                                            </button>
                                        </div>
                                    </div>

                                    {{-- Berita 3 --}}
                                    <div id="tombol3"
                                        style="display: {{ $berita->isi_berita3 || $berita->gambar3 ? 'block' : 'none' }};">
                                        <label for="isi_berita3" class="mb-2">Isi Berita 3</label>
                                        <div class="mb-4">
                                            <textarea class="form-control my-editor" id="isi_berita3" name="isi_berita3" rows="6">{{ old('isi_berita3', $berita->isi_berita3) }}</textarea>
                                        </div>

                                        {{-- Gambar 3 --}}
                                        <label for="gambar3" class="mb-2">Unggah Gambar 3</label>
                                        <div class="mb-4">
                                            <input type="file" id="gambar3" name="gambar3" accept="image/*">
                                            @if ($berita->gambar3)
                                                <div class="mt-3">
                                                    <img src="{{ asset('storage/berita/' . $berita->gambar3) }}"
                                                        alt="Gambar Berita 3"
                                                        style="max-width: 200px; border-radius: 8px; border:1px solid #ddd; padding: 4px;">
                                                </div>
                                                <div class="form-check mt-2">
                                                    <input class="form-check-input" type="checkbox" name="hapus_gambar3"
                                                        value="1" id="hapus_gambar3">
                                                    <label class="form-check-label" for="hapus_gambar3">
                                                        Hapus gambar 3
                                                    </label>
                                                </div>
                                            @endif
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
