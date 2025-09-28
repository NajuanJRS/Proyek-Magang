<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

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
                                    <h4 class="card-title mb-0">File Download</h4>
                                    <a href="{{ route('admin.pageHeader.create') }}" class="btn btn-gradient-info btn-fw">
                                        <i class="mdi mdi-plus"></i> Tambah Gambar Header
                                    </a>
                                </div>

                                <div class="d-flex justify-content-end mb-4">
                                    <form action="{{ route('admin.pageHeader.index') }}" method="GET" style="width: 270px;">
                                        <div class="input-group input-group-sm">
                                            <input type="text" id="searchInput" class="form-control" placeholder="Cari file atau kategori..."
                                                   name="search" value="{{ request('search') }}">
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
                                            <th>No.</th>
                                            <th>Gambar</th>
                                            <th>Menu</th>
                                            <th>Judul</th>
                                            <th>Deskripsi</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($pageHeader as $p)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                <img src="{{ asset('storage/gambarHeader/'.$p->gambar_header) }}" width="150">
                                                </td>
                                                <td>
                                                    <label class="font-weight-bold">{{ $p->menuHeader->nama_menu }}</label>
                                                </td>
                                                <td class="font-weight-bold">{{ $p->judul }}</td>
                                                </td>
                                                @php
                                                    // Ambil teks polos: hapus tag, decode HTML entity (&nbsp; → spasi), rapikan spasi beruntun
                                                    $fullText = trim(
                                                        preg_replace(
                                                            '/\s+/',
                                                            ' ',
                                                            html_entity_decode(strip_tags($p->deskripsi)),
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
                                                            data-id="{{ $p->id_page }}"
                                                            data-judul="{{ $p->judul }}">
                                                            Lihat selengkapnya
                                                        </button>
                                                    @endif

                                                    <div id="full-content-{{ $p->id_page }}" class="d-none">
                                                        {!! $p->deskripsi !!}
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.pageHeader.edit', $p->id_page) }}"
                                                        class="btn btn-gradient-warning btn-sm"><i
                                                            class="mdi mdi-pencil"></i></a>
                                                    <a href="#" class="btn btn-gradient-danger btn-sm"
                                                        onclick="deleteData('{{ $p->id_page }}')"><i
                                                            class="mdi mdi-delete"></i></a>
                                                    <form id="delete-form-{{ $p->id_page }}"
                                                        action="{{ route('admin.pageHeader.destroy', $p->id_page) }}"
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
                                </div>
                                <div class="mt-4">
                                    {{ $pageHeader->links() }}
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
    <script src="{{ asset('js/custom.js') }}"></script>
</body>

</html>
