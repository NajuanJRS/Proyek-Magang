@extends('admin.layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-xl-12 col-lg-11">
                        <div class="card shadow-sm rounded-4">
                            <div class="card-body px-4 py-4">


                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h4 class="card-title mb-0">Kotak Masuk Pesan</h4>
                                </div>

                                <div class="d-flex justify-content-end mb-4">
                                    <form action="{{ route('admin.kotakMasuk.index') }}" method="GET"
                                        style="width: 270px;">
                                        <div class="input-group input-group-sm">
                                            <input type="text" id="searchInput" class="form-control"
                                                placeholder="Cari Pesan..." name="search">
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
                                                <th>No.</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>Telepon</th>
                                                <th>Isi Pesan</th>
                                                <th>Tanggal Kirim</th>
                                                <th>Status</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($kotakMasuk as $k)
                                                <tr class="{{ $k->dibaca == 0 ? 'unread-message' : 'read-message' }}">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $k->nama }}</td>
                                                    <td>{{ $k->email }}</td>
                                                    <td>{{ $k->telepon }}</td>
                                                    <td>{{ $k->isi_pesan }}</td>
                                                    <td>{{ $k->tgl_kirim }}</td>
                                                    <td class="status-col">
                                                        @if (!$k->status_dibaca)
                                                            <span class="badge bg-danger status-badge">Belum Dibaca</span>
                                                        @else
                                                            <span class="badge bg-success status-badge">Sudah Dibaca</span>
                                                        @endif
                                                    </td>
                                                    {{-- Status Kolom --}}
                                                    <td class="text-center">

                                                        {{-- Tombol lihat --}}
                                                        <button type="button" title="Lihat Detail"
                                                            class="btn btn-warning btn-sm btn-circle rounded-circle d-inline-flex me-1 see-more"
                                                            data-id="{{ $k->id_kotak }}" data-judul="{{ $k->nama }}"
                                                            data-dibaca="{{ $k->status_dibaca }}">
                                                            <i class="bi bi-eye"></i>
                                                        </button>

                                                        {{-- Full content untuk SweetAlert --}}
                                                        <div id="full-content-{{ $k->id_kotak }}" class="d-none">
                                                            {!! $k->isi_pesan !!}
                                                        </div>

                                                        {{-- Tombol hapus --}}
                                                        <a href="#"
                                                            class="btn btn-danger btn-sm btn-circle rounded-circle d-inline-flex me-1"
                                                            onclick="deleteData('{{ $k->id_kotak }}')" title="Hapus">
                                                            <i class="bi bi-trash"></i></a>
                                                        <form id="delete-form-{{ $k->id_kotak }}"
                                                            action="{{ route('admin.kotakMasuk.destroy', $k->id_kotak) }}"
                                                            method="POST" style="display:none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">Data tidak ditemukan.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-4 d-flex justify-content-end">
                                    {{ $kotakMasuk->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
