@extends('admin.layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-xl-10 col-lg-11">
                        <div class="card shadow-sm rounded-4">
                            <div class="card-body px-5 py-4">

                                <h4 class="mb-5">Edit Header PPID</h4>
                                
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form class="forms-sample" method="POST"
                                    action="{{ route('admin.headerPpid.update', $headerPpid->id_header) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group">
                                        <label for="gambar" class="mb-2">Unggah Gambar (Opsional)</label>
                                        <div class="mb-4">
                                            <input type="file" id="gambar" name="gambar" accept="image/*"
                                                onchange="previewEditImage(event, 'newPreview', 'oldPreview')">

                                            {{-- Gambar Lama --}}
                                            @if ($headerPpid->gambar)
                                                <div class="mt-2">
                                                    <img id="oldPreview"
                                                        src="{{ asset('storage/' . $headerPpid->gambar) }}"
                                                        alt="Gambar Heading" width="120"
                                                        style="border-radius: 8px; border:1px solid #ddd; padding:4px;">
                                                </div>
                                            @endif

                                            {{-- Preview Gambar Baru --}}
                                            <div class="mt-2">
                                                <img id="newPreview" src="#" alt="Preview Gambar Baru"
                                                    style="display:none; max-width: 200px; border-radius: 8px; border:1px solid #ddd; padding:4px;">
                                            </div>
                                        </div>

                                        <label for="headline" class="mb-2">Headline</label>
                                        <div class="mb-4">
                                            <input type="text" class="form-control" id="headline" name="headline"
                                                placeholder="Masukkan Headline untuk gambar heading profile" value="{{ old('headline', $headerPpid->headline) }}">
                                        </div>

                                        <label for="sub_heading" class="mb-2">Sub Heading</label>
                                        <div class="mb-4">
                                            <textarea class="form-control" id="sub_heading" name="sub_heading" vrows="5"
                                                placeholder="Masukkan Sub Heading singkat untuk gambar heading profile">{{ old('sub_heading', $headerPpid->sub_heading) }}</textarea>
                                        </div>


                                        <button type="submit" class="btn btn-info me-2">Simpan</button>
                                        <a href="{{ route('admin.headerPpid.index') }}" class="btn btn-danger">Batal</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
