@extends('admin.layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-xl-10 col-lg-11">
                        <div class="card shadow-sm rounded-4">
                            <div class="card-body px-5 py-4">

                                <h4 class="mb-5">Edit FAQ</h4>
                                
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('admin.faq.update', $faq->id_faq) }}">
                                    @csrf
                                    @method('PUT')

                                    {{-- Pertanyaan --}}
                                    <label for="pertanyaan" class="mb-2">Pertanyaan</label>
                                    <div class="mb-4">
                                        <input type="text" class="form-control" id="pertanyaan" name="pertanyaan"
                                            value="{{ old('pertanyaan', $faq->pertanyaan) }}"
                                            placeholder="Masukkan Pertanyaan FAQ">
                                    </div>

                                    {{-- Kategori FAQ --}}
                                    <label for="kategori_faq" class="mb-2">Kategori FAQ</label>
                                    <div class="mb-4">
                                        <select class="form-select" id="kategori_faq" name="kategori_faq" required>
                                            <option value="" disabled selected>Pilih Kategori FAQ</option>
                                            @foreach ($kategoriFaq as $kategori)
                                                <option value="{{ $kategori->id_kategori_faq }}"
                                                    {{ old('kategori_faq', $faq->id_kategori_faq) == $kategori->id_kategori_faq ? 'selected' : '' }}>
                                                    {{ $kategori->nama_kategori_faq }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Jawaban --}}
                                    <div class="mb-4">
                                    <label class="form-label">Jawaban</label>
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
                                        <div id="editor1" class="custom-editor" contenteditable="true">{!! old('jawaban', $faq->jawaban) !!}</div>
                                        <textarea name="jawaban" id="hiddenContent1" style="display:none;"></textarea>
                                    </div>
                                </div>

                                    {{-- Tombol --}}
                                    <button type="submit" class="btn btn-info me-2">Simpan</button>
                                    <a href="{{ route('admin.faq.index') }}" class="btn btn-danger">Batal</a>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
