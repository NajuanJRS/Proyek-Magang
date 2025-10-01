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
                                <h4 class="mb-5">Tambah Slider</h4>

                                <form class="forms-sample" method="POST" action="{{ route('admin.slider.store') }}"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <label for="gambar" class="mb-2">Unggah Gambar</label>
                                    <div class="mb-4">
                                        <input type="file" id="gambar" name="gambar" accept="image/*"
                                            onchange="previewImage(event)">
                                        <div class="mt-3">
                                            <img id="preview" src="#" alt="Preview Gambar"
                                                style="display: none; max-width: 200px; border-radius: 8px; border: 1px solid #ddd; padding: 4px;">
                                        </div>
                                    </div>

                                    <label for="id_kategori_header" class="mb-2">Kategori Header</label>
                                    <div class="mb-4">
                                        <select class="form-select" id="id_kategori_header" name="id_kategori_header">
                                            <option value="" selected disabled>Pilih Kategori Header</option>
                                            @foreach ($kategoriHeader as $k)
                                                <option value="{{ $k->id_kategori_header }}">{{ $k->nama_kategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <label for="headline" class="mb-2">Headline</label>
                                    <div class="mb-4">
                                        <input type="text" class="form-control" id="headline" name="headline"
                                            placeholder="Masukkan Headline untuk gambar slider">
                                    </div>

                                    <label for="sub_heading" class="mb-2">Sub Heading</label>
                                    <div class="mb-4">
                                        <textarea class="form-control" id="sub_heading" name="sub_heading" rows="5"
                                            placeholder="Masukkan Sub Heading singkat untuk gambar slider"></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-info me-2">Simpan</button>
                                    <a href="{{ route('admin.slider.index') }}" class="btn btn-danger">Batal</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
