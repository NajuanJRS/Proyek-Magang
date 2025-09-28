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
                                    <h4 class="card-title mb-0">Data Pejabat</h4>
                                    <a href="{{ route('admin.pejabat.create') }}" class="btn btn-gradient-info btn-fw">
                                        <i class="mdi mdi-plus"></i> Tambah Pejabat
                                    </a>
                                </div>

                                <div class="d-flex justify-content-end mb-4">
                                    <form action="{{ route('admin.pejabat.index') }}" method="GET" style="width: 270px;">
                                        <div class="input-group input-group-sm">
                                            <input type="text" id="searchInput" class="form-control" placeholder="Cari nama pejabat..."
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
                                            <th>Nama</th>
                                            <th>Nip</th>
                                            <th>Jabatan</th>
                                            <th>Gambar</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            @forelse($pejabat as $p)
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $p->nama_pejabat }}</td>
                                                <td>{{ $p->nip }}</td>
                                                <td>{{ $p->jabatan->nama_jabatan }}</td>
                                                <td>
                                                    <img src="{{ asset('storage/pejabat/' . $p->gambar) }}"
                                                        class="rounded-circle" alt="foto pejabat">
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.pejabat.edit', $p->nip) }}" class="btn btn-gradient-warning btn-sm">
                                                        <i class="mdi mdi-pencil"></i> Ubah
                                                    </a>
                                                    <a href="#" class="btn btn-gradient-danger btn-sm"
                                                        onclick="deleteData('{{ $p->nip }}')">
                                                        <i class="mdi mdi-delete"></i> Hapus
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
                                            <td colspan="4" class="text-center">Data tidak ditemukan.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="mt-4">
                                    {{ $pejabat->links() }}
                                </div>
                                </tbody>
                                </table>
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
