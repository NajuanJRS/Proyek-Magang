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
                                            @forelse ($fileDownload as $f)
                                            <tr>
                                                <td class="text-center">{{ $no++ }}</td>
                                                <td class="konten-download">{{ $f->kategoriDownload->halaman_induk }}</td>
                                                <td class="konten-download">{{ $f->nama_file }}</td>

                                                    @php
                                                        $fullText = trim(
                                                            preg_replace(
                                                                '/\s+/',
                                                                ' ',
                                                                html_entity_decode(strip_tags($f->file)),
                                                            ),
                                                        );
                                                    @endphp

                                                    <td class="konten-download">
                                                        <a href="{{ asset('storage/upload/file/' . $f->file) }}"
                                                            target="_blank"
                                                            style="text-decoration: none; color: #0d6efd; font-weight: 500;">
                                                            {{ $f->file }}
                                                        </a>
                                                    </td>
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
