@extends('admin.layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row g-3">

        {{-- Welcome Card --}}
        <div class="col-12">
            <div class="card card-bergerak shadow-sm border-0 bg-gradient-primary text-white p-4 rounded-4">
                <h4 class="fw-bold mb-1">Selamat Datang, {{ Auth::user()->name }} 👋</h4>
                <p class="mb-0">Pusat Pengelolaan Konten dan Data Dinas Sosial Provinsi Kalimantan Selatan.</p>
            </div>
        </div>

        {{-- Statistik Cards --}}
        <div class="col-md-4 col-sm-6">
            <a href="{{ route('admin.mitra.index') }}" class="text-decoration-none">
            <div class="card card-bergerak shadow-sm border-0 p-3 text-center rounded-4">
                <div class="text-danger mb-2"><i class="bi bi-people-fill fs-1"></i></div>
                <h5 class="fw-bold mb-1">Mitra</h5>
                <p class="text-muted mb-0">{{ $totalMitra }} file</p>
            </div>
            </a>
        </div>

        <div class="col-md-4 col-sm-6">
            <a href="{{ route('admin.profile.index') }}" class="text-decoration-none">
            <div class="card card-bergerak shadow-sm border-0 p-3 text-center rounded-4">
                <div class="text-primary mb-2"><i class="bi bi-person-lines-fill fs-1"></i></div>
                <h5 class="fw-bold mb-1">Profil</h5>
                <p class="text-muted mb-0">{{ $totalProfil }} konten</p>
            </div>
            </a>
        </div>

        <div class="col-md-4 col-sm-6">
            <a href="{{ route('admin.pejabat.index') }}" class="text-decoration-none">
            <div class="card card-bergerak shadow-sm border-0 p-3 text-center rounded-4">
                <div class="text-info mb-2"><i class="bi bi-person-badge fs-1"></i></div>
                <h5 class="fw-bold mb-1">Pejabat</h5>
                <p class="text-muted mb-0">{{ $totalPejabat }} data</p>
            </div>
            </a>
        </div>

        <div class="col-md-4 col-sm-6">
            <a href="{{ route('admin.galeri.index') }}" class="text-decoration-none">
            <div class="card card-bergerak shadow-sm border-0 p-3 text-center rounded-4">
                <div class="text-purple mb-2"><i class="bi bi-image fs-1"></i></div>
                <h5 class="fw-bold mb-1">Galeri</h5>
                <p class="text-muted mb-0">{{ $totalGaleri }} gambar</p>
            </div>
            </a>
        </div>

        <div class="col-md-4 col-sm-6">
            <a href="{{ route('admin.layanan.index') }}" class="text-decoration-none">
            <div class="card card-bergerak shadow-sm border-0 p-3 text-center rounded-4">
                <div class="text-success mb-2"><i class="bi bi-briefcase fs-1"></i></div>
                <h5 class="fw-bold mb-1">Layanan</h5>
                <p class="text-muted mb-0">{{ $totalLayanan }} konten</p>
            </div>
            </a>
        </div>

        <div class="col-md-4 col-sm-6">
            <a href="{{ route('admin.berita.index') }}" class="text-decoration-none">
            <div class="card card-bergerak shadow-sm border-0 p-3 text-center rounded-4">
                <div class="text-warning mb-2"><i class="bi bi-newspaper fs-1"></i></div>
                <h5 class="fw-bold mb-1">Berita</h5>
                <p class="text-muted mb-0">{{ $totalBerita }} konten</p>
            </div>
            </a>
        </div>

        <div class="col-md-4 col-sm-6">
            <a href="{{ route('admin.fileDownload') }}" class="text-decoration-none">
            <div class="card card-bergerak shadow-sm border-0 p-3 text-center rounded-4">
                <div class="text-danger mb-2"><i class="bi bi-download fs-1"></i></div>
                <h5 class="fw-bold mb-1">File Download</h5>
                <p class="text-muted mb-0">{{ $totalFileDownload }} file</p>
            </div>
            </a>
        </div>

        <div class="col-md-4 col-sm-6">
            <a href="{{ route('admin.ppid.index') }}" class="text-decoration-none">
            <div class="card card-bergerak shadow-sm border-0 p-3 text-center rounded-4">
                <div class="text-secondary mb-2"><i class="bi bi-people fs-1"></i></div>
                <h5 class="fw-bold mb-1">PPID</h5>
                <p class="text-muted mb-0">{{ $totalPpid }} konten</p>
            </div>
            </a>
        </div>

        <div class="col-md-4 col-sm-6">
            <a href="{{ route('admin.faq.index') }}" class="text-decoration-none">
            <div class="card card-bergerak shadow-sm border-0 p-3 text-center rounded-4">
                <div class="text-teal mb-2"><i class="bi bi-question-circle fs-1"></i></div>
                <h5 class="fw-bold mb-1">FAQ</h5>
                <p class="text-muted mb-0">{{ $totalFaq }} pertanyaan</p>
            </div>
            </a>
        </div>

        {{-- Kotak Masuk --}}
        <div class="col-md-12 mt-3">
            <a href="{{ route('admin.kotakMasuk.index') }}" class="text-decoration-none">
            <div class="card card-bergerak shadow-sm border-0 p-4 rounded-4">
                <div class="d-flex align-items-center">
                    <i class="bi bi-inbox fs-2 text-danger me-3"></i>
                    <div>
                        <h5 class="fw-bold mb-1">Kotak Masuk</h5>
                        <p class="text-muted mb-0">{{ $totalPesan }} pesan belum dibaca</p>
                    </div>
                </div>
            </div>
            </a>
        </div>

    </div>
</div>
@endsection
