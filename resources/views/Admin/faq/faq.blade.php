@extends('admin.layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-xl-12 col-lg-11">
                        <div class="card shadow-sm rounded-4">
                            <div class="card-body px-4 py-4">

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="card-title mb-0">FAQ</h4>
                                </div>
                                <div class="d-flex justify-content-end align-items-center mb-3">
                                    <a href="{{ route('admin.faq.create') }}"
                                        class="btn btn-primary rounded-3 px-4 py-2 d-flex align-items-center gap-2"
                                        style="font-weight:500;">
                                        <i class="bi bi-plus"></i> Tambah FAQ
                                    </a>
                                </div>

                                <div class="d-flex justify-content-end mb-4">
                                    <form action="{{ route('admin.faq.index') }}" method="GET" style="width: 270px;">
                                        <div class="input-group input-group-sm">
                                            <input type="text" id="searchInput" class="form-control"
                                                placeholder="Cari FAQ..." name="search" value="{{ request('search') }}">
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
                                            <th style="width: 5%;">No.</th>
                                            <th style="width: 75%;">Pertanyaan</th>
                                            <th class="text-center" style="width: 50%;">Kategori FAQ</th>
                                            <th class="text-center" style="width: 20%;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($faq as $f)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="isi-konten">{{ $f->pertanyaan }}</td>
                                                <td class="text-center">{{ $f->kategoriFaq->nama_kategori_faq ?? '-' }}</td>
                                                <td class="text-center">
                                                    {{-- Tombol lihat selengkapnya --}}
                                                    <button type="button" title="Lihat Detail" class="btn btn-warning btn-sm see-more"
                                                        data-id="{{ $f->id_faq }}" data-judul="{{ $f->pertanyaan }}">
                                                        <i class="bi bi-eye"></i> Jawaban
                                                    </button>

                                                    {{-- Full content untuk SweetAlert --}}
                                                    <div id="full-content-{{ $f->id_faq }}" class="d-none">
                                                        {!! $f->jawaban !!}
                                                    </div>
                                                    <a href="{{ route('admin.faq.edit', $f->id_faq) }}"
                                                        class="btn btn-info btn-sm" title="Ubah"><i
                                                            class="bi bi-pencil"></i>Ubah</a>
                                                    <a href="#" class="btn btn-danger btn-sm"
                                                        onclick="deleteData('{{ $f->id_faq }}')" title="Hapus"><i
                                                            class="bi bi-trash"></i>Hapus</a>

                                                    <form id="delete-form-{{ $f->id_faq }}"
                                                        action="{{ route('admin.faq.destroy', $f->id_faq) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                            </tr>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">Data tidak ditemukan.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                </div>
                                <div class="mt-4">
                                    {{ $faq->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
