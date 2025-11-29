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
                                    <h4 class="card-title mb-0">Header Kontak</h4>
                                </div>

                                <div class="d-flex justify-content-end mb-4">

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
                                            @foreach($headerKontak as $h)
                                                @if (($h->kategoriHeader->nama_kategori ?? '') === 'Heading Kontak')
                                                    <tr>
                                                        <td class="text-center">{{ $no++ }}</td>
                                                        <td class="text-center">
                                                            <img src="{{ asset('media/' . $h->gambar) }}"
                                                                width="100">
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $h->kategoriHeader->nama_kategori ?? '-' }}</td>
                                                        <td class ="text-center">
                                                            {{ $h->headline ?? '-' }}</td>

                                                        @php
                                                            $fullText = trim(
                                                                preg_replace(
                                                                    '/\s+/',
                                                                    ' ',
                                                                    html_entity_decode(strip_tags($h->sub_heading)),
                                                                ),
                                                            );
                                                        @endphp

                                                        <td class="isi-konten">
                                                            <div class="preview-text"
                                                                style="max-width:520px; white-space:normal; overflow:hidden;">
                                                                {{ \Illuminate\Support\Str::limit($fullText, 160) }}
                                                            </div>

                                                            @if (mb_strlen($fullText) > 160)
                                                                <button type="button" class="btn btn-link p-0 see-more"
                                                                    data-id="{{ $h->id_header }}" data-judul="Sub Heading">
                                                                    Lihat selengkapnya
                                                                </button>
                                                            @endif

                                                            <div id="full-content-{{ $h->id_header }}" class="d-none">
                                                                {{ $h->sub_heading ?? '-' }}
                                                            </div>
                                                        </td>

                                                        <td class="text-center">
                                                            <a href="{{ route('admin.headerKontak.edit', $h->id_header) }}"
                                                                class="btn btn-info btn-sm btn-circle rounded-circle d-inline-flex me-1">
                                                                <i class="bi bi-pencil-square"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
