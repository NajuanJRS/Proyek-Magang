<?php

namespace App\Http\Controllers\pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\admin\Header;
use App\Models\admin\Kontak;
use App\Models\admin\KotakMasuk;

class KontakController extends Controller
{
    public function index(): View
    {
        $header = Header::where('id_kategori_header', 7)->first();
        $kontak = Kontak::first();

        if ($kontak && $kontak->map) {
            preg_match('/src="([^"]+)"/', $kontak->map, $matches);
            $kontak->map_url = $matches[1] ?? '';
        }

        return view('pengguna.kontak.index', [
            'header' => $header,
            'kontak' => $kontak
        ]);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'telepon' => 'required|string|max:16',
            'isi_pesan' => 'required|string',
        ]);
        try {
            KotakMasuk::create($validatedData);

            return redirect()->back()->with('success', 'Umpan Balik anda telah terkirim');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengirim Umpan Balik')->withInput();
        }
    }
}
