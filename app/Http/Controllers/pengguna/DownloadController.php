<?php

namespace App\Http\Controllers\pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Response;
use App\Models\admin\Header;
use App\Models\admin\KategoriDownload;
use App\Models\admin\FileDownload;

use Illuminate\Support\Facades\Cache;

class DownloadController extends Controller
{
    public function index(): View
    {
        $header = Cache::remember('header_download', now()->addDays(7), function () {
            return Header::where('id_kategori_header', 5)->first();
        });

        $cards = Cache::remember('kategori_download_semua', now()->addHours(6), function () {
            return KategoriDownload::where('halaman_induk', 'download')->get();
        });

        return view('pengguna.download.index', [
            'header' => $header,
            'cards' => $cards
        ]);
    }

    public function show(string $slug): View
    {
// <-- PERUBAHAN DI SINI: HAPUS CACHE UNTUK DETAIL KATEGORI DAN FILE
        // Ambil data kategori DAN filenya langsung dari database
        $activeCategory = KategoriDownload::with('files')->where('slug', $slug)->firstOrFail();

        // Ambil files dari data yang baru di-query
        $files = $activeCategory->files;
        // --->

        // Cache untuk sidebar (daftar semua kategori) tetap ada
        $allDownloadsFromCache = Cache::remember('kategori_download_semua', now()->addHours(6), function () {
            return KategoriDownload::where('halaman_induk', 'download')->get();
        });

        $allDownloads = $allDownloadsFromCache->map(function ($download) use ($slug) {
            $download['active'] = $download['slug'] == $slug;
            $download['url'] = url('/download/' . $download->slug);
            return $download;
        });

        $pageContent = [
            'title' => $activeCategory->nama_kategori,
            'files' => $files, // Data file ini sekarang dijamin segar
        ];

        return view('pengguna.download.show', [
            'pageContent' => $pageContent,
            'allDownloads' => $allDownloads
        ]);
    }

    public function downloadFile(string $filename)
    {
        $path = public_path('storage/upload/file/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        return Response::download($path);
    }
}
