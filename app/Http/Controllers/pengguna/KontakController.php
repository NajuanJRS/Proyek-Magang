<?php

namespace App\Http\Controllers\pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\admin\Header;
use App\Models\admin\Kontak;

class KontakController extends Controller
{
    public function index(): View
    {
        $header = Header::where('id_kategori_header', 7)->first();
        $kontak = Kontak::first();

        // Cek jika data kontak dan peta ada
        if ($kontak && $kontak->map) {
            // "Bedah" string iframe untuk mengambil URL di dalam src="..."
            preg_match('/src="([^"]+)"/', $kontak->map, $matches);
            $kontak->map_url = $matches[1] ?? ''; // Ambil URL dan simpan ke properti baru
        }

        return view('pengguna.kontak.index', [
            'header' => $header,
            'kontak' => $kontak
        ]);
    }
}
