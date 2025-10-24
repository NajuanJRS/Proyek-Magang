@extends('Admin.layouts.app')

@section('content')
    <div class="container mt-4">
        <h4 class="mb-4">Konten Download</h4>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('admin.kontenDownload.create') }}" class="btn btn-primary">Tambah Kartu Download</a>
        </div>

        <div class="row">
            <h4 class="mb-4">Kartu Download</h4>
            @foreach ($kartuDownload as $k)
                @if (($k->halaman_induk ?? '') === 'Download')
                    <div class="col-md-4 mb-4" role="button" style="cursor:pointer;"
                        onclick="if(!event.target.closest('.btn')) { window.location='{{ route('admin.fileDownload.index', $k->slug) }}'; }">
                        <div class="card h-100 shadow-sm card-hover-animation">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('storage/icon/' . $k->icon) }}" alt="icon"
                                        width="64" height="64" class="me-2 rounded" style="object-fit:cover;">
                                    <h6 class="mb-0">{{ $k->nama_kategori }}</h6>
                                </div>
                                <div class="d-flex gap-2">
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('admin.kontenDownload.edit', $k->id_kategori) }}"
                                        class="btn btn-info btn-sm btn-circle rounded-circle d-inline-flex me-1">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    {{-- Tombol Delete --}}
                                    <a href="#"
                                        class="btn btn-danger btn-sm btn-circle rounded-circle d-inline-flex"
                                        onclick="deleteData('{{ $k->id_kategori }}')">
                                        <i class="bi bi-trash"></i>
                                    </a>

                                    <form id="delete-form-{{ $k->id_kategori }}"
                                        action="{{ route('admin.kontenDownload.destroy', $k->id_kategori) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <div class="row mt-4">
            <h4 class="mb-4">Kartu PPID</h4>
            @foreach ($kartuDownload as $k)
                @if (($k->halaman_induk ?? '') === 'PPID')
                    <div class="col-md-4 mb-4" role="button" style="cursor:pointer;"
                        onclick="if(!event.target.closest('.btn')) { window.location='{{ route('admin.fileDownload.index', $k->slug) }}'; }">
                        <div class="card h-100 shadow-sm card-hover-animation">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('storage/icon/' . $k->icon) }}" alt="icon"
                                        width="64" height="64" class="me-2 rounded" style="object-fit:cover;">
                                    <h6 class="mb-0">{{ $k->nama_kategori }}</h6>
                                </div>
                                <div class="d-flex gap-2">
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('admin.kontenDownload.edit', $k->id_kategori) }}"
                                        class="btn btn-info btn-sm btn-circle rounded-circle d-inline-flex me-1">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    {{-- Tombol Delete --}}
                                    <a href="#"
                                        class="btn btn-danger btn-sm btn-circle rounded-circle d-inline-flex"
                                        onclick="deleteData('{{ $k->id_kategori }}')">
                                        <i class="bi bi-trash"></i>
                                    </a>

                                    <form id="delete-form-{{ $k->id_kategori }}"
                                        action="{{ route('admin.kontenDownload.destroy', $k->id_kategori) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection
