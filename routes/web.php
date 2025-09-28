<?php

use App\Http\Controllers\admin\AdminUpdateController;
use App\Http\Controllers\admin\BeritaController;
use App\Http\Controllers\admin\FaqController;
use App\Http\Controllers\admin\FileDownloadController;
use App\Http\Controllers\admin\HeaderProfileController;
use App\Http\Controllers\admin\KontakController;
use App\Http\Controllers\admin\KotakMasukController;
use App\Http\Controllers\admin\LayananKamiController;
use App\Http\Controllers\admin\ManajemenProfileController;
use App\Http\Controllers\admin\MitraController;
use App\Http\Controllers\admin\PageHeaderController;
use App\Http\Controllers\admin\pejabatController;
use App\Http\Controllers\admin\SliderController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

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
