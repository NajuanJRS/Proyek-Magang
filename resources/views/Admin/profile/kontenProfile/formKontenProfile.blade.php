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

                                <h4 class="mb-5">Tambah Konten Profil</h4>

                                <form method="POST" action="{{ route('admin.profile.store') }}"
                                    enctype="multipart/form-data">
                                    @csrf

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

                                    {{-- Isi konten 1 --}}
                                    <div class="mb-4">
                                        <label class="form-label">Isi Konten 1</label>
                                        <div class="custom-editor-container">
                                            <div class="editor-toolbar">
                                                <button type="button" data-target="editor1" data-command="bold"><i
                                                        class="bi bi-type-bold"></i></button>
                                                <button type="button" data-target="editor1" data-command="italic"><i
                                                        class="bi bi-type-italic"></i></button>
                                                <button type="button" data-target="editor1" data-command="underline"><i
                                                        class="bi bi-type-underline"></i></button>
                                                <button type="button" data-target="editor1"
                                                    data-command="insertUnorderedList"><i
                                                        class="bi bi-list-ul"></i></button>
                                                <button type="button" data-target="editor1"
                                                    data-command="insertOrderedList"><i class="bi bi-list-ol"></i></button>
                                                <button type="button" data-target="editor1" data-command="createLink"><i
                                                        class="bi bi-link-45deg"></i></button>
                                                <button type="button" data-target="editor1" data-command="insertImage"><i
                                                        class="bi bi-image"></i></button>
                                                <button type="button" data-target="editor1" data-command="removeFormat"><i
                                                        class="bi bi-eraser"></i></button>
                                            </div>
                                            <div id="editor1" class="custom-editor" contenteditable="true">
                                                {!! old('isi_konten1') !!}</div>
                                            <textarea name="isi_konten1" id="hiddenContent1" style="display:none;"></textarea>
                                        </div>
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
                                        <div class="mb-4">
                                            <label class="form-label">Isi Konten 2</label>
                                            <div class="custom-editor-container">
                                                <div class="editor-toolbar">
                                                    <button type="button" data-target="editor2" data-command="bold"><i
                                                            class="bi bi-type-bold"></i></button>
                                                    <button type="button" data-target="editor2" data-command="italic"><i
                                                            class="bi bi-type-italic"></i></button>
                                                    <button type="button" data-target="editor2"
                                                        data-command="underline"><i
                                                            class="bi bi-type-underline"></i></button>
                                                    <button type="button" data-target="editor2"
                                                        data-command="insertUnorderedList"><i
                                                            class="bi bi-list-ul"></i></button>
                                                    <button type="button" data-target="editor2"
                                                        data-command="insertOrderedList"><i
                                                            class="bi bi-list-ol"></i></button>
                                                    <button type="button" data-target="editor2"
                                                        data-command="createLink"><i
                                                            class="bi bi-link-45deg"></i></button>
                                                    <button type="button" data-target="editor2"
                                                        data-command="insertImage"><i class="bi bi-image"></i></button>
                                                    <button type="button" data-target="editor2"
                                                        data-command="removeFormat"><i class="bi bi-eraser"></i></button>
                                                </div>
                                                <div id="editor2" class="custom-editor" contenteditable="true">
                                                    {!! old('isi_konten2') !!}</div>
                                                <textarea name="isi_konten2" id="hiddenContent2" style="display:none;"></textarea>
                                            </div>
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
                                        <div class="mb-4">
                                            <label class="form-label">Isi Konten 3</label>
                                            <div class="custom-editor-container">
                                                <div class="editor-toolbar">
                                                    <button type="button" data-target="editor3" data-command="bold"><i
                                                            class="bi bi-type-bold"></i></button>
                                                    <button type="button" data-target="editor3" data-command="italic"><i
                                                            class="bi bi-type-italic"></i></button>
                                                    <button type="button" data-target="editor3"
                                                        data-command="underline"><i
                                                            class="bi bi-type-underline"></i></button>
                                                    <button type="button" data-target="editor3"
                                                        data-command="insertUnorderedList"><i
                                                            class="bi bi-list-ul"></i></button>
                                                    <button type="button" data-target="editor3"
                                                        data-command="insertOrderedList"><i
                                                            class="bi bi-list-ol"></i></button>
                                                    <button type="button" data-target="editor3"
                                                        data-command="createLink"><i
                                                            class="bi bi-link-45deg"></i></button>
                                                    <button type="button" data-target="editor3"
                                                        data-command="insertImage"><i class="bi bi-image"></i></button>
                                                    <button type="button" data-target="editor3"
                                                        data-command="removeFormat"><i class="bi bi-eraser"></i></button>
                                                </div>
                                                <div id="editor3" class="custom-editor" contenteditable="true">
                                                    {!! old('isi_konten3') !!}</div>
                                                <textarea name="isi_konten3" id="hiddenContent3" style="display:none;"></textarea>
                                            </div>
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
