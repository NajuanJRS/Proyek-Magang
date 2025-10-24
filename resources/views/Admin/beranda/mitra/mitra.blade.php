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
                                    <h4 class="card-title mb-0">Mitra</h4>
                                </div>
                                <div class="d-flex justify-content-end align-items-center mb-3">
                                    <a href="{{ route('admin.mitra.create') }}"
                                        class="btn btn-primary rounded-3 px-4 py-2 d-flex align-items-center gap-2"
                                        style="font-weight:500;">
                                        <i class="bi bi-plus"></i> Tambah Mitra
                                    </a>
                                </div>

                                <div class="d-flex justify-content-end mb-4">
                                    <form action="{{ route('admin.mitra.index') }}" method="GET" style="width: 270px;">
                                        <div class="input-group input-group-sm">
                                            <input type="text" id="searchInput" class="form-control"
                                                placeholder="Cari mitra..." name="search" value="{{ request('search') }}">
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
                                                <th class="text-center">Nama Mitra</th>
                                                <th class="text-center">Link Mitra</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($mitra as $m)
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td class="text-center">
                                                            <img src="{{ asset('storage/' . $m->gambar) }}"
                                                                width="100">
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $m->nama_mitra ?? '-' }}</td>

                                                        @php
                                                            $fullText = trim(
                                                                preg_replace(
                                                                    '/\s+/',
                                                                    ' ',
                                                                    html_entity_decode(strip_tags($m->link_mitra)),
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
                                                                    data-id="{{ $m->id_mitra }}" data-judul="Keterangan">
                                                                    Lihat selengkapnya
                                                                </button>
                                                            @endif
                                                        </td>

                                                        <td class="text-center">
                                                            <a href="{{ route('admin.mitra.edit', $m->id_mitra) }}"
                                                                class="btn btn-info btn-sm btn-circle rounded-circle d-inline-flex me-1">
                                                                <i class="bi bi-pencil-square"></i>
                                                            </a>
                                                            <a href="#" class="btn btn-danger btn-sm btn-circle rounded-circle d-inline-flex"
                                                                onclick="deleteData('{{ $m->id_mitra }}')">
                                                                <i class="bi bi-trash"></i>
                                                            </a>

                                                            <form id="delete-form-{{ $m->id_mitra }}"
                                                                action="{{ route('admin.mitra.destroy', $m->id_mitra) }}"
                                                                method="POST" style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        </td>
                                                    </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">Data tidak ditemukan.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-4 d-flex justify-content-end">
                                    {{ $mitra->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
