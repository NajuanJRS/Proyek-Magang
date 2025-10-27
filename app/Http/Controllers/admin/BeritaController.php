<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Berita;
use App\Traits\ManajemenGambarTrait; // 1. Panggil Trait
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    // 2. "Tempelkan" Trait ke Controller ini
    use ManajemenGambarTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $berita = Berita::when($search, function ($query, $search) {
            $query->where('judul', 'like', "%{$search}%")
                  ->orWhere('isi_berita1', 'like', "%{$search}%")
                  ->orWhere('isi_berita2', 'like', "%{$search}%")
                  ->orWhere('isi_berita3', 'like', "%{$search}%");
        })
        ->orderBy('id_berita', 'desc')
        ->paginate(10);

        $berita->appends(['search' => $search]);

        return view('Admin.berita.kontenBerita.kontenBerita', compact('berita'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('Admin.berita.kontenBerita.formKontenBerita');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // 3. Naikkan batas ukuran file di validasi
        $request->validate([
            'judul' => 'required|string|max:255|min:5',
            'isi_berita1' => 'required|min:5',
            'gambar1' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120', // 5MB
            'isi_berita2' => 'nullable|min:5',
            'gambar2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120', // 5MB
            'isi_berita3' => 'nullable|min:5',
            'gambar3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120', // 5MB
        ]);

        $slug = $this->getUniqueSlug($request->judul);

        // 4. Panggil fungsi dari Trait untuk memproses setiap gambar
        $pathGambar1 = null;
        $pathGambar2 = null;
        $pathGambar3 = null;

        if ($request->hasFile('gambar1')) {
            $pathGambar1 = $this->prosesDanSimpanGambar($request->file('gambar1'), 'berita', 'berita');
        }
        if ($request->hasFile('gambar2')) {
            $pathGambar2 = $this->prosesDanSimpanGambar($request->file('gambar2'), 'berita', 'berita');
        }
        if ($request->hasFile('gambar3')) {
            $pathGambar3 = $this->prosesDanSimpanGambar($request->file('gambar3'), 'berita', 'berita');
        }

        $idUser = Auth::check() && Auth::user()->role === 'admin' ? 1 : Auth::id();

        Berita::create([
            'id_user'    => $idUser,
            'judul'      => $request->judul,
            'slug'       => $slug,
            'isi_berita1' => $request->isi_berita1,
            'gambar1'     => $pathGambar1,
            'isi_berita2' => $request->isi_berita2,
            'gambar2'     => $pathGambar2,
            'isi_berita3' => $request->isi_berita3,
            'gambar3'     => $pathGambar3,
            'dibaca'     => 0,
            'tgl_posting'=> now(),
        ]);

        return redirect()->route('admin.berita.index')->with('success', 'Berita Berhasil Ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Berita $berita)
    {
        // Tidak digunakan di admin
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $berita = Berita::findOrFail($id);
        return view('Admin.berita.kontenBerita.formEditKontenBerita', compact('berita'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'judul' => 'required|string|max:255|min:5',
            'isi_berita1' => 'required|min:5',
            'gambar1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120', // 5MB
            'isi_berita2' => 'nullable|min:5',
            'gambar2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120', // 5MB
            'isi_berita3' => 'nullable|min:5',
            'gambar3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120', // 5MB
        ]);

        $berita = Berita::findOrFail($id);
        $idUser = Auth::check() && Auth::user()->role === 'admin' ? 1 : Auth::id();

        $data = [
            'id_user'    => $idUser,
            'judul'      => $request->judul,
            'isi_berita1' => $request->isi_berita1,
            'isi_berita2' => $request->isi_berita2,
            'isi_berita3' => $request->isi_berita3,
        ];

        if ($request->judul !== $berita->judul) {
            $data['slug'] = $this->getUniqueSlug($request->judul, $id);
        }

        // Handle Gambar 1 (jika ada file baru diupload)
        if ($request->hasFile('gambar1')) {
            $this->hapusGambarLama($berita->gambar1); // Hapus gambar lama
            $data['gambar1'] = $this->prosesDanSimpanGambar($request->file('gambar1'), 'berita', 'berita');
        }

        // Handle Gambar 2 (jika ada file baru ATAU jika dicentang untuk dihapus)
        if ($request->hasFile('gambar2')) {
            $this->hapusGambarLama($berita->gambar2);
            $data['gambar2'] = $this->prosesDanSimpanGambar($request->file('gambar2'), 'berita', 'berita');
        } elseif ($request->has('hapus_gambar2') && $request->hapus_gambar2 == 1) {
            $this->hapusGambarLama($berita->gambar2);
            $data['gambar2'] = null;
        }

        // Handle Gambar 3 (jika ada file baru ATAU jika dicentang untuk dihapus)
        if ($request->hasFile('gambar3')) {
            $this->hapusGambarLama($berita->gambar3);
            $data['gambar3'] = $this->prosesDanSimpanGambar($request->file('gambar3'), 'berita', 'berita');
        } elseif ($request->has('hapus_gambar3') && $request->hapus_gambar3 == 1) {
            $this->hapusGambarLama($berita->gambar3);
            $data['gambar3'] = null;
        }

        $berita->update($data);
        return redirect()->route('admin.berita.index')->with('success', 'Berita Berhasil Diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $berita = Berita::findOrFail($id);

        // Panggil fungsi hapus dari Trait untuk setiap gambar
        $this->hapusGambarLama($berita->gambar1);
        $this->hapusGambarLama($berita->gambar2);
        $this->hapusGambarLama($berita->gambar3);

        $berita->delete();
        return redirect()->route('admin.berita.index')->with('success', 'Berita Berhasil Dihapus!');
    }

    /**
     * Generate a unique slug for the news item.
     */
    private function getUniqueSlug(string $title, ?int $exceptId = null): string
    {
        $slug = Str::slug($title, '-');
        $originalSlug = $slug;
        $count = 1;

        $query = Berita::where('slug', $slug);

        if ($exceptId !== null) {
            $query->where('id_berita', '!=', $exceptId);
        }

        while ($query->exists()) {
            $count++;
            $slug = $originalSlug . '-' . $count;
            $query = Berita::where('slug', $slug);
            if ($exceptId !== null) {
                $query->where('id_berita', '!=', $exceptId);
            }
        }

        return $slug;
    }
}
