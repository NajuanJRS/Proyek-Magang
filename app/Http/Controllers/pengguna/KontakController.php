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
    public function store(Request $request)
    {
        // 1. Validasi input dari form
        $validatedData = $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'telepon' => 'required|string|max:16',
            'isi_pesan' => 'required|string',
        ]);
        try {
            // 2. Coba simpan data ke tabel kotak_masuk
            KotakMasuk::create($validatedData);

            // 3. Jika berhasil, redirect kembali dengan pesan sukses
            return redirect()->back()->with('success', 'Umpan Balik anda telah terkirim');

        } catch (\Exception $e) {
            // 4. Jika gagal, redirect kembali dengan pesan error dan input sebelumnya
            return redirect()->back()->with('error', 'Gagal mengirim Umpan Balik')->withInput();
        }
    }
}
