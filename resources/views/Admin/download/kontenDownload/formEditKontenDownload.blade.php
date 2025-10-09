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

                                <h4 class="mb-5">Tambah Kartu Download</h4>

                                <form class="forms-sample" method="POST"
                                      action="{{ route('admin.kontenDownload.update', $kartuDownload->id_kategori) }}"
                                      enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    {{-- Nama Sub Kartu --}}
                                    <label for="nama_kategori" class="mb-2">Nama Sub Kartu</label>
                                    <div class="mb-4">
                                        <input type="text" class="form-control" id="nama_kategori" name="nama_kategori"
                                               value="{{ old('nama_kategori', $kartuDownload->nama_kategori) }}" placeholder="Masukkan Nama Sub Kartu" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="icon" class="mb-2">Unggah Icon (Opsional)</label>
                                        <div class="mb-4">
                                            <input type="file" id="icon" name="icon" accept="image/*"
                                                onchange="previewEditImage(event)">

                                            {{-- Gambar Lama --}}
                                            @if ($kartuDownload->icon)
                                                <div class="mt-2">
                                                    <img id="oldPreview"
                                                        src="{{ asset('storage/kontenDownload/' . $kartuDownload->icon) }}"
                                                        alt="Icon Heading" width="120"
                                                        style="border-radius: 8px; border:1px solid #ddd; padding:4px;">
                                                </div>
                                            @endif

                                            {{-- Preview Icon Baru --}}
                                            <div class="mt-2">
                                                <img id="newPreview" src="#" alt="Preview icon Baru"
                                                    style="display:none; max-width: 200px; border-radius: 8px; border:1px solid #ddd; padding:4px;">
                                            </div>
                                        </div>

                                    {{-- Nama Halaman --}}
                                    <label for="halaman_induk" class="mb-2">Nama Halaman</label>
                                    <div class="mb-4">
                                        <select class="form-control" id="halaman_induk" name="halaman_induk" required>
                                            <option value="" disabled {{ old('halaman_induk', $kartuDownload->halaman_induk) ? '' : 'selected' }}>Pilih Nama Halaman</option>
                                            <option value="Download" {{ old('halaman_induk', $kartuDownload->halaman_induk) == 'Download' ? 'selected' : '' }}>Download</option>
                                            <option value="PPID" {{ old('halaman_induk', $kartuDownload->halaman_induk) == 'PPID' ? 'selected' : '' }}>PPID</option>
                                        </select>
                                    </div>


                                    <button type="submit" class="btn btn-info me-2">Simpan</button>
                                    <a href="{{ route('admin.kontenDownload.index') }}" class="btn btn-danger">Batal</a>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
