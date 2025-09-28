@extends('admin.layouts.app')

@section('content')
<div class="container-scroller">
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">

                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h4 class="card-title mb-0">Manajemen Konten</h4>
                                    <a href="{{ route('admin.layanan.create') }}" class="btn btn-gradient-info btn-fw">
                                        <i class="mdi mdi-plus"></i> Tambah Layanan
                                    </a>
                                </div>

                                <div class="d-flex justify-content-end mb-4">
                                    <form action="{{ route('admin.layanan.index') }}" method="GET"
                                        style="width: 270px;">
                                        <div class="input-group input-group-sm">
                                            <input type="text" id="searchInput" class="form-control"
                                                placeholder="Cari judul layanan..." name="search"
                                                value="{{ request('search') }}">
                                            <button class="btn btn-gradient-info" type="submit">
                                                <i class="mdi mdi-magnify"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="table-responsive custom-table-container">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th class="text-center">Icon</th>
                                            <th class="text-center">Judul</th>
                                            <th class="text-center">Gambar 1</th>
                                            <th class="text-center">Isi Layanan 1</th>
                                            <th class="text-center">Gambar 2</th>
                                            <th class="text-center">Isi Layanan 2</th>
                                            <th class="text-center">Gambar 3</th>
                                            <th class="text-center">Isi Layanan 3</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($layanan as $l)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                {{-- Icon --}}
                                                    <td class="text-center">
                                                        @if (!empty($l->icon))
                                                            <div
                                                                style="width: 50px; height: 50px; margin: auto; overflow: hidden; border-radius: 8px; border: 1px solid #ddd;">
                                                                <img src="{{ asset('storage/icon/' . $l->icon) }}"
                                                                    alt="gambar icon"
                                                                    style="width: 100%; height: 100%; object-fit: cover;">
                                                            </div>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                <td class="text-center">{{ $l->judul }}
                                                {{-- Gambar 1 --}}
                                                    <td class="text-center">
                                                        @if (!empty($l->gambar1))
                                                            <div
                                                                style="width: 50px; height: 50px; margin: auto; overflow: hidden; border-radius: 8px; border: 1px solid #ddd;">
                                                                <img src="{{ asset('storage/layanan/' . $l->gambar1) }}"
                                                                    alt="gambar berita"
                                                                    style="width: 100%; height: 100%; object-fit: cover;">
                                                            </div>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>

                                                    {{-- Isi Berita 1 --}}
                                                    @php
                                                        $fullText = trim(
                                                            preg_replace(
                                                                '/\s+/',
                                                                ' ',
                                                                html_entity_decode(strip_tags($l->isi_layanan1 ?? '')),
                                                            ),
                                                        );
                                                    @endphp
                                                    <td class="isi-konten">
                                                        @if (!empty($fullText))
                                                            <div class="preview-text"
                                                                style="max-width:520px; white-space:normal; overflow:hidden;">
                                                                {{ \Illuminate\Support\Str::limit($fullText, 160) }}
                                                            </div>

                                                            @if (mb_strlen($fullText) > 160)
                                                                <button type="button" class="btn btn-link p-0 see-more"
                                                                    data-id="{{ $l->id_layanan }}-1"
                                                                    data-judul="{{ $l->judul }}">
                                                                    Lihat selengkapnya
                                                                </button>
                                                            @endif

                                                            <div id="full-content-{{ $l->id_layanan }}-1" class="d-none">
                                                                {!! $l->isi_layanan1 !!}
                                                            </div>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                {{-- Gambar 2 --}}
                                                    <td class="text-center">
                                                        @if (!empty($l->gambar2))
                                                            <div
                                                                style="width: 50px; height: 50px; margin: auto; overflow: hidden; border-radius: 8px; border: 1px solid #ddd;">
                                                                <img src="{{ asset('storage/layanan/' . $l->gambar2) }}"
                                                                    alt="gambar berita"
                                                                    style="width: 100%; height: 100%; object-fit: cover;">
                                                            </div>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>

                                                    {{-- Isi Berita 2 --}}
                                                    @php
                                                        $fullText = trim(
                                                            preg_replace(
                                                                '/\s+/',
                                                                ' ',
                                                                html_entity_decode(strip_tags($l->isi_layanan2 ?? '')),
                                                            ),
                                                        );
                                                    @endphp
                                                    <td class="isi-konten">
                                                        @if (!empty($fullText))
                                                            <div class="preview-text"
                                                                style="max-width:520px; white-space:normal; overflow:hidden;">
                                                                {{ \Illuminate\Support\Str::limit($fullText, 160) }}
                                                            </div>

                                                            @if (mb_strlen($fullText) > 160)
                                                                <button type="button" class="btn btn-link p-0 see-more"
                                                                    data-id="{{ $l->id_layanan }}-1"
                                                                    data-judul="{{ $l->judul }}">
                                                                    Lihat selengkapnya
                                                                </button>
                                                            @endif

                                                            <div id="full-content-{{ $l->id_layanan }}-1" class="d-none">
                                                                {!! $l->isi_layanan2 !!}
                                                            </div>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                {{-- Gambar 3 --}}
                                                    <td class="text-center">
                                                        @if (!empty($l->gambar3))
                                                            <div
                                                                style="width: 50px; height: 50px; margin: auto; overflow: hidden; border-radius: 8px; border: 1px solid #ddd;">
                                                                <img src="{{ asset('storage/layanan/' . $l->gambar3) }}"
                                                                    alt="gambar berita"
                                                                    style="width: 100%; height: 100%; object-fit: cover;">
                                                            </div>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>

                                                    {{-- Isi Berita 1 --}}
                                                    @php
                                                        $fullText = trim(
                                                            preg_replace(
                                                                '/\s+/',
                                                                ' ',
                                                                html_entity_decode(strip_tags($l->isi_layanan3 ?? '')),
                                                            ),
                                                        );
                                                    @endphp
                                                    <td class="isi-konten">
                                                        @if (!empty($fullText))
                                                            <div class="preview-text"
                                                                style="max-width:520px; white-space:normal; overflow:hidden;">
                                                                {{ \Illuminate\Support\Str::limit($fullText, 160) }}
                                                            </div>

                                                            @if (mb_strlen($fullText) > 160)
                                                                <button type="button" class="btn btn-link p-0 see-more"
                                                                    data-id="{{ $l->id_layanan }}-1"
                                                                    data-judul="{{ $l->judul }}">
                                                                    Lihat selengkapnya
                                                                </button>
                                                            @endif

                                                            <div id="full-content-{{ $l->id_layanan }}-1" class="d-none">
                                                                {!! $l->isi_layanan3 !!}
                                                            </div>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>

                                                <td class="text-center">
                                                    <a href="{{ route('admin.layanan.edit', $l->id_layanan) }}"
                                                        class="btn btn-gradient-warning btn-sm">
                                                        <i class="mdi mdi-pencil"></i> Ubah
                                                    </a>
                                                    <a href="#" class="btn btn-gradient-danger btn-sm"
                                                        onclick="deleteData('{{ $l->id_layanan }}')">
                                                        <i class="mdi mdi-delete"></i> Hapus
                                                    </a>

                                                    <form id="delete-form-{{ $l->id_layanan }}"
                                                        action="{{ route('admin.layanan.destroy', $l->id_layanan) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
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
                                    {{ $layanan->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer">
                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2023 <a
                            href="https://www.bootstrapdash.com/" target="_blank">BootstrapDash</a>. All rights
                        reserved.</span>
                    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i
                            class="mdi mdi-heart text-danger"></i></span>
                </div>
            </footer>
        </div>

    </div>
@endsection
