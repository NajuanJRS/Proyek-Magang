@extends('admin.layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-xl-10 col-lg-11">
                        <div class="card shadow-sm rounded-4">
                            <div class="card-body px-5 py-4">

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <h4 class="mb-5">Edit Kontak & Alamat</h4>

                                <form class="forms-sample" method="POST"
                                    action="{{ route('admin.kontak.update', $kontak->id_kontak) }}">
                                    @csrf
                                    @method('PUT')

                                    {{-- Nomor Telepon --}}
                                    <label for="nomor_telepon" class="mb-2">Nomor Telepon</label>
                                    <div class="mb-4">
                                        <input type="text" class="form-control" id="nomor_telepon" name="nomor_telepon"
                                            value="{{ old('nomor_telepon', $kontak->nomor_telepon) }}"
                                            placeholder="Contoh: 081234567890">
                                    </div>

                                    {{-- Email --}}
                                    <label for="email" class="mb-2">Email</label>
                                    <div class="mb-4">
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ old('email', $kontak->email) }}"
                                            placeholder="Contoh: info@kalselprov.go.id">
                                    </div>

                                    <label for="jam_pelayanan" class="mb-2">Jam Pelayanan</label>
                                    <div class="mb-4">
                                        <input type="text" class="form-control" id="jam_pelayanan" name="jam_pelayanan"
                                            value="{{ old('jam_pelayanan', $kontak->jam_pelayanan) }}"
                                            placeholder="Contoh: Senin - Jumat, 08.00 - 16.00 WITA">
                                    </div>

                                    {{-- Map --}}
                                    <label for="map" class="mb-2">Map (Embed Link)</label>
                                    <div class="mb-4">
                                        <input type="text" class="form-control" id="map" name="map"
                                            placeholder="Tempelkan URL SRC dari Google Maps Embed"
                                            value="{{ old('map', $kontak->map) }}">
                                        <small class="form-text text-muted">
                                            <b>Cara mendapatkan URL:</b> Buka Google Maps > Cari Lokasi > Bagikan (Share) >
                                            Pilih Sematkan Peta (Embed a map) > Salin HTML.
                                        </small>
                                    </div>

                                    {{-- Alamat --}}
                                    <div class="mb-4">
                                    <label class="form-label">Alamat</label>
                                    <div class="custom-editor-container">
                                        <div class="editor-toolbar">
                                            <button type="button" data-target="editor1" data-command="bold"><i class="bi bi-type-bold"></i></button>
                                            <button type="button" data-target="editor1" data-command="italic"><i class="bi bi-type-italic"></i></button>
                                            <button type="button" data-target="editor1" data-command="underline"><i class="bi bi-type-underline"></i></button>
                                            <button type="button" data-target="editor1" data-command="insertUnorderedList"><i class="bi bi-list-ul"></i></button>
                                            <button type="button" data-target="editor1" data-command="insertOrderedList"><i class="bi bi-list-ol"></i></button>
                                            <button type="button" data-target="editor1" data-command="createLink"><i class="bi bi-link-45deg"></i></button>
                                            <button type="button" data-target="editor1" data-command="insertImage"><i class="bi bi-image"></i></button>
                                            <button type="button" data-target="editor1" data-command="removeFormat"><i class="bi bi-eraser"></i></button>
                                        </div>
                                        <div id="editor1" class="custom-editor" contenteditable="true">{!! old('alamat', $kontak->alamat) !!}</div>
                                        <textarea name="alamat" id="hiddenContent1" style="display:none;"></textarea>
                                    </div>
                                </div>

                                    {{-- Tombol --}}
                                    <button type="submit" class="btn btn-info me-2">Simpan</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
