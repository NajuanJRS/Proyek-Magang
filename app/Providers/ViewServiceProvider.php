<?php

namespace App\Providers;

use Illuminate\Support\Facades\View; // <-- Tambahkan ini
use Illuminate\Support\ServiceProvider;
use App\Models\admin\Kontak; // <-- Tambahkan ini
use App\Models\admin\KotakMasuk;
use Illuminate\Support\Facades\Cache;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Mengirim data ke view footer setiap kali view tersebut dirender
        View::composer('pengguna.layouts.footer', function ($view) {
            // Ambil data kontak pertama dari database
            $kontakInfo = Kontak::first();
            // Kirim data ke view dengan nama variabel 'kontakInfo'
            $view->with('kontakInfo', $kontakInfo);
        });

        View::composer('admin.*', function ($view) {
            $count = KotakMasuk::where('status_dibaca', 0)->count();
            $view->with('unreadKotakMasuk', $count);
        });
    }
}
