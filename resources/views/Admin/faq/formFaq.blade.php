@extends('admin.layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-xl-10 col-lg-11">
                        <div class="card shadow-sm rounded-4">
                            <div class="card-body px-5 py-4">

                                {{-- Error Handling --}}
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                {{-- Judul --}}
                                <h4 class="mb-5">Tambah FAQ</h4>

                                <form method="POST" action="{{ route('admin.faq.store') }}">
                                    @csrf

                                    {{-- Pertanyaan --}}
                                    <label for="pertanyaan" class="mb-2">Pertanyaan</label>
                                    <div class="mb-4">
                                        <input type="text" class="form-control" id="pertanyaan" name="pertanyaan"
                                            placeholder="Masukkan Pertanyaan FAQ" required>
                                    </div>

                                    {{-- Kategori FAQ --}}
                                    <label for="kategori_faq" class="mb-2">Kategori FAQ</label>
                                    <div class="mb-4">
                                        <select class="form-select" id="kategori_faq" name="kategori_faq" required>
                                            <option value="" disabled selected>Pilih Kategori FAQ</option>
                                            @foreach ($kategoriFaq as $k)
                                                <option value="{{ $k->id_kategori_faq }}">
                                                    {{ $k->nama_kategori_faq }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Jawaban --}}
                                    <label for="jawaban" class="mb-2">Jawaban</label>
                                    <div class="mb-4">
                                        <textarea class="form-control my-editor" id="jawaban" name="jawaban" rows="6"
                                            placeholder="Masukkan Jawaban FAQ" required></textarea>
                                    </div>

                                    {{-- Tombol submit --}}
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
