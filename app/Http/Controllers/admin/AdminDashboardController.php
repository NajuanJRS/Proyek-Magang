<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Berita;
use App\Models\admin\Faq;
use App\Models\admin\FileDownload;
use App\Models\admin\Galeri;
use App\Models\admin\KategoriKonten;
use App\Models\admin\KotakMasuk;
use App\Models\admin\Mitra;
use App\Models\admin\Pejabat;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Hitung jumlah data dari setiap tabel
        $totalPejabat      = Pejabat::count();
        $totalLayanan      = KategoriKonten::where('menu_konten', 'Layanan')->count();
        $totalProfil       = KategoriKonten::where('menu_konten', 'Profil')->count();
        $totalBerita       = Berita::count();
        $totalFileDownload = FileDownload::count();
        $totalMitra        = Mitra::count();
        $totalPpid         = KategoriKonten::where('menu_konten', 'PPID')->count();
        $totalPesan        = KotakMasuk::where('status_dibaca', 'belum dibaca')->count();
        $totalGaleri       = Galeri::count();
        $totalFaq          = Faq::count();

        return view('admin.dashboard', compact(
            'totalPejabat',
            'totalLayanan',
            'totalProfil',
            'totalBerita',
            'totalFileDownload',
            'totalMitra',
            'totalPpid',
            'totalPesan',
            'totalGaleri',
            'totalFaq'
        ));
    }
}
