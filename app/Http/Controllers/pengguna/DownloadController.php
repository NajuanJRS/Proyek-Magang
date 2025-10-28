<?php

namespace App\Http\Controllers\pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Response;
use App\Models\admin\Header;
use App\Models\admin\KategoriDownload;
use App\Models\admin\FileDownload;

class DownloadController extends Controller
{
    public function index(): View
    {
        $header = Header::where('id_kategori_header', 5)->first();

        $cards = KategoriDownload::where('halaman_induk', 'download')->get();

        return view('pengguna.download.index', [
            'header' => $header,
            'cards' => $cards
        ]);
    }

    public function show(string $slug): View
    {
        $activeCategory = KategoriDownload::where('slug', $slug)->firstOrFail();

        $files = $activeCategory->files;

        $allDownloads = KategoriDownload::where('halaman_induk', 'download')->get()->map(function ($download) use ($slug) {
            $download['active'] = $download['slug'] == $slug;
            $download['url'] = url('/download/' . $download->slug);
            return $download;
        });

        $pageContent = [
            'title' => $activeCategory->nama_kategori,
            'files' => $files,
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
