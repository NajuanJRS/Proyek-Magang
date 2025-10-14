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

                            <h4 class="mb-5">Edit Konten layanan & Kategori</h4>

                            <form method="POST" action="{{ route('admin.layanan.update', $kontenLayanan->id_konten) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                {{-- ========== BAGIAN KATEGORI KONTEN ========== --}}
                                <h5 class="mb-3">Data Kategori Konten</h5>

                                {{-- Judul Konten --}}
                                <label for="judul_konten" class="mb-2">Judul Konten</label>
                                <div class="mb-4">
                                    <input type="text" class="form-control" id="judul_konten" name="judul_konten"
                                        value="{{ old('judul_konten', $kontenLayanan->kategoriKonten->judul_konten ?? '') }}"
                                        placeholder="Masukkan judul utama konten" required>
                                </div>

                                {{-- Icon Konten --}}
                                <label for="icon_konten" class="mb-2">Unggah Icon Konten</label>
                                <div class="mb-4">
                                    <input type="file" id="icon_konten" name="icon_konten" accept="image/*"
                                           onchange="previewEditImage(event, 'oldPreviewIcon', 'newPreviewIcon')">

                                    {{-- Gambar Lama --}}
                                    @if (!empty($kontenLayanan->kategoriKonten->icon_konten))
                                        <div class="mt-2">
                                            <img id="oldPreviewIcon"
                                                 src="{{ asset('storage/icon/' . $kontenLayanan->kategoriKonten->icon_konten) }}"
                                                 alt="Icon Konten Lama"
                                                 style="max-width: 150px; border-radius:8px; border:1px solid #ddd; padding:4px;">
                                        </div>
                                    @endif

                                    {{-- Preview Baru --}}
                                    <div class="mt-2">
                                        <img id="newPreviewIcon" src="#" alt="Preview Icon Baru"
                                             style="display:none; max-width:150px; border-radius:8px; border:1px solid #ddd; padding:4px;">
                                    </div>
                                </div>

                                <hr class="my-4">

                                {{-- ========== BAGIAN KONTEN DETAIL ========== --}}
                                <h5 class="mb-3">Data Isi Konten</h5>

                                {{-- Isi Konten 1 --}}
                                <label for="isi_konten1" class="mb-2">Isi Konten 1</label>
                                <div class="mb-4">
                                    <textarea class="form-control my-editor" id="isi_konten1" name="isi_konten1" rows="6">{{ old('isi_konten1', $kontenLayanan->isi_konten1) }}</textarea>
                                </div>

                                {{-- Gambar 1 --}}
                                <label for="gambar1" class="mb-2">Unggah Gambar 1</label>
                                <div class="mb-4">
                                    <input type="file" id="gambar1" name="gambar1" accept="image/*"
                                           onchange="previewEditImage(event, 'oldPreview1', 'newPreview1')">

                                    @if ($kontenLayanan->gambar1)
                                        <div class="mt-2">
                                            <img id="oldPreview1"
                                                 src="{{ asset('storage/konten/' . $kontenLayanan->gambar1) }}"
                                                 alt="Gambar Lama 1"
                                                 style="max-width: 200px; border-radius:8px; border:1px solid #ddd; padding:4px;">
                                        </div>
                                    @endif

                                    <div class="mt-2">
                                        <img id="newPreview1" src="#" alt="Preview Gambar 1 Baru"
                                             style="display:none; max-width:200px; border-radius:8px; border:1px solid #ddd; padding:4px;">
                                    </div>
                                </div>

                                {{-- Tombol toggle konten 2 --}}
                                <div class="mb-4">
                                    <button type="button" class="btn btn-sm btn-info" id="toggle-tombol2">
                                        + Tambah Konten 2
                                    </button>
                                </div>

                                {{-- Konten 2 --}}
                                <div id="tombol2"
                                     style="display: {{ $kontenLayanan->isi_konten2 || $kontenLayanan->gambar2 ? 'block' : 'none' }};">
                                    <label for="isi_konten2" class="mb-2">Isi Konten 2</label>
                                    <div class="mb-4">
                                        <textarea class="form-control my-editor" id="isi_konten2" name="isi_konten2" rows="6">{{ old('isi_konten2', $kontenLayanan->isi_konten2) }}</textarea>
                                    </div>

                                    {{-- Gambar 2 --}}
                                    <label for="gambar2" class="mb-2">Unggah Gambar 2</label>
                                    <div class="mb-4">
                                        <input type="file" id="gambar2" name="gambar2" accept="image/*"
                                               onchange="previewEditImage(event, 'oldPreview2', 'newPreview2')">

                                        @if ($kontenLayanan->gambar2)
                                            <div class="mt-2">
                                                <img id="oldPreview2"
                                                     src="{{ asset('storage/konten/' . $kontenLayanan->gambar2) }}"
                                                     alt="Gambar Lama 2"
                                                     style="max-width:200px; border-radius:8px; border:1px solid #ddd; padding:4px;">
                                            </div>
                                            <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" name="hapus_gambar2"
                                                value="1" id="hapus_gambar2">
                                            <label class="form-check-label" for="hapus_gambar2">Hapus gambar
                                                2</label>
                                            </div>
                                        @endif

                                        <div class="mt-2">
                                            <img id="newPreview2" src="#" alt="Preview Gambar 2 Baru"
                                                 style="display:none; max-width:200px; border-radius:8px; border:1px solid #ddd; padding:4px;">
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <button type="button" class="btn btn-sm btn-info" id="toggle-tombol3">
                                            + Tambah Konten 3
                                        </button>
                                    </div>
                                </div>

                                {{-- Konten 3 --}}
                                <div id="tombol3"
                                     style="display: {{ $kontenLayanan->isi_konten3 || $kontenLayanan->gambar3 ? 'block' : 'none' }};">
                                    <label for="isi_konten3" class="mb-2">Isi Konten 3</label>
                                    <div class="mb-4">
                                        <textarea class="form-control my-editor" id="isi_konten3" name="isi_konten3" rows="6">{{ old('isi_konten3', $kontenLayanan->isi_konten3) }}</textarea>
                                    </div>

                                    {{-- Gambar 3 --}}
                                    <label for="gambar3" class="mb-2">Unggah Gambar 3</label>
                                    <div class="mb-4">
                                        <input type="file" id="gambar3" name="gambar3" accept="image/*"
                                               onchange="previewEditImage(event, 'oldPreview3', 'newPreview3')">

                                        @if ($kontenLayanan->gambar3)
                                            <div class="mt-2">
                                                <img id="oldPreview3"
                                                     src="{{ asset('storage/konten/' . $kontenLayanan->gambar3) }}"
                                                     alt="Gambar Lama 3"
                                                     style="max-width:200px; border-radius:8px; border:1px solid #ddd; padding:4px;">
                                            </div>
                                            <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" name="hapus_gambar3"
                                                value="1" id="hapus_gambar3">
                                            <label class="form-check-label" for="hapus_gambar3">Hapus gambar
                                                3</label>
                                            </div>
                                        @endif

                                        <div class="mt-2">
                                            <img id="newPreview3" src="#" alt="Preview Gambar 3 Baru"
                                                 style="display:none; max-width:200px; border-radius:8px; border:1px solid #ddd; padding:4px;">
                                        </div>
                                    </div>
                                </div>

                                {{-- Tombol Submit --}}
                                <button type="submit" class="btn btn-info me-2">Simpan</button>
                                <a href="{{ route('admin.layanan.index') }}" class="btn btn-danger">Batal</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
