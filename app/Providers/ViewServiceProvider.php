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
        View::composer('pengguna.layouts.footer', function ($view) {
            $kontakInfo = Cache::remember('kontak_page_data', now()->addHours(24), function () {
                return Kontak::first();
            });
            $view->with('kontakInfo', $kontakInfo);
        });

        View::composer(['admin.*', 'Admin.*'], function ($view) {
            $count = KotakMasuk::where('status_dibaca', 0)->count();
            $view->with('unreadKotakMasuk', $count);
        });
    }
}
