<?php

namespace App\Http\Controllers\pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\Berita;
use App\Models\admin\KategoriKonten;
use App\Models\admin\FileDownload;
use App\Models\admin\Faq;
use Illuminate\Support\Collection;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $request->validate(['keyword' => 'required']);
        $keyword = $request->input('keyword');
        $kategoriAktif = $request->input('kategori', 'semua');

        $beritaResults = Berita::where('judul', 'LIKE', "%{$keyword}%")->get();
        $infoResults = KategoriKonten::whereIn('menu_konten', ['profil', 'ppid'])
            ->where('judul_konten', 'LIKE', "%{$keyword}%")
            ->get();
        $layananResults = KategoriKonten::where('menu_konten', 'layanan')
            ->where('judul_konten', 'LIKE', "%{$keyword}%")
            ->get();
        $dokumenResults = FileDownload::where('nama_file', 'LIKE', "%{$keyword}%")->get();
        $faqResults = Faq::where('pertanyaan', 'LIKE', "%{$keyword}%")->get();

        $filters = [
            ['slug' => 'semua', 'name' => 'Semua', 'count' => $beritaResults->count() + $infoResults->count() + $layananResults->count() + $dokumenResults->count() + $faqResults->count()],
            ['slug' => 'berita', 'name' => 'Berita & Kegiatan', 'count' => $beritaResults->count()],
            ['slug' => 'informasi', 'name' => 'Profil & Informasi', 'count' => $infoResults->count()],
            ['slug' => 'layanan', 'name' => 'Layanan', 'count' => $layananResults->count()],
            ['slug' => 'dokumen', 'name' => 'Dokumen & Download', 'count' => $dokumenResults->count()],
            ['slug' => 'faq', 'name' => 'FAQ', 'count' => $faqResults->count()],
        ];

        $allResults = new Collection();

        foreach ($beritaResults as $item) {
            $allResults->push([
                'title' => $item->judul,
                'category' => 'Berita & Kegiatan',
                'url' => route('berita.show', $item->slug),
                'type' => 'berita'
            ]);
        }
        foreach ($infoResults as $item) {
            $routeName = ($item->menu_konten == 'profil') ? 'profil.show' : 'ppid.show';
            $allResults->push([
                'title' => $item->judul_konten,
                'category' => 'Profil & Informasi',
                'url' => route($routeName, $item->slug),
                'type' => 'informasi'
            ]);
        }
        foreach ($layananResults as $item) {
            $allResults->push([
                'title' => $item->judul_konten,
                'category' => 'Layanan',
                'url' => route('layanan.show', $item->slug),
                'type' => 'layanan'
            ]);
        }
        foreach ($dokumenResults as $item) {
            $allResults->push([
                'title' => $item->nama_file,
                'category' => 'Dokumen & Download',
                'url' => route('download.file', ['filename' => $item->file]),
                'type' => 'dokumen',
                'file_obj' => $item
            ]);
        }
        foreach ($faqResults as $item) {
            $allResults->push([
                'title' => $item->pertanyaan,
                'answer' => $item->jawaban,
                'category' => 'FAQ',
                'url' => null,
                'type' => 'faq',
            ]);
        }

        $filteredResults = $allResults;
        if ($kategoriAktif !== 'semua') {
            $filteredResults = $allResults->filter(function ($item) use ($kategoriAktif) {
                return $item['type'] == $kategoriAktif;
            });
        }

        $faq_results = $filteredResults->where('type', 'faq');
        $other_results = $filteredResults->where('type', '!=', 'faq');

        return view('pengguna.pencarian.index', [
            'keyword' => $keyword,
            'results' => $other_results,
            'faq_results' => $faq_results,
            'filters' => $filters,
            'kategoriAktif' => $kategoriAktif
        ]);
    }
}
