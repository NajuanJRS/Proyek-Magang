<?php

namespace App\Http\Controllers\pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\admin\Header;
use App\Models\admin\KategoriDownload;
use App\Models\admin\KategoriKonten;
use App\Models\admin\Konten;

class PpidController extends Controller
{
    public function index(): View
    {
        $header = Header::where('id_kategori_header', 6)->first();

        $kategoriKonten = KategoriKonten::where('menu_konten', 'ppid')->get();
        $kategoriDownload = KategoriDownload::where('halaman_induk', 'ppid')->get();

        $cards = $kategoriKonten->concat($kategoriDownload);

        return view('pengguna.ppid.index', [
            'header' => $header,
            'cards' => $cards
        ]);
    }

    public function show(string $slug): View
    {
        $allPpidKonten = KategoriKonten::where('menu_konten', 'ppid')->get();
        $allPpidDownload = KategoriDownload::where('halaman_induk', 'ppid')->get();
        $allPpidItems = $allPpidKonten->concat($allPpidDownload)->map(function ($item) use ($slug) {
            $item->judul = $item->judul_konten ?? $item->nama_kategori;
            $item->icon = $item->icon_konten ?? $item->icon;
            $item->active = $item->slug == $slug;
            $item->url = route('ppid.show', $item->slug);
            return $item;
        });

        $kategoriDownload = KategoriDownload::where('slug', $slug)->first();

        if ($kategoriDownload) {
            $viewName = 'pengguna.ppid.informasi_publik';
            $viewData['pageContent'] = [
                'title' => $kategoriDownload->nama_kategori,
                'files' => $kategoriDownload->files,
            ];
        } else {
            $activeCategory = KategoriKonten::where('slug', $slug)->firstOrFail();
            $viewName = 'pengguna.ppid.show';
            $viewData['activeCategory'] = $activeCategory;
            $viewData['pageContent'] = $activeCategory->konten;
        }

        $viewData['allPpidItems'] = $allPpidItems;

        return view($viewName, $viewData);
    }
}
