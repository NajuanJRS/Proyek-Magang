<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Galeri;
use App\Traits\ManajemenGambarTrait; // 1. Panggil Trait
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Storage; // Tidak perlu lagi jika hanya pakai Trait
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse; // Tambahkan ini untuk return type hinting

class GaleriController extends Controller
{
    // 2. Gunakan Trait
    use ManajemenGambarTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $galeri = Galeri::when($search, function ($query, $search) {
            $query->where('judul', 'like', "%$search%");
        })->paginate(10);

        return view('Admin.profile.galeri.galeri', compact('galeri'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View // Hapus parameter $galeri yang tidak perlu
    {
        // Variabel $galeri tidak diperlukan saat membuat baru
        return view('Admin.profile.galeri.formgaleri');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse // Tambah return type
    {
        // 3. Sesuaikan validasi
        $request->validate([
            // 'id_user' => 'nullable|exists:users,id_user', // Tidak perlu divalidasi, diambil dari Auth
            'judul' => 'required|string|min:5|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,svg,webp|max:5120', // Naikkan max size
            // 'tanggal_upload' => 'nullable|date', // Tidak perlu, otomatis 'now()'
        ]);

        // 4. Panggil fungsi Trait
        $pathGambar = null;
        if ($request->hasFile('gambar')) {
            $pathGambar = $this->prosesDanSimpanGambar(
                $request->file('gambar'),
                'galeri', // Tipe gambar
                'galeri'  // Folder tujuan
            );
        }

        // Handle jika prosesDanSimpanGambar gagal (misal karena error permission)
        if (!$pathGambar && $request->hasFile('gambar')) {
             return redirect()->back()->withErrors(['gambar' => 'Gagal memproses gambar.'])->withInput();
        }


        $idUser = Auth::check() && Auth::user()->role === 'admin' // Perbaiki role 'Admin' menjadi 'admin'
            ? 1
            : Auth::id();

        // 5. Gunakan path dari Trait
        Galeri::create([
            'id_user'    => $idUser,
            'judul' => $request->judul,
            'gambar'     => $pathGambar, // Gunakan path hasil Trait
            'tanggal_upload' => now(), // Otomatis isi tanggal sekarang
        ]);

        return redirect()->route('admin.galeri.index')->with('success', 'Galeri Berhasil Ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Galeri $galeri)
    {
        // Tidak digunakan di admin
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Galeri $galeri): View // Tambah return type View
    {
        // FindOrFail tidak perlu jika menggunakan Route Model Binding
        // $galeri = Galeri::findOrFail($galeri->id_galeri);
        return view('Admin.profile.galeri.formEditGaleri', compact('galeri'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Galeri $galeri): RedirectResponse // Tambah return type
    {
        // 6. Sesuaikan validasi update
        $request->validate([
            // 'id_user' => 'nullable|exists:users,id_user',
            'judul' => 'required|string|min:5|max:255', // Judul tetap required saat update
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:5120', // Naikkan max size
            // 'tanggal_upload' => 'nullable|date', // Tanggal upload biasanya tidak diubah
        ]);

        $idUser = Auth::check() && Auth::user()->role === 'admin' // Perbaiki role 'Admin' menjadi 'admin'
            ? 1
            : Auth::id();

        $data = [
            'id_user'    => $idUser,
            'judul' => $request->judul,
            // tanggal_upload tidak diupdate
        ];

        // 7. Gunakan Trait untuk proses update gambar
        if ($request->hasFile('gambar')) {
            $this->hapusGambarLama($galeri->gambar); // Hapus gambar lama
            $pathGambarBaru = $this->prosesDanSimpanGambar($request->file('gambar'), 'galeri', 'galeri');

            // Handle jika proses gagal
             if (!$pathGambarBaru) {
                return redirect()->back()->withErrors(['gambar' => 'Gagal memproses gambar baru.'])->withInput();
            }
            $data['gambar'] = $pathGambarBaru; // Gunakan path baru
        }

        $galeri->update($data);

        return redirect()->route('admin.galeri.index')->with('success', 'Galeri Berhasil Diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Galeri $galeri): RedirectResponse // Tambah return type
    {
        // 8. Gunakan Trait untuk menghapus gambar
        $this->hapusGambarLama($galeri->gambar);

        // Hapus data dari database
        $galeri->delete();

        return redirect()->route('admin.galeri.index')->with('success', 'Galeri Berhasil Dihapus!');
    }
}
