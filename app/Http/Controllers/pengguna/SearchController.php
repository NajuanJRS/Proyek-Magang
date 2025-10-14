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
        // 1. Validasi input
        $request->validate(['keyword' => 'required']);
        $keyword = $request->input('keyword');
        $kategoriAktif = $request->input('kategori', 'semua'); // Ambil kategori, default 'semua'

        // --- PENGAMBILAN SEMUA DATA UNTUK PENGHITUNGAN ---
        $beritaResults = Berita::where('judul', 'LIKE', "%{$keyword}%")->get();
        $infoResults = KategoriKonten::whereIn('nama_menu_kategori', ['profil', 'ppid'])
            ->where('judul_konten', 'LIKE', "%{$keyword}%")
            ->get();
        $layananResults = KategoriKonten::where('nama_menu_kategori', 'layanan')
            ->where('judul_konten', 'LIKE', "%{$keyword}%")
            ->get();
        $dokumenResults = FileDownload::where('nama_file', 'LIKE', "%{$keyword}%")->get();
        $faqResults = Faq::where('pertanyaan', 'LIKE', "%{$keyword}%")->get();

        // --- PENGHITUNGAN UNTUK FILTER ---
        $filters = [
            ['slug' => 'semua', 'name' => 'Semua', 'count' => $beritaResults->count() + $infoResults->count() + $layananResults->count() + $dokumenResults->count() + $faqResults->count()],
            ['slug' => 'berita', 'name' => 'Berita & Kegiatan', 'count' => $beritaResults->count()],
            ['slug' => 'informasi', 'name' => 'Profil & Informasi', 'count' => $infoResults->count()],
            ['slug' => 'layanan', 'name' => 'Layanan', 'count' => $layananResults->count()],
            ['slug' => 'dokumen', 'name' => 'Dokumen & Download', 'count' => $dokumenResults->count()],
            ['slug' => 'faq', 'name' => 'FAQ', 'count' => $faqResults->count()],
        ];

        // --- GABUNGKAN SEMUA HASIL JADI SATU KOLEKSI ---
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
            $routeName = ($item->nama_menu_kategori == 'profil') ? 'profil.show' : 'ppid.show';
            $allResults->push([
                'title' => $item->judul_konten,
                'category' => 'Profil & Informasi',
                'url' => route($routeName, $item->slug_konten),
                'type' => 'informasi'
            ]);
        }
        foreach ($layananResults as $item) {
            $allResults->push([
                'title' => $item->judul_konten,
                'category' => 'Layanan',
                'url' => route('layanan.show', $item->slug_konten),
                'type' => 'layanan'
            ]);
        }
        foreach ($dokumenResults as $item) {
            $allResults->push([
                'title' => $item->nama_file,
                'category' => 'Dokumen & Download',
                'url' => route('download.file', ['filename' => $item->file]), // URL untuk download langsung
                'type' => 'dokumen',
                'file_obj' => $item // Sertakan seluruh objek file untuk view
            ]);
        }
        foreach ($faqResults as $item) {
            $allResults->push([
                'title' => $item->pertanyaan,
                'answer' => $item->jawaban,
                'category' => 'FAQ',
                'url' => null, // Tidak ada URL detail untuk FAQ di pencarian
                'type' => 'faq',
            ]);
        }

        // --- FILTER HASIL BERDASARKAN KATEGORI YANG AKTIF ---
        $filteredResults = $allResults;
        if ($kategoriAktif !== 'semua') {
            $filteredResults = $allResults->filter(function ($item) use ($kategoriAktif) {
                return $item['type'] == $kategoriAktif;
            });
        }

        // --- Pisahkan hasil FAQ dari hasil lainnya SETELAH difilter ---
        $faq_results = $filteredResults->where('type', 'faq');
        $other_results = $filteredResults->where('type', '!=', 'faq');

        // --- KIRIM DATA KE VIEW ---
        return view('pengguna.pencarian.index', [
            'keyword' => $keyword,
            'results' => $other_results,
            'faq_results' => $faq_results,
            'filters' => $filters,
            'kategoriAktif' => $kategoriAktif
        ]);
    }
}
