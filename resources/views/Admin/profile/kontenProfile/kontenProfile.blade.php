@extends('admin.layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-xl-12 col-lg-11">
                    <div class="card shadow-sm rounded-4">
                        <div class="card-body px-4 py-4">

                            {{-- Header dan Tombol Tambah --}}
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="card-title mb-0">Konten Profil</h4>
                            </div>

                            <div class="d-flex justify-content-end align-items-center mb-3">
                                <a href="{{ route('admin.profile.create') }}"
                                    class="btn btn-primary rounded-3 px-4 py-2 d-flex align-items-center gap-2"
                                    style="font-weight:500;">
                                    <i class="bi bi-plus"></i> Tambah Konten
                                </a>
                            </div>

                            {{-- Pencarian --}}
                            <div class="d-flex justify-content-end mb-4">
                                <form action="{{ route('admin.profile.index') }}" method="GET" style="width: 270px;">
                                    <div class="input-group input-group-sm">
                                        <input type="text" id="searchInput" class="form-control"
                                            placeholder="Cari Judul Konten..." name="search"
                                            value="{{ request('search') }}">
                                        <button class="btn btn-info" type="submit">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>

                            {{-- Tabel --}}
                            <div class="table-responsive custom-table-container" style="overflow-x:auto; white-space:nowrap;">
                                <table class="table table-hover align-middle datatable">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th class="text-center">Icon</th>
                                            <th class="text-center">Judul</th>
                                            <th class="text-center">Gambar 1</th>
                                            <th class="text-center">Isi Konten 1</th>
                                            <th class="text-center">Gambar 2</th>
                                            <th class="text-center">Isi Konten 2</th>
                                            <th class="text-center">Gambar 3</th>
                                            <th class="text-center">Isi Konten 3</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($kontenProfile as $k)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>

                                                {{-- Icon --}}
                                                <td class="text-center">
                                                    @if (!empty($k->kategoriKonten->icon_konten))
                                                        <img src="{{ asset('storage/icon/' . $k->kategoriKonten->icon_konten) }}"
                                                            alt="icon" width="50" height="50"
                                                            style="object-fit:cover; border-radius:8px; border:1px solid #ddd;">
                                                    @else
                                                        -
                                                    @endif
                                                </td>

                                                <td class="kolom-judul">
                                                    @php
                                                            $fullText = trim(
                                                                preg_replace(
                                                                    '/\s+/',
                                                                    ' ',
                                                                    html_entity_decode(
                                                                        strip_tags($k->kategoriKonten->judul_konten ?? ''),
                                                                    ),
                                                                ),
                                                            );
                                                        @endphp
                                                        @if ($fullText)
                                                            <div class="preview-text"
                                                                style="max-width:420px; white-space:normal; overflow:hidden;">
                                                                {{ \Illuminate\Support\Str::limit($fullText, 20) }}
                                                            </div>
                                                            @if (mb_strlen($fullText) > 20)
                                                                <button type="button" class="btn btn-link p-0 see-more"
                                                                    data-id="{{ $k->id_konten }}-4"
                                                                    data-judul="Detail Judul">
                                                                    Lihat selengkapnya
                                                                </button>
                                                            @endif
                                                            <div id="full-content-{{ $k->id_konten }}-4" class="d-none">
                                                                {!! $k->kategoriKonten->judul_konten !!}
                                                            </div>
                                                        @else
                                                            -
                                                        @endif
                                                </td>

                                                {{-- ===== Gambar 1 ===== --}}
                                                <td class="text-center">
                                                    @if ($k->gambar1)
                                                        <img src="{{ asset('storage/konten/' . $k->gambar1) }}"
                                                            alt="gambar1" width="100"
                                                            style="border-radius:6px; border:1px solid #ddd;">
                                                    @else
                                                        -
                                                    @endif
                                                </td>

                                                {{-- ===== Isi konten 1 ===== --}}
                                                <td class="isi-konten">
                                                    @php
                                                        $isi1 = trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags($k->isi_konten1 ?? ''))));
                                                    @endphp
                                                    @if ($isi1)
                                                        <div style="max-width:420px; white-space:normal; overflow:hidden;">
                                                            {{ \Illuminate\Support\Str::limit($isi1, 90) }}
                                                        </div>
                                                        @if (mb_strlen($isi1) > 90)
                                                            <button type="button" class="btn btn-link p-0 see-more"
                                                                data-id="{{ $k->id_konten }}-1"
                                                                data-judul="{{ $k->judul }}">
                                                                Lihat selengkapnya
                                                            </button>
                                                        @endif
                                                        <div id="full-content-{{ $k->id_konten }}-1" class="d-none">
                                                            {!! $k->isi_konten1 !!}
                                                        </div>
                                                    @else
                                                        -
                                                    @endif
                                                </td>

                                                {{-- ===== Gambar 2 ===== --}}
                                                <td class="text-center">
                                                    @if ($k->gambar2)
                                                        <img src="{{ asset('storage/konten/' . $k->gambar2) }}"
                                                            alt="gambar2" width="100"
                                                            style="border-radius:6px; border:1px solid #ddd;">
                                                    @else
                                                        -
                                                    @endif
                                                </td>

                                                {{-- ===== Isi konten 2 ===== --}}
                                                <td class="isi-konten">
                                                    @php
                                                        $isi2 = trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags($k->isi_konten2 ?? ''))));
                                                    @endphp
                                                    @if ($isi2)
                                                        <div style="max-width:420px; white-space:normal; overflow:hidden;">
                                                            {{ \Illuminate\Support\Str::limit($isi2, 90) }}
                                                        </div>
                                                        @if (mb_strlen($isi2) > 90)
                                                            <button type="button" class="btn btn-link p-0 see-more"
                                                                data-id="{{ $k->id_konten }}-2"
                                                                data-judul="{{ $k->judul }}">
                                                                Lihat selengkapnya
                                                            </button>
                                                        @endif
                                                        <div id="full-content-{{ $k->id_konten }}-2" class="d-none">
                                                            {!! $k->isi_konten2 !!}
                                                        </div>
                                                    @else
                                                        -
                                                    @endif
                                                </td>

                                                {{-- ===== Gambar 3 ===== --}}
                                                <td class="text-center">
                                                    @if ($k->gambar3)
                                                        <img src="{{ asset('storage/konten/' . $k->gambar3) }}"
                                                            alt="gambar3" width="100"
                                                            style="border-radius:6px; border:1px solid #ddd;">
                                                    @else
                                                        -
                                                    @endif
                                                </td>

                                                {{-- ===== Isi konten 3 ===== --}}
                                                <td class="isi-konten">
                                                    @php
                                                        $isi3 = trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags($k->isi_konten3 ?? ''))));
                                                    @endphp
                                                    @if ($isi3)
                                                        <div style="max-width:420px; white-space:normal; overflow:hidden;">
                                                            {{ \Illuminate\Support\Str::limit($isi3, 90) }}
                                                        </div>
                                                        @if (mb_strlen($isi3) > 90)
                                                            <button type="button" class="btn btn-link p-0 see-more"
                                                                data-id="{{ $k->id_konten }}-3"
                                                                data-judul="{{ $k->judul }}">
                                                                Lihat selengkapnya
                                                            </button>
                                                        @endif
                                                        <div id="full-content-{{ $k->id_konten }}-3" class="d-none">
                                                            {!! $k->isi_konten3 !!}
                                                        </div>
                                                    @else
                                                        -
                                                    @endif
                                                </td>

                                                {{-- Tombol Aksi --}}
                                                <td class="text-center">
                                                        <a href="{{ route('admin.profile.edit', $k->id_konten) }}"
                                                            class="btn btn-info btn-sm btn-circle rounded-circle d-inline-flex me-1">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-danger btn-sm btn-circle rounded-circle d-inline-flex"
                                                            onclick="deleteData('{{ $k->id_konten }}')">
                                                            <i class="bi bi-trash"></i>
                                                        </a>
                                                        <form id="delete-form-{{ $k->id_konten }}"
                                                            action="{{ route('admin.profile.destroy', $k->id_konten) }}"
                                                            method="POST" style="display:none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center">Data tidak ditemukan.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{-- Pagination --}}
                            <div class="mt-4 d-flex justify-content-end">
                                    {{ $kontenProfile->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
