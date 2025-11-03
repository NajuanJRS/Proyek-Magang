<?php

namespace App\Http\Controllers\pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\admin\Header;
use App\Models\admin\KategoriKonten;
use Illuminate\Support\Facades\Cache;

class LayananController extends Controller
{
    public function index(): View
    {
        $duration = now()->addMinutes(60);

        $header = Cache::remember('header_layanan', $duration, function () {
            return Header::where('id_kategori_header', 3)->first();
        });

        $cards = Cache::remember('kategori_layanan_semua', $duration, function () {
            return KategoriKonten::where('menu_konten', 'layanan')->get();
        });

        return view('pengguna.layanan.index', [
            'header' => $header,
            'cards' => $cards
        ]);
    }

    public function show(string $slug): View
    {
        $duration = now()->addMinutes(60);

        $activeCategory = Cache::remember('kategori_show_' . $slug, $duration, function () use ($slug) {
            return KategoriKonten::with('konten')->where('slug', $slug)->firstOrFail();
        });

        $allServices = Cache::remember('kategori_layanan_semua', $duration, function () {
            return KategoriKonten::where('menu_konten', 'layanan')->get();
        })->map(function ($service) use ($slug) {
            $service->active = $service->slug == $slug;
            $service->url = route('layanan.show', $service->slug);
            return $service;
        });

        $layananContent = $activeCategory->konten;

        return view('pengguna.layanan.show', [
            'layananContent' => $layananContent,
            'activeCategory' => $activeCategory,
            'allServices' => $allServices
        ]);
    }
}
