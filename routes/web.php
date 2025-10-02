<?php

use App\Http\Controllers\admin\AdminUpdateController;
use App\Http\Controllers\admin\BeritaController;
use App\Http\Controllers\pengguna\BeritaController as LandingBeritaController;
use App\Http\Controllers\admin\FaqController;
use App\Http\Controllers\pengguna\FaqController as LandingFaqController;
use App\Http\Controllers\admin\FileDownloadController;
use App\Http\Controllers\admin\HeaderLayananController;
use App\Http\Controllers\admin\HeaderProfileController;
use App\Http\Controllers\admin\KontakController;
use App\Http\Controllers\admin\KotakMasukController;
use App\Http\Controllers\admin\LayananKamiController;
use App\Http\Controllers\pengguna\LayananController;
use App\Http\Controllers\admin\ManajemenProfileController;
use App\Http\Controllers\admin\MitraController;
use App\Http\Controllers\admin\PageHeaderController;
use App\Http\Controllers\admin\pejabatController;
use App\Http\Controllers\admin\SliderController;
use App\Http\Controllers\pengguna\DownloadController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\pengguna\ProfilController;
use App\Http\Controllers\pengguna\SearchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pengguna\PpidController;
use App\Http\Controllers\pengguna\BerandaController;

Route::view('/layanan/penerbitan-surat-tanda-pendaftaran', 'layanan.penerbitan');
Route::view('/layanan/prosedur-pengangkatan-anak', 'layanan.pengangkatan');
Route::view('/layanan/penyaluran-logistik-bufferstock-bencana', 'layanan.bufferstock');

Route::get('/', [BerandaController::class, 'index'])->name('beranda');

// profil
Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
// layanan
Route::view('/layanan', 'pengguna.layanan.index')->name('layanan.index');
// berita
Route::view('/berita', 'pengguna.berita.index')->name('berita.index');
// download
Route::view('/download', 'pengguna.download.index')->name('download.index');
// PPID
Route::view('/ppid', 'pengguna.ppid.index')->name('ppid.index');
// kontak
Route::view('/kontak', 'pengguna.kontak.index')->name('kontak.index');


// pencarian
Route::get('/pencarian', [SearchController::class, 'index'])->name('pencarian.index');
// kontak/FAQ
Route::get('/faq/{kategori?}', [LandingFaqController::class, 'index'])->name('faq.index');
// konten berita
Route::get('/berita/{slug}', [LandingBeritaController::class, 'show'])->name('berita.show');
// konten layanan
Route::get('/layanan/{slug}', [LayananController::class, 'show'])->name('layanan.show');
// konten profil Sejarah Dinas Sosial
Route::get('/profil/{slug}', [ProfilController::class, 'show'])->name('profil.show');
// konten Download
Route::get('/download/{slug}', [DownloadController::class, 'show'])->name('download.show');
// Route baru untuk menangani proses download file
Route::get('/download/file/{filename}', [DownloadController::class, 'downloadFile'])->name('download.file');
// Route menampilkan halaman Profil PPID
Route::get('/ppid/{slug}', [PpidController::class, 'show'])->name('ppid.show');


Route::middleware('guest')->prefix('/')->group(function () {
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'store']);
});

Route::post('logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', function () {
        return view('Admin.adminDashboard');
    })->name('dashboard');

    Route::resource('slider', SliderController::class);

    Route::resource('mitra', MitraController::class);

    Route::resource('header-profile', HeaderProfileController::class)->names('headerProfile');

    Route::resource('header-layanan', HeaderLayananController::class)->names('headerLayanan');

    Route::resource('pejabat', pejabatController::class);

    Route::resource('layanan', LayananKamiController::class);

    Route::resource('download', FileDownloadController::class);

    Route::resource('berita', BeritaController::class);

    Route::resource('profile', ManajemenProfileController::class);

    Route::resource('kontak', KontakController::class);

    Route::resource('kotak-masuk', KotakMasukController::class)->names('kotakMasuk');

    Route::resource('admin-update', AdminUpdateController::class)->names('adminUpdate');

    Route::resource('faq', FaqController::class);

    Route::resource('page-header', PageHeaderController::class)->names('pageHeader');
});
