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
        // Ambil header untuk halaman layanan (asumsi id_kategori_header = 3)
        $header = Header::where('id_kategori_header', 3)->first();

        // Ambil semua kartu kategori yang termasuk dalam 'layanan'
        $cards = KategoriKonten::where('nama_menu_kategori', 'layanan')->get();

        return view('pengguna.layanan.index', [
            'header' => $header,
            'cards' => $cards
        ]);
    }

    public function show(string $slug): View
    {
        // Ambil item kategori yang aktif berdasarkan slug
        $activeCategory = KategoriKonten::where('slug_konten', $slug)->firstOrFail();

        // Ambil semua item layanan untuk sidebar
        $allServices = KategoriKonten::where('nama_menu_kategori', 'layanan')->get()->map(function ($service) use ($slug) {
            $service->active = $service->slug_konten == $slug;
            $service->url = route('layanan.show', $service->slug_konten);
            return $service;
        });

        // Ambil konten detail yang terhubung dengan kategori ini
        $layananContent = $activeCategory->konten;

        return view('pengguna.layanan.show', [
            'layananContent' => $layananContent,
            'activeCategory' => $activeCategory,
            'allServices' => $allServices
        ]);
    }
}
