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
                                        File Download
                                    </h4>
                                </div>

                                <div class="d-flex justify-content-end mb-4">
                                    <form action="{{ route('admin.fileDownload.index') }}"
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
                                    <table class="table table-hover datatable">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No.</th>
                                                <th class="text-center">Konten</th>
                                                <th class="text-center">Nama File</th>
                                                <th class="text-center">File</th>
                                            </tr>
                                        </thead>
                                        @php $no = 1; @endphp
                                        <tbody>
                                            @foreach ($fileDownload as $f)
                                            <tr>
                                                <td class="text-center">{{ $no++ }}</td>
                                                <td class="text-center">{{ $f->kategoriDownload->halaman_induk }}</td>
                                                <td class="text-start">
                                                        @php
                                                            $fullText = trim(
                                                                preg_replace(
                                                                    '/\s+/',
                                                                    ' ',
                                                                    html_entity_decode(
                                                                        strip_tags($f->nama_file ?? ''),
                                                                    ),
                                                                ),
                                                            );
                                                        @endphp
                                                        @if ($fullText)
                                                            <div class="preview-text"
                                                                style="max-width:420px; white-space:normal; overflow:hidden;">
                                                                {{ \Illuminate\Support\Str::limit($fullText, 60) }}
                                                            </div>
                                                            @if (mb_strlen($fullText) > 60)
                                                                <button type="button" class="btn btn-link p-0 see-more"
                                                                    data-id="{{ $f->id_file }}-3"
                                                                    data-judul="Nama File">
                                                                    Lihat selengkapnya
                                                                </button>
                                                            @endif
                                                            <div id="full-content-{{ $f->id_file }}-3" class="d-none">
                                                                {!! $f->nama_file !!}
                                                            </div>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>

                                                    <td class="text-start">
                                                        @php
                                                            $fileText = trim(
                                                                preg_replace(
                                                                    '/\s+/',
                                                                    ' ',
                                                                    strip_tags($f->file ?? '')
                                                                )
                                                            );
                                                        @endphp

                                                        @if ($fileText)
                                                            <div class="preview-text" style="max-width:420px; white-space:normal; overflow:hidden;">
                                                                <a href="{{ asset('media/upload/file/' . $f->file) }}" target="_blank"
                                                                    style="text-decoration: none; color: #0d6efd; font-weight: 500;">
                                                                    {{ \Illuminate\Support\Str::limit($fileText, 60) }}
                                                                </a>
                                                            </div>

                                                            @if (mb_strlen($fileText) > 60)
                                                                <button type="button" class="btn btn-link p-0 see-more" data-id="{{ $f->id_file }}-4" data-judul="File">
                                                                    Lihat selengkapnya
                                                                </button>
                                                            @endif

                                                            <div id="full-content-{{ $f->id_file }}-4" class="d-none">
                                                                <a href="{{ asset('media/upload/file/' . $f->file) }}" target="_blank"
                                                                    style="text-decoration: none; color: #0d6efd; font-weight: 500;">
                                                                    {{ $f->file }}
                                                                </a>
                                                            </div>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mt-4 d-flex justify-content-end">
                                    {{ $fileDownload->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
