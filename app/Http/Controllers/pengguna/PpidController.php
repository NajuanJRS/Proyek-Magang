<?php

namespace App\Http\Controllers\pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\admin\Header;
use App\Models\admin\KategoriDownload;
use App\Models\admin\KategoriKonten; // Pastikan model ini di-import
use App\Models\admin\Konten;       // Pastikan model ini di-import

class PpidController extends Controller
{
    public function index(): View
    {
        // Ambil header untuk halaman PPID (asumsi id_kategori_header = 6)
        $header = Header::where('id_kategori_header', 6)->first();
        
        // Ambil semua kartu dari kedua tabel yang halaman induknya 'ppid'
        $kategoriKonten = KategoriKonten::where('menu_konten', 'ppid')->get();
        $kategoriDownload = KategoriDownload::where('halaman_induk', 'ppid')->get();

        // Gabungkan keduanya untuk ditampilkan sebagai kartu
        $cards = $kategoriKonten->concat($kategoriDownload);

        return view('pengguna.ppid.index', [
            'header' => $header,
            'cards' => $cards
        ]);
    }

    public function show(string $slug): View
    {
        // Siapkan data untuk sidebar dengan menggabungkan item dari kedua tabel
        $allPpidKonten = KategoriKonten::where('menu_konten', 'ppid')->get();
        $allPpidDownload = KategoriDownload::where('halaman_induk', 'ppid')->get();
        $allPpidItems = $allPpidKonten->concat($allPpidDownload)->map(function ($item) use ($slug) {
            // Normalisasi properti agar seragam
            $item->slug = $item->slug ?? $item->slug;
            $item->judul = $item->judul_konten ?? $item->nama_kategori;
            $item->icon = $item->icon_konten ?? $item->icon;
            $item->active = $item->slug == $slug;
            $item->url = route('ppid.show', $item->slug);
            return $item;
        });

        // Cek apakah slug yang diminta adalah untuk kategori download
        $kategoriDownload = KategoriDownload::where('slug', $slug)->first();

        if ($kategoriDownload) {
            // Jika ya, tampilkan halaman daftar unduhan
            $viewName = 'pengguna.ppid.informasi_publik';
            $viewData['pageContent'] = [
                'title' => $kategoriDownload->nama_kategori,
                'files' => $kategoriDownload->files, // Mengambil relasi files
            ];
        } else {
            // Jika tidak, cari di kategori konten biasa
            $activeCategory = KategoriKonten::where('slug', $slug)->firstOrFail();
            $viewName = 'pengguna.ppid.show'; // View default untuk konten teks/gambar
            $viewData['activeCategory'] = $activeCategory;
            $viewData['pageContent'] = $activeCategory->konten;
        }

        $viewData['allPpidItems'] = $allPpidItems;
        
        return view($viewName, $viewData);
    }
}
