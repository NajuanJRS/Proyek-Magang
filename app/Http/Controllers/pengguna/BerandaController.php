<?php

namespace App\Http\Controllers\pengguna;

use App\Http\Controllers\Controller;
use App\Models\admin\Header;
use App\Models\admin\Berita;
use Illuminate\View\View;
use App\Models\admin\Mitra;
use App\Models\admin\Konten;
use App\Models\admin\Galeri;
use App\Models\admin\KategoriKonten;
use Illuminate\Support\Facades\Cache;

class BerandaController extends Controller
{
    public function index(): View
    {
        $durasiCache = now()->addMinutes(60);

        $heroSlides = Cache::remember('beranda_hero_slides', $durasiCache, function () {
            return Header::where('id_kategori_header', 1)->get();
        });

        $berita = Cache::remember('beranda_berita', $durasiCache, function () {
            return Berita::orderBy('tgl_posting', 'desc')->take(5)->get();
        });

        $mitra = Cache::remember('beranda_mitra', $durasiCache, function () {
            return Mitra::all();
        });

        $layanan = Cache::remember('beranda_layanan', $durasiCache, function () {
            return KategoriKonten::where('menu_konten', 'layanan')->take(4)->get();
        });

        $visiMisi = Cache::remember('beranda_visi_misi', $durasiCache, function () {
            return Konten::whereHas('kategoriKonten', function ($query) {
                $query->where('slug', 'visi-dan-misi-dinas-sosial');
            })->first();
        });

        $galeri = Cache::remember('beranda_galeri', $durasiCache, function () {
            return Galeri::orderBy('tanggal_upload', 'desc')->take(8)->get();
        });

        return view('pengguna.beranda', [
            'heroSlides' => $heroSlides,
            'berita' => $berita,
            'mitra' => $mitra,
            'layanan' => $layanan,
            'galeri' => $galeri,
            'visiMisi' => $visiMisi
        ]);
    }
}

