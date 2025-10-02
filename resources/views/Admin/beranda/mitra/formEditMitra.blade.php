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
                                <h4 class="mb-5">Edit Mitra</h4>

                                <form class="forms-sample" method="POST"
                                    action="{{ route('admin.mitra.update', $mitra->id_mitra) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group">
                                        <label for="gambar" class="mb-2">Unggah Gambar (Opsional)</label>
                                        <div class="mb-4">
                                            <input type="file" id="gambar" name="gambar" accept="image/*"
                                                onchange="previewEditImage(event)">

                                            {{-- Gambar Lama --}}
                                            @if ($mitra->gambar)
                                                <div class="mt-2">
                                                    <img id="oldPreview"
                                                        src="{{ asset('storage/mitra/' . $mitra->gambar) }}"
                                                        alt="Gambar Mitra" width="120"
                                                        style="border-radius: 8px; border:1px solid #ddd; padding:4px;">
                                                </div>
                                            @endif

                                            {{-- Preview Gambar Baru --}}
                                            <div class="mt-2">
                                                <img id="newPreview" src="#" alt="Preview Gambar Baru"
                                                    style="display:none; max-width: 200px; border-radius: 8px; border:1px solid #ddd; padding:4px;">
                                            </div>
                                        </div>

                                        <label for="nama_mitra" class="mb-2">Nama Mitra</label>
                                        <div class="mb-4">
                                            <textarea class="form-control" id="nama_mitra" name="nama_mitra"
                                                placeholder="Masukkan link mitra">{{ old('nama_mitra', $mitra->nama_mitra) }}</textarea>
                                        </div>

                                        <label for="link_mitra" class="mb-2">Link Mitra</label>
                                        <div class="mb-4">
                                            <textarea class="form-control" id="link_mitra" name="link_mitra"
                                                placeholder="Masukkan link mitra">{{ old('link_mitra', $mitra->link_mitra) }}</textarea>
                                        </div>


                                        <button type="submit" class="btn btn-info me-2">Simpan</button>
                                        <a href="{{ route('admin.mitra.index') }}" class="btn btn-danger">Batal</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
