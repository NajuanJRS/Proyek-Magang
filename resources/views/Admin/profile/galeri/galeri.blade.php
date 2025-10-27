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
                                    <h4 class="card-title mb-0">Galeri</h4>
                                </div>
                                <div class="d-flex justify-content-end align-items-center mb-3">
                                    <a href="{{ route('admin.galeri.create') }}"
                                        class="btn btn-primary rounded-3 px-4 py-2 d-flex align-items-center gap-2"
                                        style="font-weight:500;">
                                        <i class="bi bi-plus"></i> Tambah Galeri
                                    </a>
                                </div>

                                <div class="d-flex justify-content-end mb-4">
                                    <form action="{{ route('admin.galeri.index') }}" method="GET" style="width: 270px;">
                                        <div class="input-group input-group-sm">
                                            <input type="text" id="searchInput" class="form-control"
                                                placeholder="Cari Judul Galeri..." name="search" value="{{ request('search') }}">
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
                                                <th class="text-center">Judul</th>
                                                <th class="text-center">Gambar</th>
                                                <th class="text-center">Tanggal Upload</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $no = 1; @endphp
                                            @forelse($galeri as $g)
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td class="text-center">{{ $g->judul ?? '-' }}</td>
                                                        <td class="text-center">
                                                            <img src="{{ asset('storage/' . $g->gambar) }}"
                                                                width="150" alt="Gambar galeri">
                                                        </td>

                                                        <td class="text-center">
                                                            {{ $g->tanggal_upload ? \Carbon\Carbon::parse($g->tanggal_upload)->format('d M Y') : '-' }}
                                                        </td>


                                                        <td class="text-center">
                                                            <a href="{{ route('admin.galeri.edit', $g->id_galeri) }}"
                                                                class="btn btn-info btn-sm btn-circle rounded-circle d-inline-flex me-1">
                                                                <i class="bi bi-pencil-square"></i>
                                                            </a>
                                                            <a href="#" class="btn btn-danger btn-sm btn-circle rounded-circle d-inline-flex"
                                                                onclick="deleteData('{{ $g->id_galeri }}')">
                                                                <i class="bi bi-trash"></i>
                                                            </a>

                                                            <form id="delete-form-{{ $g->id_galeri }}"
                                                                action="{{ route('admin.galeri.destroy', $g->id_galeri) }}"
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
                                    {{ $galeri->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
