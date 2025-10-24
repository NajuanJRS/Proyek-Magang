<?php

namespace App\Http\Controllers\admin\Header;

use App\Http\Controllers\Controller;
use App\Models\admin\Header;
// use App\Models\admin\KategoriHeader; // Tidak perlu di sini
use App\Traits\ManajemenGambarTrait; // 1. Panggil Trait
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse; // Import RedirectResponse
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Storage; // Tidak perlu lagi

class HeaderBeritaController extends Controller
{
    // 2. Gunakan Trait
    use ManajemenGambarTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        // Filter hanya untuk id_kategori_header = 4 (Heading Berita)
        $headerBerita = Header::where('id_kategori_header', 4)
            ->when($search, function ($query, $search) {
                // Sesuaikan pencarian ke field yang ada di tabel 'header'
                $query->where('headline', 'like', "%{$search}%")
                      ->orWhere('sub_heading', 'like', "%{$search}%");
            })->paginate(10); // Ambil hanya 1 karena hanya ada 1 header berita

        return view('Admin.berita.headerBerita.headerBerita', compact('headerBerita'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Header $headerBerita)
    {
        // Tidak digunakan
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Header $headerBerita): View // Tambahkan View return type
    {
        // FindOrFail tidak perlu jika menggunakan Route Model Binding
        // $headerBerita = Header::findOrFail($headerBerita->id_header);
        // Pastikan hanya bisa edit header berita (id_kategori_header = 4)
        if ($headerBerita->id_kategori_header != 4) {
            abort(404); // Atau redirect dengan error
        }
        // $kategoriHeader = KategoriHeader::all(); // Tidak perlu
        return view('Admin.berita.headerBerita.formEditHeaderBerita', compact('headerBerita'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Header $headerBerita): RedirectResponse // Tambahkan RedirectResponse
    {
         // Pastikan hanya bisa update header berita (id_kategori_header = 4)
        if ($headerBerita->id_kategori_header != 4) {
             abort(403, 'Unauthorized action.'); // Lebih sesuai dari 404
        }

        // 3. Sesuaikan Validasi
        $request->validate([
            // 'id_user' => 'nullable|exists:user,id_user', // Otomatis
            'headline' => 'required|string|min:5|max:100', // Wajib diisi
            'sub_heading' => 'required|string|min:5|max:255', // Wajib diisi
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120', // Max 5MB, nullable karena mungkin tidak ganti gambar
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
            $this->hapusGambarLama($headerBerita->gambar); // Hapus gambar lama
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
        // Jika tidak ada gambar baru, $data['gambar'] tidak diset, gambar lama tetap

        $headerBerita->update($data);

        return redirect()->route('admin.headerBerita.index')->with('success', 'Heading Berita Berhasil Diperbarui!');
    }

     // Method destroy() biasanya tidak ada untuk header halaman tunggal,
     // Jika memang diperlukan, jangan lupa tambahkan hapusGambarLama()
}
