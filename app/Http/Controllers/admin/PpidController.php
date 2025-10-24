<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\KategoriKonten;
use App\Models\admin\Konten;
use App\Traits\ManajemenGambarTrait; // 1. Panggil Trait
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Storage; // Tidak perlu lagi
use Illuminate\View\View;
use Illuminate\Support\Str; // Import Str facade

class PpidController extends Controller
{
    // 2. Gunakan Trait
    use ManajemenGambarTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $kontenPpid = Konten::with('kategoriKonten')
            ->whereHas('kategoriKonten', function ($query) use ($search) {
                $query->where('menu_konten', 'PPID'); // Filter 'PPID'
                if (!empty($search)) {
                    // Search simplified to judul_konten
                     $query->where('judul_konten', 'like', "%{$search}%");
                }
            })
            ->orderBy('id_konten', 'desc')
            ->paginate(10);

        return view('Admin.ppid.kontenPpid.kontenPpid', compact('kontenPpid'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('Admin.ppid.kontenPpid.formKontenPpid');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // 3. Sesuaikan Validasi
        $request->validate([
            'judul_konten'  => 'required|string|max:255',
            'icon_konten'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:1024', // Max 1MB for icon
            'isi_konten1'  => 'required|string',
            'gambar1'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120', // Max 5MB for content images
            'isi_konten2'  => 'nullable|string',
            'gambar2'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'isi_konten3'  => 'nullable|string',
            'gambar3'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
        ]);

        // 4. Proses Icon Konten dengan Trait
        $pathIconKonten = null;
        if ($request->hasFile('icon_konten')) {
            $pathIconKonten = $this->prosesDanSimpanGambar($request->file('icon_konten'), 'icon', 'icon');
             if (!$pathIconKonten) {
                 return redirect()->back()->withErrors(['icon_konten' => 'Gagal memproses ikon.'])->withInput();
            }
        }

        // Simpan ke tabel kategori_konten
        $kategori = KategoriKonten::create([
            'menu_konten'     => 'PPID', // <-- Diubah ke 'PPID'
            'judul_konten'  => $request->judul_konten,
            'icon_konten'   => $pathIconKonten, // Path hasil Trait
            'slug'          => Str::slug($request->judul_konten),
        ]);

        // 5. Proses Gambar Konten dengan Trait
        $pathGambar1 = null;
        $pathGambar2 = null;
        $pathGambar3 = null;

        if ($request->hasFile('gambar1')) {
            $pathGambar1 = $this->prosesDanSimpanGambar($request->file('gambar1'), 'konten', 'konten');
             if (!$pathGambar1) { $kategori->delete(); return redirect()->back()->withErrors(['gambar1' => 'Gagal memproses gambar 1.'])->withInput(); }
        }
        if ($request->hasFile('gambar2')) {
            $pathGambar2 = $this->prosesDanSimpanGambar($request->file('gambar2'), 'konten', 'konten');
             if (!$pathGambar2) { $this->hapusGambarLama($pathGambar1); $kategori->delete(); return redirect()->back()->withErrors(['gambar2' => 'Gagal memproses gambar 2.'])->withInput(); }
        }
        if ($request->hasFile('gambar3')) {
            $pathGambar3 = $this->prosesDanSimpanGambar($request->file('gambar3'), 'konten', 'konten');
             if (!$pathGambar3) { $this->hapusGambarLama($pathGambar1); $this->hapusGambarLama($pathGambar2); $kategori->delete(); return redirect()->back()->withErrors(['gambar3' => 'Gagal memproses gambar 3.'])->withInput(); }
        }

        // Simpan ke tabel konten
        Konten::create([
            'id_user'             => Auth::id() ?? 1,
            'id_kategori_konten'  => $kategori->id_kategori_konten,
            'isi_konten1'        => $request->isi_konten1,
            'gambar1'             => $pathGambar1, // Path hasil Trait
            'isi_konten2'        => $request->isi_konten2,
            'gambar2'             => $pathGambar2, // Path hasil Trait
            'isi_konten3'        => $request->isi_konten3,
            'gambar3'             => $pathGambar3, // Path hasil Trait
        ]);

        return redirect()->route('admin.ppid.index') // Sesuaikan route
            ->with('success', 'Konten PPID Berhasil Ditambahkan!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Konten $kontenPpid)
    {
        // Tidak digunakan
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $kontenPpid = Konten::with('kategoriKonten')->findOrFail($id); // Eager load
        return view('Admin.ppid.kontenPpid.formEditKontenPpid', compact('kontenPpid'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        // 6. Sesuaikan Validasi Update
        $request->validate([
            'judul_konten'  => 'required|string|max:255',
            'icon_konten'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:1024',
            'isi_konten1'  => 'required|string',
            'gambar1'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'isi_konten2'  => 'nullable|string',
            'gambar2'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'isi_konten3'  => 'nullable|string',
            'gambar3'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
        ]);

        $konten = Konten::with('kategoriKonten')->findOrFail($id);
        $kategori = $konten->kategoriKonten;

        // --- Update Kategori Konten ---
        $kategoriData = [
            'judul_konten'  => $request->judul_konten,
            // 'menu_konten' => 'PPID' // Tidak perlu diupdate
        ];

        // 7. Proses Update Icon Konten dengan Trait
        if ($request->hasFile('icon_konten')) {
            $this->hapusGambarLama($kategori->icon_konten);
            $pathIconBaru = $this->prosesDanSimpanGambar($request->file('icon_konten'), 'icon', 'icon');
            if (!$pathIconBaru) {
                return redirect()->back()->withErrors(['icon_konten' => 'Gagal memproses ikon baru.'])->withInput();
            }
            $kategoriData['icon_konten'] = $pathIconBaru;
        }

        // Update slug HANYA jika judul berubah
        if ($request->judul_konten !== $kategori->judul_konten) {
            $kategoriData['slug'] = Str::slug($request->judul_konten);
        }

        $kategori->update($kategoriData);

        // --- Update Konten ---
        $kontenData = [
            'isi_konten1' => $request->isi_konten1,
            'isi_konten2' => $request->isi_konten2,
            'isi_konten3' => $request->isi_konten3,
        ];

        // 8. Proses Update Gambar Konten dengan Trait
        // Gambar 1
        if ($request->hasFile('gambar1')) {
            $this->hapusGambarLama($konten->gambar1);
            $pathGambar1Baru = $this->prosesDanSimpanGambar($request->file('gambar1'), 'konten', 'konten');
            if (!$pathGambar1Baru) return redirect()->back()->withErrors(['gambar1' => 'Gagal memproses gambar 1.'])->withInput();
            $kontenData['gambar1'] = $pathGambar1Baru;
        }

        // Gambar 2
        if ($request->hasFile('gambar2')) {
            $this->hapusGambarLama($konten->gambar2);
            $pathGambar2Baru = $this->prosesDanSimpanGambar($request->file('gambar2'), 'konten', 'konten');
            if (!$pathGambar2Baru) return redirect()->back()->withErrors(['gambar2' => 'Gagal memproses gambar 2.'])->withInput();
            $kontenData['gambar2'] = $pathGambar2Baru;
        } elseif ($request->has('hapus_gambar2') && $request->hapus_gambar2 == 1) {
            $this->hapusGambarLama($konten->gambar2);
            $kontenData['gambar2'] = null;
        }

        // Gambar 3
        if ($request->hasFile('gambar3')) {
            $this->hapusGambarLama($konten->gambar3);
             $pathGambar3Baru = $this->prosesDanSimpanGambar($request->file('gambar3'), 'konten', 'konten');
             if (!$pathGambar3Baru) return redirect()->back()->withErrors(['gambar3' => 'Gagal memproses gambar 3.'])->withInput();
            $kontenData['gambar3'] = $pathGambar3Baru;
        } elseif ($request->has('hapus_gambar3') && $request->hapus_gambar3 == 1) {
            $this->hapusGambarLama($konten->gambar3);
            $kontenData['gambar3'] = null;
        }

        $konten->update($kontenData);

        return redirect()->route('admin.ppid.index')->with('success', 'Konten PPID Berhasil Diperbarui!'); // Sesuaikan route
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $kontenPpid = Konten::with('kategoriKonten')->findOrFail($id); // Eager load

        // 9. Gunakan Trait untuk Hapus Gambar Konten
        $this->hapusGambarLama($kontenPpid->gambar1);
        $this->hapusGambarLama($kontenPpid->gambar2);
        $this->hapusGambarLama($kontenPpid->gambar3);

        // Handle related kategori_konten deletion
        $kategori = $kontenPpid->kategoriKonten;
        if ($kategori) {
             // Cek konten lain
            $otherKontenExists = Konten::where('id_kategori_konten', $kategori->id_kategori_konten)
                                        ->where('id_konten', '!=', $id)
                                        ->exists();

            if (!$otherKontenExists) {
                $this->hapusGambarLama($kategori->icon_konten); // Hapus icon
                $kategori->delete(); // Hapus kategori
            }
        }

        // Hapus record Konten
        $kontenPpid->delete();

        return redirect()->route('admin.ppid.index')->with('success', 'Konten PPID Berhasil Dihapus!'); // Sesuaikan route
    }
}
