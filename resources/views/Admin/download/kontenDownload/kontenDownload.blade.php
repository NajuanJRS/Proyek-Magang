@extends('Admin.layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Download</h4>
            <a href="{{ route('admin.kontenDownload.create') }}" class="btn btn-primary">Tambah Kartu Download</a>
        </div>

        <div class="row">
    @foreach ($kartuDownload as $k)
        <div class="col-md-4 mb-4">
            <a href="{{ route('admin.fileDownload.index', $k->slug) }}"
               class="text-decoration-none text-dark">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('storage/kontenDownload/' . $k->icon) }}"
                                 alt="icon"
                                 width="64" height="64"
                                 class="me-2 rounded"
                                 style="object-fit:cover;">

                            <h6 class="mb-0">{{ $k->nama_kategori }}</h6>
                        </div>
                        <div class="d-flex gap-2">
                            {{-- Tombol Edit --}}
                            <a href="{{ route('admin.kontenDownload.edit', $k->id_kategori) }}"
                               class="btn btn-sm btn-warning">Edit</a>

                            {{-- Tombol Delete --}}
                            <a href="#" class="btn btn-sm btn-danger"
                               onclick="deleteData('{{ $k->id_kategori }}')">
                               <i class="bi bi-trash"></i>Hapus</a>

                            <form id="delete-form-{{ $k->id_kategori }}"
                                  action="{{ route('admin.kontenDownload.destroy', $k->id_kategori) }}"
                                  method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>

@endsection
