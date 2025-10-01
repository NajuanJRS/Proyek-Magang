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
                                    <h4 class="card-title mb-0">Hero Section</h4>
                                </div>
                                <div class="d-flex justify-content-end align-items-center mb-3">
                                    <a href="{{ route('admin.slider.create') }}"
                                        class="btn btn-primary rounded-3 px-4 py-2 d-flex align-items-center gap-2"
                                        style="font-weight:500;">
                                        <i class="bi bi-plus"></i> Tambah Hero Section
                                    </a>
                                </div>

                                <div class="d-flex justify-content-end mb-4">
                                    <form action="{{ route('admin.slider.index') }}" method="GET" style="width: 270px;">
                                        <div class="input-group input-group-sm">
                                            <input type="text" id="searchInput" class="form-control"
                                                placeholder="Cari hero section..." name="search" value="{{ request('search') }}">
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
                                                <th class="text-center">Gambar</th>
                                                <th class="text-center">Kategori Header</th>
                                                <th class="text-center">Headline</th>
                                                <th class="text-center">Sub Heading</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $no = 1; @endphp
                                            @forelse($slider as $s)
                                                @if (($s->kategoriHeader->nama_kategori ?? '') === 'Hero Section')
                                                    <tr>
                                                        <td class="text-center">{{ $no++ }}</td>
                                                        <td class="text-center">
                                                            <img src="{{ asset('storage/header/' . $s->gambar) }}"
                                                                width="150" alt="Gambar Slider">
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $s->kategoriHeader->nama_kategori ?? '-' }}</td>

                                                        <td class="text-center">{{ $s->headline ?? '-' }}</td>
                                                        @php
                                                            $fullText = trim(
                                                                preg_replace(
                                                                    '/\s+/',
                                                                    ' ',
                                                                    html_entity_decode(strip_tags($s->sub_heading)),
                                                                ),
                                                            );
                                                        @endphp

                                                        <td class="isi-konten text-center">
                                                            <div class="preview-text"
                                                                style="max-width:520px; white-space:normal; overflow:hidden;">
                                                                {{ \Illuminate\Support\Str::limit($fullText, 160) }}
                                                            </div>

                                                            @if (mb_strlen($fullText) > 160)
                                                                <button type="button" class="btn btn-link p-0 see-more"
                                                                    data-id="{{ $s->id_header }}" data-judul="sub_heading">
                                                                    Lihat selengkapnya
                                                                </button>
                                                            @endif

                                                            <div id="full-content-{{ $s->id_header }}" class="d-none">
                                                                {{ $s->sub_heading ?? '-' }}
                                                            </div>
                                                        </td>

                                                        <td class="text-center">
                                                            <a href="{{ route('admin.slider.edit', $s->id_header) }}"
                                                                class="btn btn-info btn-sm">
                                                                <i class="bi bi-pencil-square"></i> Ubah
                                                            </a>
                                                            <a href="#" class="btn btn-danger btn-sm"
                                                                onclick="deleteData('{{ $s->id_header }}')">
                                                                <i class="bi bi-trash"></i> Hapus
                                                            </a>

                                                            <form id="delete-form-{{ $s->id_header }}"
                                                                action="{{ route('admin.slider.destroy', $s->id_header) }}"
                                                                method="POST" style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">Data tidak ditemukan.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-4">
                                    {{ $slider->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
