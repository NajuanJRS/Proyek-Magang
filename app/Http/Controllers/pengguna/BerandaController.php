<?php

namespace App\Http\Controllers\pengguna;

use App\Http\Controllers\Controller;
use App\Models\admin\Header;
use App\Models\admin\Berita;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\admin\Mitra;
use App\Models\admin\Konten;
use App\Models\admin\Galeri;
use App\Models\admin\KategoriKonten;

class BerandaController extends Controller
{
    public function index(): View
    {
        // Ambil semua data dari tabel 'header'
        $heroSlides = Header::where('id_kategori_header', 1)->get();
        // Ambil 5 berita terbaru, diurutkan dari yang paling baru
        $berita = Berita::orderBy('tgl_posting', 'desc')->take(5)->get();
        // mitra
        $mitra = Mitra::all();
        // layanan
        $layanan = KategoriKonten::where('menu_konten', 'layanan')->take(4)->get();
        // visi misi
        $visiMisi = Konten::whereHas('kategoriKonten', function ($query) {
            $query->where('slug', 'visi-dan-misi-dinas-sosial');
        })->first();
        // galeri
        $galeri = Galeri::orderBy('tanggal_upload', 'desc')->take(8)->get();


        // Kirim data ke view beranda
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
