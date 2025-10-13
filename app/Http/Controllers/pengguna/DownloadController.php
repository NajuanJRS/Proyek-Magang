<?php

namespace App\Http\Controllers\pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Response; // <-- Pastikan ini ditambahkan
use App\Models\admin\Header;
use App\Models\admin\KategoriDownload;
use App\Models\admin\FileDownload;

class DownloadController extends Controller
{
    public function index(): View
    {
        // Ambil header untuk halaman download (asumsi id_kategori_header = 5)
        $header = Header::where('id_kategori_header', 5)->first();
        
        // Ambil semua kategori yang halaman_induk nya adalah 'download'
        $cards = KategoriDownload::where('halaman_induk', 'download')->get();

        return view('pengguna.download.index', [
            'header' => $header,
            'cards' => $cards
        ]);
    }
    
    public function show(string $slug): View
    {
        // 1. Ambil data kategori yang aktif berdasarkan slug
        $activeCategory = KategoriDownload::where('slug', $slug)->firstOrFail();

        // 2. Ambil semua file yang termasuk dalam kategori tersebut menggunakan relasi
        $files = $activeCategory->files;

        // 3. Siapkan data untuk sidebar
        $allDownloads = KategoriDownload::where('halaman_induk', 'download')->get()->map(function ($download) use ($slug) {
            $download['active'] = $download['slug'] == $slug;
            $download['url'] = url('/download/' . $download->slug);
            return $download;
        });

        // 4. Siapkan data untuk dikirim ke view
        $pageContent = [
            'title' => $activeCategory->nama_kategori,
            'files' => $files,
        ];

        return view('pengguna.download.show', [
            'pageContent' => $pageContent,
            'allDownloads' => $allDownloads
        ]);
    }

    // Method untuk mengunduh file (tidak berubah)
    public function downloadFile(string $filename)
    {
        $path = public_path('storage/upload/file/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        return Response::download($path);
    }
}
