@extends('Admin.layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm rounded-4">
        <div class="card-body px-4 py-4">
            <h4 class="card-title mb-3">Edit File Download</h4>

            <form action="{{ route('admin.fileDownload.update', $fileDownload->id_file) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <input type="hidden" name="id_kategori" value="{{ $kategori->id_kategori }}">

                {{-- Nama File --}}
                <div class="mb-3">
                    <label class="form-label">Nama File</label>
                    <input type="text" name="nama_file"
                           value="{{ old('nama_file', $fileDownload->nama_file) }}"
                           class="form-control" required>
                </div>

                {{-- Upload File Baru --}}
                <label class="form-label">Ganti File (Opsional)</label>
                <div class="mb-2">
                    <div class="mb-2">
                        <a href="{{ asset('storage/upload/file/' . $fileDownload->file) }}"
                           target="_blank"
                           class="text-primary">
                            {{ \Illuminate\Support\Str::after($fileDownload->file, '_') }}
                        </a>
                    </div>
                    <input type="file" name="file">
                </div>
                <small class="text-muted">Biarkan kosong jika tidak ingin mengganti file.</small>

                {{-- Tombol Aksi --}}
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.fileDownload.index', $kategori->slug) }}" class="btn btn-danger">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
