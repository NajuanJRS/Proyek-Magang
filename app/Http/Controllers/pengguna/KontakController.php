<?php

namespace App\Http\Controllers\pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\admin\Header;
use App\Models\admin\Kontak;
use App\Models\admin\KotakMasuk;
use Illuminate\Support\Facades\Cache;

class KontakController extends Controller
{
    public function index(): View
    {
        $header = Cache::remember('header_kontak', now()->addHours(24), function () {
            return Header::where('id_kategori_header', 7)->first();
        });

        $kontak = Cache::remember('kontak_page_data', now()->addHours(24), function () {
            return Kontak::first();
        });

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
            Cache::increment('unread_kotak_masuk_count');

            return redirect()->back()->with('success', 'Umpan Balik anda telah terkirim');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengirim Umpan Balik')->withInput();
        }
    }
}

