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
                                    <label for="alamat" class="mb-2">Alamat</label>
                                    <div class="mb-4">
                                        <textarea class="form-control my-editor" id="alamat" name="alamat" rows="10"
                                            placeholder="Masukkan Alamat">{{ old('alamat', $kontak->alamat) }}</textarea>
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
