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

                                <h4 class="mb-5">Tambah Pejabat</h4>

                                <form class="forms-sample" method="POST" action="{{ route('admin.pejabat.store') }}"
                                    enctype="multipart/form-data">
                                    @csrf

                                    {{-- Nama Pejabat --}}
                                    <label for="nama_pejabat" class="mb-2">Nama Pejabat</label>
                                    <div class="mb-4">
                                        <input class="form-control" id="nama_pejabat" name="nama_pejabat"
                                            value="{{ old('nama_pejabat') }}" placeholder="Masukkan Nama Pejabat">
                                    </div>

                                    {{-- NIP --}}
                                    <label for="nip" class="mb-2">NIP</label>
                                    <div class="mb-4">
                                        <input class="form-control" id="nip" name="nip"
                                            value="{{ old('nip') }}" placeholder="Masukkan NIP">
                                    </div>

                                    {{-- Jabatan --}}
                                    <label for="id_jabatan" class="mb-2">Jabatan</label>
                                    <div class="mb-4">
                                        <select class="form-select" id="id_jabatan" name="id_jabatan" required>
                                            <option value="" selected disabled>-- Pilih Jabatan --</option>
                                            @foreach ($jabatan as $j)
                                                <option value="{{ $j->id_jabatan }}"
                                                    {{ old('id_jabatan', $pejabat->id_jabatan ?? '') == $j->id_jabatan ? 'selected' : '' }}>
                                                    {{ $j->nama_jabatan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Upload Gambar --}}
                                    <label for="gambar" class="mb-2">Unggah Gambar</label>
                                    <div class="mb-4">
                                        <input type="file" id="gambar" name="gambar" accept="image/*"
                                            onchange="previewImage(event, 'preview')">
                                        <div class="mt-3">
                                            <img id="preview" src="#" alt="Preview Gambar"
                                                style="display:none; max-width:200px; border-radius:8px; border:1px solid #ddd; padding:4px;">
                                        </div>
                                    </div>

                                    {{-- Tombol --}}
                                    <button type="submit" class="btn btn-info me-2">Simpan</button>
                                    <a href="{{ route('admin.pejabat.index') }}" class="btn btn-danger">Batal</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
