<?php

namespace App\Http\Controllers\pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Response; // <-- Pastikan ini ditambahkan
use App\Models\admin\Header;

class DownloadController extends Controller
{
        public function index(): View
    {
        // Ambil header untuk halaman download (asumsi id_kategori_header = 4)
        $header = Header::where('id_kategori_header', 4)->first();

        // Kirim data header ke view
        return view('pengguna.download.index', [
            'header' => $header
        ]);
    }
    public function show(string $slug): View
    {
        // --- DATA DUMMY (Nanti ini akan diambil dari database) ---

        // Daftar semua kategori download untuk sidebar
        $allDownloads = [
            ['title' => 'Formulir Layanan', 'img' => 'formulir.png', 'slug' => 'formulir-layanan'],
            ['title' => 'Peraturan & Kebijakan', 'img' => 'peraturan.png', 'slug' => 'peraturan-kebijakan'],
            ['title' => 'Laporan Kinerja', 'img' => 'laporan.png', 'slug' => 'laporan-kinerja'],
            ['title' => 'Materi Sosialisasi', 'img' => 'sosialisasi.png', 'slug' => 'materi-sosialisasi'],
            ['title' => 'Standar Operasional Prosedur (SOP)', 'img' => 'sop.png', 'slug' => 'sop'],
        ];

        // Menandai kategori mana yang sedang aktif
        $downloadsWithStatus = array_map(function ($download) use ($slug) {
            $download['active'] = $download['slug'] == $slug;
            $download['url'] = url('/download/' . $download['slug']);
            return $download;
        }, $allDownloads);

        // Konten utama untuk halaman "Formulir Layanan"
        // 'url' diubah menjadi 'filename'
        $pageContent = [
            'title' => 'Formulir Layanan',
            'files' => [
                ['name' => 'Formulir Permohonan Pengangkatan Anak - 2025', 'filename' => 'sample.pdf'],
                ['name' => 'Formulir Pendaftaran Bantuan UEP untuk Keluarga Miskin', 'filename' => 'sample.pdf'],
                ['name' => 'Surat Pernyataan Calon Penerima Bantuan Rehabilitasi Rumah', 'filename' => 'sample.pdf'],
            ]
        ];

        return view('pengguna.download.show', [
            'pageContent' => $pageContent,
            'allDownloads' => $downloadsWithStatus
        ]);
    }

    // === METHOD BARU UNTUK MENGUNDUH FILE ===
    public function downloadFile(string $filename)
    {
        // Tentukan path lengkap ke file di dalam folder public/downloads
        $path = public_path('downloads/' . $filename);

        // Periksa apakah file tersebut ada
        if (!file_exists($path)) {
            // Jika tidak ada, kembalikan halaman error 404
            abort(404);
        }

        // Jika file ada, kirim sebagai respons unduhan
        return Response::download($path);
    }
}
