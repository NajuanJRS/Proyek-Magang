<?php

namespace App\Http\Controllers\pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\admin\Header;
use App\Models\admin\KategoriDownload;
use App\Models\admin\KategoriKonten;
use App\Models\admin\Konten;
use Illuminate\Support\Facades\Cache;

class PpidController extends Controller
{
    public function index(): View
    {
        $keyHeader = 'header_ppid';
        $keyKategoriKonten = 'ppid.kategori_konten';
        $keyKategoriDownload = 'ppid.kategori_download';
        $durasiCache = now()->addMinutes(120);

        $header = Cache::remember($keyHeader, $durasiCache, function () {
            return Header::where('id_kategori_header', 6)->first();
        });

        $kategoriKonten = Cache::remember($keyKategoriKonten, $durasiCache, function () {
            return KategoriKonten::where('menu_konten', 'ppid')->get();
        });

        $kategoriDownload = Cache::remember($keyKategoriDownload, $durasiCache, function () {
            return KategoriDownload::where('halaman_induk', 'ppid')->get();
        });

        $cards = $kategoriKonten->concat($kategoriDownload);

        return view('pengguna.ppid.index', [
            'header' => $header,
            'cards' => $cards
        ]);
    }

    public function show(string $slug): View
{
        // Cache untuk sidebar navigasi (allPpidItems) tetap ada, ini sudah benar.
        $keyAllItems = 'ppid.all_items_nav';
        $durasiCacheNav = now()->addMinutes(120);

        $allPpidItems = Cache::remember($keyAllItems, $durasiCacheNav, function () {
            $allPpidKonten = KategoriKonten::where('menu_konten', 'ppid')->get();
            $allPpidDownload = KategoriDownload::where('halaman_induk', 'ppid')->get();
            return $allPpidKonten->concat($allPpidDownload);
        });

        $allPpidItems = $allPpidItems->map(function ($item) use ($slug) {
            $item->judul = $item->judul_konten ?? $item->nama_kategori;
            $item->icon = $item->icon_konten ?? $item->icon;
            $item->active = $item->slug == $slug;
            $item->url = route('ppid.show', $item->slug);
            return $item;
        });

        // --- PERUBAHAN LOGIKA UTAMA DI SINI ---

        // 1. Cek dulu apakah ini KategoriDownload (tanpa cache)
        // Ini adalah query 'murah' (berdasarkan slug) dan butuh data file yang segar.
        $kategoriDownload = KategoriDownload::with('files')->where('slug', $slug)->first();

        if ($kategoriDownload) {
            
            // --- INI HALAMAN DOWNLOAD (JANGAN DI-CACHE) ---
            $dataHalaman = [
                'view' => 'pengguna.ppid.informasi_publik',
                'data' => [
                    'pageContent' => [
                        'title' => $kategoriDownload->nama_kategori,
                        'files' => $kategoriDownload->files, // Data ini dijamin segar
                    ]
                ]
            ];

        } else {
            
            // --- INI HALAMAN KONTEN BIASA (BOLEH DI-CACHE) ---
            $keyContentSlug = "ppid.content.{$slug}";
            $durasiCacheContent = now()->addMinutes(120);

            // Gunakan Cache::remember HANYA untuk "konten biasa"
            // admin/PpidController.php sudah menghapus kunci ini, jadi ini aman.
            $dataHalaman = Cache::remember($keyContentSlug, $durasiCacheContent, function () use ($slug) {
                
                // Kita sudah tahu ini bukan KategoriDownload, jadi pasti KategoriKonten
                $activeCategory = KategoriKonten::with('konten')->where('slug', $slug)->firstOrFail();
                
                return [
                    'view' => 'pengguna.ppid.show',
                    'data' => [
                        'activeCategory' => $activeCategory,
                        'pageContent' => $activeCategory->konten,
                    ]
                ];
            });
        }
        
        // --- AKHIR PERUBAHAN ---

        $viewName = $dataHalaman['view'];
        $viewData = $dataHalaman['data'];
        $viewData['allPpidItems'] = $allPpidItems;

        return view($viewName, $viewData);
    }
}
