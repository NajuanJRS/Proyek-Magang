<?php

namespace App\Http\Controllers\pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\admin\Header; // <-- Impor model Header

class KontakController extends Controller
{
    public function index(): View
    {
        // Ambil header untuk halaman kontak (id_kategori_header = 7)
        $header = Header::where('id_kategori_header', 7)->first();

        // Kirim data header ke view
        return view('pengguna.kontak.index', [
            'header' => $header
        ]);
    }
}
