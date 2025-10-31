<?php

namespace App\Http\Controllers\admin\Header;

use App\Http\Controllers\Controller;
use App\Models\admin\Header;
// use App\Models\admin\KategoriHeader; // Tidak perlu
use App\Traits\ManajemenGambarTrait; // 1. Panggil Trait
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse; // Import RedirectResponse
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
// use Illuminate\Support\Facades\Storage; // Tidak perlu lagi

class HeaderLayananController extends Controller
{
    // 2. Gunakan Trai
    use ManajemenGambarTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        // Filter hanya untuk id_kategori_header = 3 (Heading Layanan)
        $headerLayanan = Header::where('id_kategori_header', 3)
            ->when($search, function ($query, $search) {
                // Sesuaikan pencarian ke field yang ada
                $query->where('headline', 'like', "%{$search}%")
                      ->orWhere('sub_heading', 'like', "%{$search}%");
            })->paginate(1); // Ambil hanya 1 record

        return view('Admin.layanan.headerLayanan.headerLayanan', compact('headerLayanan'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Header $headerLayanan)
    {
        // Tidak digunakan
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Header $headerLayanan): View // Tambahkan View return type
    {
        // FindOrFail tidak perlu jika menggunakan Route Model Binding
        // Pastikan hanya bisa edit header layanan (id_kategori_header = 3)
        if ($headerLayanan->id_kategori_header != 3) {
            abort(404);
        }
        // $kategoriHeader = KategoriHeader::all(); // Tidak perlu
        return view('Admin.layanan.headerLayanan.formEditHeaderLayanan', compact('headerLayanan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Header $headerLayanan): RedirectResponse // Tambahkan RedirectResponse
    {
        // Pastikan hanya bisa update header layanan (id_kategori_header = 3)
        if ($headerLayanan->id_kategori_header != 3) {
            abort(403, 'Unauthorized action.');
        }

        // 3. Sesuaikan Validasi
        $request->validate([
            'headline' => 'required|string|min:5|max:100', // Wajib diisi
            'sub_heading' => 'required|string|min:5|max:255', // Wajib diisi
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120', // Max 5MB, nullable
        ]);

        $idUser = Auth::check() && Auth::user()->role === 'admin'
            ? 1
            : Auth::id();

        $data = [
            'id_user'    => $idUser,
            'headline' => $request->headline,
            'sub_heading' => $request->sub_heading,
        ];

        // 4. Proses Update Gambar Header dengan Trait (tipe 'page_header')
        if ($request->hasFile('gambar')) {
            $this->hapusGambarLama($headerLayanan->gambar); // Hapus gambar lama
            $pathGambarBaru = $this->prosesDanSimpanGambar(
                $request->file('gambar'),
                'page_header', // <-- Gunakan tipe untuk header halaman
                'header'       // Folder tujuan tetap 'header'
            );
             if (!$pathGambarBaru) {
                 return redirect()->back()->withErrors(['gambar' => 'Gagal memproses gambar header baru.'])->withInput();
            }
            $data['gambar'] = $pathGambarBaru; // Gunakan path baru
        }
        // Jika tidak ada gambar baru, $data['gambar'] tidak diset

        $headerLayanan->update($data);

        Cache::forget('header_layanan');

        return redirect()->route('admin.headerLayanan.index')->with('success', 'Heading Layanan Berhasil Diperbarui!');
    }

    // Method destroy() biasanya tidak ada untuk header halaman tunggal
}
