<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container-scroller">


        @include('Admin.sidebar.sidebar')
        <div class="main-panel">
            @include('Admin.navigasi.adminNavigasi')
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">

                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h4 class="card-title mb-0">File Download</h4>
                                    <a href="{{ route('admin.download.create') }}" class="btn btn-gradient-info btn-fw">
                                        <i class="mdi mdi-plus"></i> Tambah File
                                    </a>
                                </div>

                                <div class="d-flex justify-content-end mb-4">
                                    <form action="{{ route('admin.download.index') }}" method="GET" style="width: 270px;">
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
                                            <th>Icon</th>
                                            <th>Kategori</th>
                                            <th>Nama File</th>
                                            <th class="text-center">File</th>
                                            <th>Tgl File</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($download as $d)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                {{-- Icon --}}
                                                    <td class="text-center">
                                                        @if (!empty($d->icon))
                                                            <div
                                                                style="width: 50px; height: 50px; margin: auto; overflow: hidden; border-radius: 8px; border: 1px solid #ddd;">
                                                                <img src="{{ asset('storage/icon/' . $d->icon) }}"
                                                                    alt="gambar icon"
                                                                    style="width: 100%; height: 100%; object-fit: cover;">
                                                            </div>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                <td>
                                                    <label
                                                        class="font-weight-bold">{{ $d->kategori->nama_kategori }}</label>
                                                </td>
                                                <td class="font-weight-bold">{{ $d->nama_file }}</td>
                                                <td class="text-center">
                                                    <a href="{{ asset('storage/upload/file/' . $d->file) }}"
                                                        target="_blank">
                                                        {{ $d->file }}
                                                    </a>
                                                </td>
                                                <td>{{ $d->tgl_file }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.download.edit', $d->id_file) }}"
                                                        class="btn btn-gradient-warning btn-sm"><i
                                                            class="mdi mdi-pencil"></i></a>
                                                    <a href="#" class="btn btn-gradient-danger btn-sm"
                                                        onclick="deleteData('{{ $d->id_file }}')"><i
                                                            class="mdi mdi-delete"></i></a>
                                                    <form id="delete-form-{{ $d->id_file }}"
                                                        action="{{ route('admin.download.destroy', $d->id_file) }}"
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
                                    {{ $download->links() }}
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
