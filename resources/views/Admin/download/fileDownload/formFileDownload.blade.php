@extends('Admin.layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card shadow-sm rounded-4">
            <div class="card-body px-4 py-4">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <h4 class="card-title mb-3">Tambah File Download</h4>

                <form action="{{ route('admin.fileDownload.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_kategori" value="{{ $kategori->id_kategori }}">

                    <div class="mb-3">
                        <label class="form-label">Nama File</label>
                        <input type="text" name="nama_file" class="form-control" required>
                    </div>

                    <label class="form-label">Upload File</label>
                    <div class="mb-4">
                        <input type="file" name="file" required>
                    </div>

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
