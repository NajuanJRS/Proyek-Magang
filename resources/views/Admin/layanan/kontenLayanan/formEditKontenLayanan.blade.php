@extends('admin.layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-xl-10 col-lg-11">
                    <div class="card shadow-sm rounded-4">
                        <div class="card-body px-5 py-4">

                            <h4 class="mb-5">Edit Konten layanan</h4>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('admin.layanan.update', $kontenLayanan->id_konten) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

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
                                                 src="{{ asset('storage/' . $kontenLayanan->kategoriKonten->icon_konten) }}"
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

                                {{-- Isi Konten 1 --}}
                                <div class="mb-4">
                                    <label class="form-label">Isi Konten 1</label>
                                    <div class="custom-editor-container">
                                        <div class="editor-toolbar">
                                            <button type="button" data-target="editor1" data-command="bold"><i class="bi bi-type-bold"></i></button>
                                            <button type="button" data-target="editor1" data-command="italic"><i class="bi bi-type-italic"></i></button>
                                            <button type="button" data-target="editor1" data-command="underline"><i class="bi bi-type-underline"></i></button>
                                            <button type="button" data-target="editor1" data-command="insertUnorderedList"><i class="bi bi-list-ul"></i></button>
                                            <button type="button" data-target="editor1" data-command="insertOrderedList"><i class="bi bi-list-ol"></i></button>
                                            <button type="button" data-target="editor1" data-command="createLink"><i class="bi bi-link-45deg"></i></button>
                                            <button type="button" data-target="editor1" data-command="insertImage"><i class="bi bi-image"></i></button>
                                            <button type="button" data-target="editor1" data-command="removeFormat"><i class="bi bi-eraser"></i></button>
                                        </div>
                                        <div id="editor1" class="custom-editor" contenteditable="true">{!! old('isi_konten1', $kontenLayanan->isi_konten1) !!}</div>
                                        <textarea name="isi_konten1" id="hiddenContent1" style="display:none;"></textarea>
                                    </div>
                                </div>

                                {{-- Gambar 1 --}}
                                <label for="gambar1" class="mb-2">Unggah Gambar 1</label>
                                <div class="mb-4">
                                    <input type="file" id="gambar1" name="gambar1" accept="image/*"
                                           onchange="previewEditImage(event, 'oldPreview1', 'newPreview1')">

                                    @if ($kontenLayanan->gambar1)
                                        <div class="mt-2">
                                            <img id="oldPreview1"
                                                 src="{{ asset('storage/' . $kontenLayanan->gambar1) }}"
                                                 alt="Gambar Lama 1"
                                                 style="max-width: 200px; border-radius:8px; border:1px solid #ddd; padding:4px;">
                                        </div>
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" name="hapus_gambar1"
                                                value="1" id="hapus_gambar1">
                                            <label class="form-check-label" for="hapus_gambar1">Hapus gambar
                                                1</label>
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
                                    <div class="mb-4">
                                    <label class="form-label">Isi Konten 2</label>
                                    <div class="custom-editor-container">
                                        <div class="editor-toolbar">
                                            <button type="button" data-target="editor2" data-command="bold"><i class="bi bi-type-bold"></i></button>
                                            <button type="button" data-target="editor2" data-command="italic"><i class="bi bi-type-italic"></i></button>
                                            <button type="button" data-target="editor2" data-command="underline"><i class="bi bi-type-underline"></i></button>
                                            <button type="button" data-target="editor2" data-command="insertUnorderedList"><i class="bi bi-list-ul"></i></button>
                                            <button type="button" data-target="editor2" data-command="insertOrderedList"><i class="bi bi-list-ol"></i></button>
                                            <button type="button" data-target="editor2" data-command="createLink"><i class="bi bi-link-45deg"></i></button>
                                            <button type="button" data-target="editor2" data-command="insertImage"><i class="bi bi-image"></i></button>
                                            <button type="button" data-target="editor2" data-command="removeFormat"><i class="bi bi-eraser"></i></button>
                                        </div>
                                        <div id="editor2" class="custom-editor" contenteditable="true">{!! old('isi_konten2', $kontenLayanan->isi_konten2) !!}</div>
                                        <textarea name="isi_konten2" id="hiddenContent2" style="display:none;"></textarea>
                                    </div>
                                </div>

                                    {{-- Gambar 2 --}}
                                    <label for="gambar2" class="mb-2">Unggah Gambar 2</label>
                                    <div class="mb-4">
                                        <input type="file" id="gambar2" name="gambar2" accept="image/*"
                                               onchange="previewEditImage(event, 'oldPreview2', 'newPreview2')">

                                        @if ($kontenLayanan->gambar2)
                                            <div class="mt-2">
                                                <img id="oldPreview2"
                                                     src="{{ asset('storage/' . $kontenLayanan->gambar2) }}"
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
                                    <div class="mb-4">
                                    <label class="form-label">Isi Konten 3</label>
                                    <div class="custom-editor-container">
                                        <div class="editor-toolbar">
                                            <button type="button" data-target="editor3" data-command="bold"><i class="bi bi-type-bold"></i></button>
                                            <button type="button" data-target="editor3" data-command="italic"><i class="bi bi-type-italic"></i></button>
                                            <button type="button" data-target="editor3" data-command="underline"><i class="bi bi-type-underline"></i></button>
                                            <button type="button" data-target="editor3" data-command="insertUnorderedList"><i class="bi bi-list-ul"></i></button>
                                            <button type="button" data-target="editor3" data-command="insertOrderedList"><i class="bi bi-list-ol"></i></button>
                                            <button type="button" data-target="editor3" data-command="createLink"><i class="bi bi-link-45deg"></i></button>
                                            <button type="button" data-target="editor3" data-command="insertImage"><i class="bi bi-image"></i></button>
                                            <button type="button" data-target="editor3" data-command="removeFormat"><i class="bi bi-eraser"></i></button>
                                        </div>
                                        <div id="editor3" class="custom-editor" contenteditable="true">{!! old('isi_konten3', $kontenLayanan->isi_konten3) !!}</div>
                                        <textarea name="isi_konten3" id="hiddenContent3" style="display:none;"></textarea>
                                    </div>
                                </div>

                                    {{-- Gambar 3 --}}
                                    <label for="gambar3" class="mb-2">Unggah Gambar 3</label>
                                    <div class="mb-4">
                                        <input type="file" id="gambar3" name="gambar3" accept="image/*"
                                               onchange="previewEditImage(event, 'oldPreview3', 'newPreview3')">

                                        @if ($kontenLayanan->gambar3)
                                            <div class="mt-2">
                                                <img id="oldPreview3"
                                                     src="{{ asset('storage/' . $kontenLayanan->gambar3) }}"
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
