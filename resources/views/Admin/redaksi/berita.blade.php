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
                                    <h4 class="card-title mb-0">Manajemen Berita</h4>
                                    <a href="{{ route('admin.berita.create') }}"
                                        class="btn btn-gradient-primary btn-fw">
                                        <i class="mdi mdi-plus"></i> Tambah Berita
                                    </a>
                                </div>

                                <div class="d-flex justify-content-end mb-4">
                                    <form action="{{ route('admin.berita.index') }}" method="GET"
                                        style="width: 270px;">
                                        <div class="input-group input-group-sm">
                                            <input type="text" id="searchInput" class="form-control"
                                                placeholder="Cari Berita" value="{{ request('search') }}"
                                                name="search">
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
                                                <th>Judul</th>
                                                <th class="text-center">Gambar 1</th>
                                                <th>Isi Berita 1</th>
                                                <th class="text-center">Gambar 2</th>
                                                <th>Isi Berita 2</th>
                                                <th class="text-center">Gambar 3</th>
                                                <th>Isi Berita 3</th>
                                                <th>Tanggal Posting</th>
                                                <th class="text-center">Dibaca</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($berita as $b)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td class="font-weight-bold">{{ $b->judul }}</td>
                                                    {{-- Gambar 1 --}}
                                                    <td class="text-center">
                                                        @if (!empty($b->gambar1))
                                                            <div
                                                                style="width: 50px; height: 50px; margin: auto; overflow: hidden; border-radius: 8px; border: 1px solid #ddd;">
                                                                <img src="{{ asset('storage/berita/' . $b->gambar1) }}"
                                                                    alt="gambar berita"
                                                                    style="width: 100%; height: 100%; object-fit: cover;">
                                                            </div>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>

                                                    {{-- Isi Berita 1 --}}
                                                    @php
                                                        $fullText = trim(
                                                            preg_replace(
                                                                '/\s+/',
                                                                ' ',
                                                                html_entity_decode(strip_tags($b->isi_berita1 ?? '')),
                                                            ),
                                                        );
                                                    @endphp
                                                    <td class="isi-konten">
                                                        @if (!empty($fullText))
                                                            <div class="preview-text"
                                                                style="max-width:520px; white-space:normal; overflow:hidden;">
                                                                {{ \Illuminate\Support\Str::limit($fullText, 160) }}
                                                            </div>

                                                            @if (mb_strlen($fullText) > 160)
                                                                <button type="button" class="btn btn-link p-0 see-more"
                                                                    data-id="{{ $b->id_berita }}-1"
                                                                    data-judul="{{ $b->judul }}">
                                                                    Lihat selengkapnya
                                                                </button>
                                                            @endif

                                                            <div id="full-content-{{ $b->id_berita }}-1" class="d-none">
                                                                {!! $b->isi_berita1 !!}
                                                            </div>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>

                                                    <td class="text-center">
                                                        @if (!empty($b->gambar2))
                                                            <div
                                                                style="width: 50px; height: 50px; margin: auto; overflow: hidden; border-radius: 8px; border: 1px solid #ddd;">
                                                                <img src="{{ asset('storage/berita/' . $b->gambar2) }}"
                                                                    alt="gambar berita"
                                                                    style="width: 100%; height: 100%; object-fit: cover;">
                                                            </div>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>

                                                    {{-- Isi Berita 2 --}}
                                                    @php
                                                        $fullText = trim(
                                                            preg_replace(
                                                                '/\s+/',
                                                                ' ',
                                                                html_entity_decode(strip_tags($b->isi_berita2 ?? '')),
                                                            ),
                                                        );
                                                    @endphp
                                                    <td class="isi-konten">
                                                        @if (!empty($fullText))
                                                            <div class="preview-text"
                                                                style="max-width:520px; white-space:normal; overflow:hidden;">
                                                                {{ \Illuminate\Support\Str::limit($fullText, 160) }}
                                                            </div>

                                                            @if (mb_strlen($fullText) > 160)
                                                                <button type="button" class="btn btn-link p-0 see-more"
                                                                    data-id="{{ $b->id_berita }}-2"
                                                                    data-judul="{{ $b->judul }}">
                                                                    Lihat selengkapnya
                                                                </button>
                                                            @endif

                                                            <div id="full-content-{{ $b->id_berita }}-2"
                                                                class="d-none">
                                                                {!! $b->isi_berita2 !!}
                                                            </div>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>

                                                    <td class="text-center">
                                                        @if (!empty($b->gambar3))
                                                            <div
                                                                style="width: 50px; height: 50px; margin: auto; overflow: hidden; border-radius: 8px; border: 1px solid #ddd;">
                                                                <img src="{{ asset('storage/berita/' . $b->gambar3) }}"
                                                                    alt="gambar berita"
                                                                    style="width: 100%; height: 100%; object-fit: cover;">
                                                            </div>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>

                                                    {{-- Isi Berita 3 --}}
                                                    @php
                                                        $fullText = trim(
                                                            preg_replace(
                                                                '/\s+/',
                                                                ' ',
                                                                html_entity_decode(strip_tags($b->isi_berita3 ?? '')),
                                                            ),
                                                        );
                                                    @endphp
                                                    <td class="isi-konten">
                                                        @if (!empty($fullText))
                                                            <div class="preview-text"
                                                                style="max-width:520px; white-space:normal; overflow:hidden;">
                                                                {{ \Illuminate\Support\Str::limit($fullText, 160) }}
                                                            </div>

                                                            @if (mb_strlen($fullText) > 160)
                                                                <button type="button" class="btn btn-link p-0 see-more"
                                                                    data-id="{{ $b->id_berita }}-3"
                                                                    data-judul="{{ $b->judul }}">
                                                                    Lihat selengkapnya
                                                                </button>
                                                            @endif

                                                            <div id="full-content-{{ $b->id_berita }}-3"
                                                                class="d-none">
                                                                {!! $b->isi_berita3 !!}
                                                            </div>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>

                                                    <td>{{ $b->tgl_posting }}</td>
                                                    <td class="text-center">{{ $b->dibaca }}</td>
                                                    <td class="text-center">
                                                        <a href="#" class="btn btn-gradient-info btn-sm"
                                                            title="Lihat Komentar"><i
                                                                class="mdi mdi-comment-multiple-outline"></i></a>
                                                        <a href="{{ route('admin.berita.edit', $b->id_berita) }}"
                                                            class="btn btn-gradient-warning btn-sm" title="Ubah"><i
                                                                class="mdi mdi-pencil"></i></a>
                                                        <a href="#" class="btn btn-gradient-danger btn-sm"
                                                            onclick="deleteData('{{ $b->id_berita }}')"
                                                            title="Hapus"><i class="mdi mdi-delete"></i></a>
                                                        <form id="delete-form-{{ $b->id_berita }}"
                                                            action="{{ route('admin.berita.destroy', $b->id_berita) }}"
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
                                    {{ $berita->links() }}
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
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made
                            with <i class="mdi mdi-heart text-danger"></i></span>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{{ asset('js/custom.js') }}"></script>
</body>

</html>
