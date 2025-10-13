@extends('Admin.layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-xl-12 col-lg-11">
                        <div class="card shadow-sm rounded-4">
                            <div class="card-body px-4 py-4">

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="card-title mb-0">
                                        File Download{!! isset($kategori) && $kategori ? ' - ' . e($kategori->nama_kategori) : '' !!}
                                    </h4>
                                </div>

                                <div class="d-flex justify-content-end align-items-center mb-3 gap-2">
                                    <a href="{{ route('admin.kontenDownload.index') }}"
                                        class="btn btn-secondary rounded-3 px-3 py-2">
                                        <i class="bi bi-arrow-left"></i> Kembali
                                    </a>
                                    <a href="{{ route('admin.fileDownload.create', $kategori->slug ?? '') }}"
                                        class="btn btn-primary rounded-3 px-4 py-2 d-flex align-items-center gap-2"
                                        style="font-weight:500;">
                                        <i class="bi bi-plus"></i> Tambah File
                                    </a>
                                </div>

                                <div class="d-flex justify-content-end mb-4">
                                    <form action="{{ route('admin.fileDownload.index', $kategori->slug ?? null) }}"
                                        method="GET" style="width: 270px;">
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control" name="search"
                                                placeholder="Cari file..." value="{{ request('search') }}">
                                            <button class="btn btn-info" type="submit">
                                                <i class="bi bi-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <div class="table-responsive custom-table-container">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No.</th>
                                                <th class="text-center">Nama File</th>
                                                <th class="text-center">File</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($download as $f)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td class="text-center">{{ $f->nama_file }}</td>

                                                    @php
                                                        $fullText = trim(
                                                            preg_replace(
                                                                '/\s+/',
                                                                ' ',
                                                                html_entity_decode(strip_tags($f->file)),
                                                            ),
                                                        );
                                                    @endphp

                                                    <td class="text-center">
                                                        <a href="{{ asset('storage/upload/file/' . $f->file) }}"
                                                            target="_blank"
                                                            style="text-decoration: none; color: #0d6efd; font-weight: 500;">
                                                            {{ $f->file }}
                                                        </a>
                                                    </td>

                                                    <td class="text-center">
                                                        <a href="{{ route('admin.fileDownload.edit', ['id' => $f->id_file, 'kategori' => $kategori->slug ?? '']) }}"
                                                            class="btn btn-info btn-sm">
                                                            <i class="bi bi-pencil-square"></i> Ubah
                                                        </a>

                                                        {{-- Tombol Delete --}}
                                                        <a href="#" class="btn btn-sm btn-danger"
                                                            onclick="deleteData('{{ $f->id_file }}')">
                                                            <i class="bi bi-trash"></i>Hapus</a>

                                                        <form id="delete-form-{{ $f->id_file }}"
                                                            action="{{ route('admin.fileDownload.destroy', $f->id_file) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center">Belum ada file di kategori ini.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mt-4">
                                    {{ $download->links() }}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
