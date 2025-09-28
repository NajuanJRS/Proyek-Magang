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
                                        <h4 class="card-title mb-0">Manajemen Profile</h4>
                                        <a href="{{ route('admin.profile.create') }}" class="btn btn-gradient-primary btn-fw">
                                            <i class="mdi mdi-plus"></i> Tambah Profile
                                        </a>
                                    </div>

                                    <div class="d-flex justify-content-end mb-4">
                                        <form action="{{ route('admin.profile.index') }}" method="GET" style="width: 270px;">
                                            <div class="input-group input-group-sm">
                                                <input type="text" id="searchInput" class="form-control" placeholder="Cari judul halaman..." name="search">
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
                                                <th>No.</th>
                                                <th>Icon</th>
                                                <th>Judul</th>
                                                <th>Isi Konten</th> <th class="text-center">Gambar</th>
                                                <th>Tgl Posting</th>
                                                <th class="text-center">Dibaca</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($profile as $p)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                {{-- Icon --}}
                                                    <td class="text-center">
                                                        @if (!empty($p->icon))
                                                            <div
                                                                style="width: 50px; height: 50px; margin: auto; overflow: hidden; border-radius: 8px; border: 1px solid #ddd;">
                                                                <img src="{{ asset('storage/icon/' . $p->icon) }}"
                                                                    alt="gambar icon"
                                                                    style="width: 100%; height: 100%; object-fit: cover;">
                                                            </div>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                <td class="font-weight-bold">{{ $p->judul }}</td>
                                                @php
                                                    // Ambil teks polos: hapus tag, decode HTML entity (&nbsp; → spasi), rapikan spasi beruntun
                                                    $fullText = trim(
                                                        preg_replace(
                                                            '/\s+/',
                                                            ' ',
                                                            html_entity_decode(strip_tags($p->isi_konten)),
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
                                                            data-id="{{ $p->id_profile }}"
                                                            data-judul="{{ $p->judul }}">
                                                            Lihat selengkapnya
                                                        </button>
                                                    @endif

                                                    <div id="full-content-{{ $p->id_profile }}" class="d-none">
                                                        {!! $p->isi_konten !!}
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <img src="{{ asset('storage/profile/' . $p->gambar) }}" class="img-thumbnail" alt="gambar halaman">
                                                </td>
                                                <td>{{ $p->tgl_posting }}</td>
                                                <td class="text-center">{{ $p->dibaca }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.profile.edit', $p->id_profile) }}" class="btn btn-gradient-warning btn-sm" title="Ubah"><i class="mdi mdi-pencil"></i></a>
                                                    <a href="#" class="btn btn-gradient-danger btn-sm" onclick="deleteData('{{ $p->id_profile }}')" title="Hapus"><i class="mdi mdi-delete"></i></a>
                                                    <form id="delete-form-{{ $p->id_profile }}"
                                                    action="{{ route('admin.profile.destroy', $p->id_profile) }}"
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
                                        {{ $profile->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2023 <a href="https://www.bootstrapdash.com/" target="_blank">BootstrapDash</a>. All rights reserved.</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="mdi mdi-heart text-danger"></i></span>
                    </div>
                </footer>
            </div>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    </body>
</html>
