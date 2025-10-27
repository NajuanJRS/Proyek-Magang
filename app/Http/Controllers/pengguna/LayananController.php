<?php

namespace App\Http\Controllers\pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\admin\Header;
use App\Models\admin\KategoriKonten;

class LayananController extends Controller
{
    public function index(): View
    {
        $header = Header::where('id_kategori_header', 3)->first();

        $cards = KategoriKonten::where('menu_konten', 'layanan')->get();

        return view('pengguna.layanan.index', [
            'header' => $header,
            'cards' => $cards
        ]);
    }

    public function show(string $slug): View
    {
        $activeCategory = KategoriKonten::where('slug', $slug)->firstOrFail();

        $allServices = KategoriKonten::where('menu_konten', 'layanan')->get()->map(function ($service) use ($slug) {
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
