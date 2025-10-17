@extends('admin.layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="content-wrapper">

                {{-- ===================== TABEL KARTU PEJABAT ===================== --}}
                <div class="row mb-5">
                    <div class="col-xl-12 col-lg-11">
                        <div class="card shadow-sm rounded-4">
                            <div class="card-body px-4 py-4">

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="card-title mb-0">Kartu Pejabat</h4>
                                </div>

                                <div class="table-responsive custom-table-container">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No.</th>
                                                <th class="text-center">Gambar</th>
                                                <th class="text-center">Kategori Header</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $no = 1; @endphp
                                            @forelse($headerKartu as $h)
                                                @if (($h->kategoriHeader->nama_kategori ?? '') === 'Kartu Pejabat')
                                                    <tr>
                                                        <td class="text-center">{{ $no++ }}</td>
                                                        <td class="text-center">
                                                            <img src="{{ asset('storage/header/' . $h->gambar) }}" width="100">
                                                        </td>
                                                        <td class="text-center">{{ $h->kategoriHeader->nama_kategori ?? '-' }}</td>
                                                        

                                                        <td class="text-center">
                                                            <a href="{{ route('admin.headerKartu.edit', $h->id_header) }}"
                                                                class="btn btn-info btn-sm">
                                                                <i class="bi bi-pencil-square"></i> Ubah
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">Data tidak ditemukan.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                {{-- ===================== TABEL PEJABAT ===================== --}}
                <div class="row">
                    <div class="col-xl-12 col-lg-11">
                        <div class="card shadow-sm rounded-4">
                            <div class="card-body px-4 py-4">

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="card-title mb-0">Pejabat</h4>
                                </div>

                                <div class="d-flex justify-content-end align-items-center mb-3">
                                    <a href="{{ route('admin.pejabat.create') }}"
                                        class="btn btn-primary rounded-3 px-4 py-2 d-flex align-items-center gap-2"
                                        style="font-weight:500;">
                                        <i class="bi bi-plus"></i> Tambah Pejabat
                                    </a>
                                </div>

                                <div class="d-flex justify-content-end mb-4">
                                    <form action="{{ route('admin.slider.index') }}" method="GET" style="width: 270px;">
                                        <div class="input-group input-group-sm">
                                            <input type="text" id="searchInput" class="form-control"
                                                placeholder="Cari Pejabat..." name="search" value="{{ request('search') }}">
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
                                                <th class="text-center">Nama</th>
                                                <th class="text-center">Nip</th>
                                                <th class="text-center">Jabatan</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($pejabat as $p)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td class="text-center">
                                                        <img src="{{ asset('storage/pejabat/' . $p->gambar) }}" width="150" alt="foto pejabat">
                                                    </td>
                                                    <td class="text-center">{{ $p->nama_pejabat }}</td>
                                                    <td class="text-center">{{ $p->nip }}</td>
                                                    <td class="text-center">{{ $p->jabatan->nama_jabatan }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ route('admin.pejabat.edit', $p->nip) }}" class="btn btn-info btn-sm">
                                                            <i class="bi bi-pencil-square"></i> Ubah
                                                        </a>
                                                        <a href="#" class="btn btn-danger btn-sm"
                                                            onclick="deleteData('{{ $p->nip }}')">
                                                            <i class="bi bi-trash"></i> Hapus
                                                        </a>

                                                        <form id="delete-form-{{ $p->nip }}"
                                                            action="{{ route('admin.pejabat.destroy', $p->nip) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">Data tidak ditemukan.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>

                                    <div class="mt-4 d-flex justify-content-end">
                                    {{ $pejabat->links('pagination::bootstrap-5') }}
                                </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
