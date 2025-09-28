<!DOCTYPE html>
<html lang="en">

<body>
    <div class="container-scroller">

        @include('Admin.navigasi.adminNavigasi')
        @include('Admin.sidebar.sidebar')
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">

                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h4 class="card-title mb-0">Manajemen FAQ</h4>
                                    <a href="{{ route('admin.faq.create') }}" class="btn btn-gradient-primary btn-fw">
                                        <i class="mdi mdi-plus"></i> Tambah FAQ Baru
                                    </a>
                                </div>

                                <div class="d-flex justify-content-end mb-4">
                                    <form action="{{ route('admin.faq.index') }}" method="GET" style="width: 270px;">
                                        <div class="input-group input-group-sm">
                                            <input type="text" id="searchInput" class="form-control"
                                                placeholder="Cari pertanyaan..." name="search">
                                            <button class="btn btn-gradient-primary" type="submit">
                                                <i class="mdi mdi-magnify"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="table-responsive custom-table-container">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;">No.</th>
                                            <th style="width: 75%;">Pertanyaan</th>
                                            <th class="text-center" style="width: 20%;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($faq as $f)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="isi-konten">{{ $f->pertanyaan }}</td>
                                                <td class="text-center">
                                                    {{-- Tombol lihat selengkapnya --}}
                                                    <button type="button" title="Lihat Detail" class="btn btn-gradient-info btn-sm see-more"
                                                        data-id="{{ $f->id_faq }}" data-judul="{{ $f->pertanyaan }}">
                                                        <i class="mdi mdi-eye"></i>
                                                    </button>

                                                    {{-- Full content untuk SweetAlert --}}
                                                    <div id="full-content-{{ $f->id_faq }}" class="d-none">
                                                        {!! $f->jawaban !!}
                                                    </div>
                                                    <a href="{{ route('admin.faq.edit', $f->id_faq) }}"
                                                        class="btn btn-gradient-warning btn-sm" title="Ubah"><i
                                                            class="mdi mdi-pencil"></i></a>
                                                    <a href="#" class="btn btn-gradient-danger btn-sm"
                                                        onclick="deleteData('{{ $f->id_faq }}')" title="Hapus"><i
                                                            class="mdi mdi-delete"></i></a>

                                                    <form id="delete-form-{{ $f->id_faq }}"
                                                        action="{{ route('admin.faq.destroy', $f->id_faq) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                            </tr>
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
                                    {{ $faq->links() }}
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
</body>

</html>
