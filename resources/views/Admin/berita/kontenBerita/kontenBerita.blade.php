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
                                    <h4 class="card-title mb-0">Berita</h4>
                                </div>
                                <div class="d-flex justify-content-end align-items-center mb-3">
                                    <a href="{{ route('admin.berita.create') }}"
                                        class="btn btn-primary rounded-3 px-4 py-2 d-flex align-items-center gap-2"
                                        style="font-weight:500;">
                                        <i class="bi bi-plus"></i> Tambah Berita
                                    </a>
                                </div>

                                <div class="d-flex justify-content-end mb-4">
                                    <form action="{{ route('admin.berita.index') }}" method="GET" style="width: 270px;">
                                        <div class="input-group input-group-sm">
                                            <input type="text" id="searchInput" class="form-control"
                                                placeholder="Cari Judul berita..." name="search" value="{{ request('search') }}">
                                            <button class="btn btn-info" type="submit">
                                                <i class="bi bi-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <div class="table-responsive custom-table-container"
                                    style="overflow-x:auto; white-space:nowrap;">
                                    <table class="table table-hover align-middle datatable">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No.</th>
                                                <th class="text-center kolom-judul">Judul</th>
                                                <th class="text-center">Gambar 1</th>
                                                <th class="text-center">Isi Berita 1</th>
                                                <th class="text-center">Gambar 2</th>
                                                <th class="text-center">Isi Berita 2</th>
                                                <th class="text-center">Gambar 3</th>
                                                <th class="text-center">Isi Berita 3</th>
                                                <th class="text-center">Tanggal Posting</th>
                                                <th class="text-center">Dibaca</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($berita as $b)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td class="kolom-judul">
                                                        @php
                                                            $fullText = trim(
                                                                preg_replace(
                                                                    '/\s+/',
                                                                    ' ',
                                                                    html_entity_decode(
                                                                        strip_tags($b->judul ?? ''),
                                                                    ),
                                                                ),
                                                            );
                                                        @endphp
                                                        @if ($fullText)
                                                            <div class="preview-text"
                                                                style="max-width:420px; white-space:normal; overflow:hidden;">
                                                                {{ \Illuminate\Support\Str::limit($fullText, 20) }}
                                                            </div>
                                                            @if (mb_strlen($fullText) > 20)
                                                                <button type="button" class="btn btn-link p-0 see-more"
                                                                    data-id="{{ $b->id_berita }}-4"
                                                                    data-judul="Detail Judul">
                                                                    Lihat selengkapnya
                                                                </button>
                                                            @endif
                                                            <div id="full-content-{{ $b->id_berita }}-4" class="d-none">
                                                                {!! $b->judul !!}
                                                            </div>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>

                                                    {{-- Gambar 1 --}}
                                                    <td class="text-center">
                                                        @if ($b->gambar1)
                                                            <img src="{{ asset('storage/berita/' . $b->gambar1) }}"
                                                                alt="gambar berita" width="100"
                                                                style="border-radius: 6px; border: 1px solid #ddd;">
                                                        @else
                                                            -
                                                        @endif
                                                    </td>

                                                    {{-- Isi Berita 1 --}}
                                                    <td class="isi-konten">
                                                        @php
                                                            $fullText = trim(
                                                                preg_replace(
                                                                    '/\s+/',
                                                                    ' ',
                                                                    html_entity_decode(
                                                                        strip_tags($b->isi_berita1 ?? ''),
                                                                    ),
                                                                ),
                                                            );
                                                        @endphp
                                                        @if ($fullText)
                                                            <div class="preview-text"
                                                                style="max-width:420px; white-space:normal; overflow:hidden;">
                                                                {{ \Illuminate\Support\Str::limit($fullText, 90) }}
                                                            </div>
                                                            @if (mb_strlen($fullText) > 90)
                                                                <button type="button" class="btn btn-link p-0 see-more"
                                                                    data-id="{{ $b->id_berita }}-1"
                                                                    data-judul="{{ $b->judul }}">
                                                                    Lihat selengkapnya
                                                                </button>
                                                            @endif
                                                            <div id="full-content-{{ $b->id_berita }}-1" class="d-none">
                                                                {!! $b->isi_berita1 !!}
                                                            </div>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>

                                                    {{-- Gambar 2 --}}
                                                    <td class="text-center">
                                                        @if ($b->gambar2)
                                                            <img src="{{ asset('storage/berita/' . $b->gambar2) }}"
                                                                alt="gambar berita" width="100"
                                                                style="border-radius: 6px; border: 1px solid #ddd;">
                                                        @else
                                                            -
                                                        @endif
                                                    </td>

                                                    {{-- Isi Berita 2 --}}
                                                    <td class="isi-konten">
                                                        @php
                                                            $fullText = trim(
                                                                preg_replace(
                                                                    '/\s+/',
                                                                    ' ',
                                                                    html_entity_decode(
                                                                        strip_tags($b->isi_berita2 ?? ''),
                                                                    ),
                                                                ),
                                                            );
                                                        @endphp
                                                        @if ($fullText)
                                                            <div class="preview-text"
                                                                style="max-width:420px; white-space:normal; overflow:hidden;">
                                                                {{ \Illuminate\Support\Str::limit($fullText, 90) }}
                                                            </div>
                                                            @if (mb_strlen($fullText) > 90)
                                                                <button type="button" class="btn btn-link p-0 see-more"
                                                                    data-id="{{ $b->id_berita }}-2"
                                                                    data-judul="{{ $b->judul }}">
                                                                    Lihat selengkapnya
                                                                </button>
                                                            @endif
                                                            <div id="full-content-{{ $b->id_berita }}-2" class="d-none">
                                                                {!! $b->isi_berita2 !!}
                                                            </div>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>

                                                    {{-- Gambar 3 --}}
                                                    <td class="text-center">
                                                        @if ($b->gambar3)
                                                            <img src="{{ asset('storage/berita/' . $b->gambar3) }}"
                                                                alt="gambar berita" width="100"
                                                                style="border-radius: 6px; border: 1px solid #ddd;">
                                                        @else
                                                            -
                                                        @endif
                                                    </td>

                                                    {{-- Isi Berita 3 --}}
                                                    <td class="isi-konten">
                                                        @php
                                                            $fullText = trim(
                                                                preg_replace(
                                                                    '/\s+/',
                                                                    ' ',
                                                                    html_entity_decode(
                                                                        strip_tags($b->isi_berita3 ?? ''),
                                                                    ),
                                                                ),
                                                            );
                                                        @endphp
                                                        @if ($fullText)
                                                            <div class="preview-text"
                                                                style="max-width:420px; white-space:normal; overflow:hidden;">
                                                                {{ \Illuminate\Support\Str::limit($fullText, 90) }}
                                                            </div>
                                                            @if (mb_strlen($fullText) > 90)
                                                                <button type="button" class="btn btn-link p-0 see-more"
                                                                    data-id="{{ $b->id_berita }}-3"
                                                                    data-judul="{{ $b->judul }}">
                                                                    Lihat selengkapnya
                                                                </button>
                                                            @endif
                                                            <div id="full-content-{{ $b->id_berita }}-3" class="d-none">
                                                                {!! $b->isi_berita3 !!}
                                                            </div>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>

                                                    <td class="text-center">{{ $b->tgl_posting }}</td>
                                                    <td class="text-center">{{ $b->dibaca }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ route('admin.berita.edit', $b->id_berita) }}"
                                                            class="btn btn-info btn-sm btn-circle rounded-circle d-inline-flex me-1">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-danger btn-sm btn-circle rounded-circle d-inline-flex"
                                                            onclick="deleteData('{{ $b->id_berita }}')">
                                                            <i class="bi bi-trash"></i>
                                                        </a>
                                                        <form id="delete-form-{{ $b->id_berita }}"
                                                            action="{{ route('admin.berita.destroy', $b->id_berita) }}"
                                                            method="POST" style="display:none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="11" class="text-center">Data tidak ditemukan.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mt-4 d-flex justify-content-end">
                                    {{ $berita->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
