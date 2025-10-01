<?php

namespace App\Http\Controllers\pengguna;

use App\Http\Controllers\Controller;
use App\Models\admin\Header;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BerandaController extends Controller
{
    public function index(): View
    {
        // Ambil semua data dari tabel 'header'
        $heroSlides = Header::where('id_kategori_header', 1)->get();

        // Kirim data ke view beranda
        return view('pengguna.beranda', [
            'heroSlides' => $heroSlides
        ]);
    }
}
