@extends('admin.layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-xl-10 col-lg-11">
                        <div class="card shadow-sm rounded-4">
                            <div class="card-body px-5 py-4">

                                <h4 class="mb-5">Edit Pejabat</h4>

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
                                    action="{{ route('admin.pejabat.update', $pejabat->id_pejabat) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    {{-- Nama Pejabat --}}
                                    <label for="nama_pejabat" class="mb-2">Nama Pejabat</label>
                                    <div class="mb-4">
                                        <input class="form-control" id="nama_pejabat" name="nama_pejabat"
                                            value="{{ old('nama_pejabat', $pejabat->nama_pejabat) }}"
                                            placeholder="Masukkan Nama Pejabat">
                                    </div>

                                    {{-- Jabatan --}}
                                    <label for="id_jabatan" class="mb-2">Jabatan</label>
                                    <div class="mb-4">
                                        <select class="form-select" id="id_jabatan" name="id_jabatan" required>
                                            <option value="" disabled>-- Pilih Jabatan --</option>
                                            @foreach ($jabatan as $j)
                                                <option value="{{ $j->id_jabatan }}" data-nama="{{ $j->nama_jabatan }}"
                                                    {{ old('id_jabatan', $pejabat->id_jabatan) == $j->id_jabatan ? 'selected' : '' }}>
                                                    {{ $j->nama_jabatan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Upload Gambar --}}
                                    <label for="gambar" class="mb-2">Unggah Gambar (Opsional)</label>
                                    <div class="mb-4">
                                        <input type="file" id="gambar" name="gambar" accept="image/*"
                                            onchange="previewEditImage(event, 'newPreview', 'oldPreview')">
                                        <div class="mt-3">
                                            {{-- Preview gambar baru --}}
                                            <img id="newPreview" src="#" alt="Preview Gambar Baru"
                                                style="display:none; max-width:200px; border-radius:8px; border:1px solid #ddd; padding:4px;">

                                            {{-- Gambar lama --}}
                                            @if ($pejabat->gambar)
                                                <img id="oldPreview" src="{{ asset('media/' . $pejabat->gambar) }}"
                                                    alt="Gambar Lama" style="max-width:200px; border-radius:8px; border:1px solid #ddd; padding:4px;">
                                            @endif
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
