<?php

namespace App\Http\Controllers\pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\admin\Header;
use App\Models\admin\KategoriDownload;

class PpidController extends Controller
{
    public function index(): View
    {
        $header = Header::where('id_kategori_header', 6)->first();
        $keterbukaanCard = KategoriDownload::where('halaman_induk', 'ppid')->first();
        return view('pengguna.ppid.index', compact('header', 'keterbukaanCard'));
    }

    public function show(string $slug): View
    {
        // Ambil semua item PPID dari database untuk sidebar
        $allPpidItems = KategoriDownload::where('halaman_induk', 'ppid')->get()->map(function ($item) use ($slug) {
            $item->active = $item->slug == $slug;
            $item->url = route('ppid.show', $item->slug);
            return $item;
        });

        // Tentukan view dan data berdasarkan slug
        if ($slug == 'informasi-publik') {
            $activeCategory = KategoriDownload::where('slug', $slug)->firstOrFail();
            $files = $activeCategory->files; // Mengambil file melalui relasi

            $pageContent = [
                'title' => $activeCategory->nama_kategori,
                'files' => $files,
            ];
            
            return view('pengguna.ppid.informasi_publik', [
                'pageContent' => $pageContent,
                'allPpidItems' => $allPpidItems
            ]);

        } elseif ($slug == 'profil') {
            // Logika untuk halaman Profil PPID
            $pageContent = [ 'title' => 'Profil PPID', 'content' => '...' ]; // Isi konten Anda di sini
            return view('pengguna.ppid.show', ['pageContent' => $pageContent, 'allPpidItems' => $allPpidItems]);

        } elseif ($slug == 'prosedur-permohonan-keberatan') {
            // Logika untuk halaman Prosedur
            $pageContent = [ 'title' => 'Prosedur Permohonan & Keberatan', 'content' => '...' ]; // Isi konten Anda di sini
            return view('pengguna.ppid.prosedur', ['pageContent' => $pageContent, 'allPpidItems' => $allPpidItems]);
        }

        // Jika slug tidak cocok, tampilkan halaman 404
        abort(404);
    }
}
