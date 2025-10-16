<?php

use App\Http\Controllers\admin\AdminUpdateController;
use App\Http\Controllers\admin\BeritaController;
use App\Http\Controllers\pengguna\BerandaController;
use App\Http\Controllers\pengguna\BeritaController as LandingBeritaController;
use App\Http\Controllers\admin\FaqController;
use App\Http\Controllers\pengguna\FaqController as LandingFaqController;
use App\Http\Controllers\admin\DownloadController as DownloadControllerAdmin;
use App\Http\Controllers\admin\FileDownloadController;
use App\Http\Controllers\admin\Header\HeaderBeritaController;
use App\Http\Controllers\admin\Header\HeaderDownloadController;
use App\Http\Controllers\admin\Header\HeaderKontakController;
use App\Http\Controllers\admin\Header\HeaderLayananController;
use App\Http\Controllers\admin\Header\HeaderPpidController;
use App\Http\Controllers\admin\Header\HeaderProfileController;
use App\Http\Controllers\admin\KontakController;
use App\Http\Controllers\admin\PpidController as AdminPpidController;
use App\Http\Controllers\admin\KontenProfileController;
use App\Http\Controllers\admin\KotakMasukController;
use App\Http\Controllers\admin\KontenLayananController;
use App\Http\Controllers\pengguna\LayananController;
use App\Http\Controllers\admin\ManajemenProfileController;
use App\Http\Controllers\admin\MitraController;
use App\Http\Controllers\admin\PageHeaderController;
use App\Http\Controllers\admin\PejabatController;
use App\Http\Controllers\admin\SliderController;
use App\Http\Controllers\pengguna\DownloadController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\pengguna\ProfilController;
use App\Http\Controllers\pengguna\SearchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pengguna\PpidController;
use App\Http\Controllers\pengguna\KontakController as VioletController;


Route::get('/', [BerandaController::class, 'index'])->name('beranda');

// profil
Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
// layanan
Route::get('/layanan', [LayananController::class, 'index'])->name('layanan.index');
// berita
Route::get('/berita', [LandingBeritaController::class, 'index'])->name('berita.index');
// download
Route::get('/download', [DownloadController::class, 'index'])->name('download.index');
// PPID
Route::get('/ppid', [PpidController::class, 'index'])->name('ppid.index');
// kontak
Route::get('/kontak', [VioletController::class, 'index'])->name('kontak.index');
// Simpan pesan dari form kontak
Route::post('/kontak', [App\Http\Controllers\pengguna\KontakController::class, 'store'])->name('kontak.store');
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

    Route::resource('header-berita', HeaderBeritaController::class)
    ->names('headerBerita')
    ->parameters(['header-berita' => 'header_berita']);

    Route::resource('header-download', HeaderDownloadController::class)->names('headerDownload');

    Route::resource('header-ppid', HeaderPpidController::class)->names('headerPpid');

    Route::resource('ppid', AdminPpidController::class);

    Route::resource('header-kontak', HeaderKontakController::class)->names('headerKontak');

    Route::resource('pejabat', PejabatController::class);

    Route::get('kartu-pejabat/{id}/edit', [PejabatController::class, 'editHeader'])
    ->name('headerKartu.edit');

    Route::put('kartu-pejabat/{id}', [PejabatController::class, 'updateHeader'])
    ->name('headerKartu.update');

    Route::resource('profile', KontenProfileController::class);

    Route::resource('layanan', KontenLayananController::class);

    Route::resource('kategori-download', DownloadControllerAdmin::class)->names('kontenDownload');

    Route::prefix('download')->name('fileDownload.')->group(function () {
        Route::get('/{slug?}', [FileDownloadController::class, 'index'])->name('index');
        Route::get('/create/{slug?}', [FileDownloadController::class, 'create'])->name('create');
        Route::post('/', [FileDownloadController::class, 'store'])->name('store');
        Route::get('/{id}/edit/{kategori?}', [FileDownloadController::class, 'edit'])->name('edit');
        Route::put('/{id}', [FileDownloadController::class, 'update'])->name('update');
        Route::delete('/{id}', [FileDownloadController::class, 'destroy'])->name('destroy');
    });

    Route::resource('berita', BeritaController::class);

    Route::resource('kontak', KontakController::class);

    Route::resource('kotak-masuk', KotakMasukController::class)->names('kotakMasuk');

    Route::resource('admin-update', AdminUpdateController::class)->names('adminUpdate');

    Route::resource('faq', FaqController::class);
});
