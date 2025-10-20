<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\KategoriKonten;
use App\Models\admin\Konten;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PpidController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $kontenPpid = Konten::with('kategoriKonten')
            ->whereHas('kategoriKonten', function ($query) use ($search) {
                // Hanya ambil kategori dengan menu_konten = 'PPID'
                $query->where('menu_konten', 'PPID');

                // Jika ada pencarian, cari berdasarkan nama_kategori atau judul_konten
                if (!empty($search)) {
                    $query->where(function ($q) use ($search) {
                        $q->where('nama_kategori', 'like', "%$search%")
                        ->orWhere('judul_konten', 'like', "%$search%");
                    });
                }
            })
            ->paginate(10);

        return view('Admin.ppid.kontenPpid.kontenPpid', compact('kontenPpid'));
    }


    public function create(): View
    {
        return view('Admin.ppid.kontenPpid.formKontenPpid');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            // KategoriKonten
            'judul_konten'  => 'required|string|max:255',
            'icon_konten'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:500',

            // Konten
            'isi_konten1'  => 'required|string',
            'gambar1'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:500',
            'isi_konten2'  => 'nullable|string',
            'gambar2'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:500',
            'isi_konten3'  => 'nullable|string',
            'gambar3'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:500',
        ]);

        // Upload icon kategori (optional)
        $iconKonten = null;
        if ($request->hasFile('icon_konten')) {
            $iconPath = $request->file('icon_konten')->store('icon', 'public');
            $iconKonten = basename($iconPath);
        }

        // Simpan ke tabel kategori_konten
        $kategori = KategoriKonten::create([
            'menu_konten'     => 'PPID', // <-- otomatis diisi
            'judul_konten'  => $request->judul_konten,
            'icon_konten'   => $iconKonten,
            'slug'          => str()->slug($request->judul_konten),
        ]);

        // Upload gambar konten (opsional)
        $gambar1 = $request->hasFile('gambar1') ? basename($request->file('gambar1')->store('konten', 'public')) : null;
        $gambar2 = $request->hasFile('gambar2') ? basename($request->file('gambar2')->store('konten', 'public')) : null;
        $gambar3 = $request->hasFile('gambar3') ? basename($request->file('gambar3')->store('konten', 'public')) : null;

        // Simpan ke tabel konten
        Konten::create([
            'id_user'             => Auth::id() ?? 1,
            'id_kategori_konten'  => $kategori->id_kategori_konten,
            'isi_konten1'        => $request->isi_konten1,
            'gambar1'             => $gambar1,
            'isi_konten2'        => $request->isi_konten2,
            'gambar2'             => $gambar2,
            'isi_konten3'        => $request->isi_konten3,
            'gambar3'             => $gambar3,
        ]);

        return redirect()->route('admin.ppid.index')
            ->with('success', 'Konten PPID Berhasil Ditambahkan!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Konten $kontenPpid)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $kontenPpid = Konten::findOrFail($id);
        return view('Admin.ppid.kontenPpid.formEditKontenPpid', compact('kontenPpid'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            // KategoriKonten
            'judul_konten'  => 'required|string|max:255',
            'icon_konten'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:500',

            // Konten
            'isi_konten1'  => 'required|string',
            'gambar1'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:500',
            'isi_konten2'  => 'nullable|string',
            'gambar2'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:500',
            'isi_konten3'  => 'nullable|string',
            'gambar3'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:500',
        ]);

        // Ambil data konten berdasarkan ID
        $konten = Konten::with('kategoriKonten')->findOrFail($id);

        // ========================
        // UPDATE TABEL KATEGORI_KONTEN
        // ========================
        $kategori = $konten->kategoriKonten;

        // Handle upload icon baru (jika ada)
        $iconKonten = $kategori->icon_konten ?? null;
        if ($request->hasFile('icon_konten')) {
            // Hapus file lama jika ada
            if ($iconKonten && Storage::disk('public')->exists('icon/' . $iconKonten)) {
                Storage::disk('public')->delete('icon/' . $iconKonten);
            }

            $iconPath = $request->file('icon_konten')->store('icon', 'public');
            $iconKonten = basename($iconPath);
        }

        // Update data kategori
        $kategori->update([
            'menu_konten'   => 'PPID', // tetap otomatis "PPID"
            'judul_konten'  => $request->judul_konten,
            'icon_konten'   => $iconKonten,
            'slug'          => str()->slug($request->judul_konten),
        ]);

        // ========================
        // UPDATE TABEL KONTEN
        // ========================
        $idUser = Auth::check() && Auth::user()->role === 'admin' ? 1 : Auth::id();

        // Handle gambar baru jika di-upload
        $gambar1 = $konten->gambar1;
        $gambar2 = $konten->gambar2;
        $gambar3 = $konten->gambar3;

        // Gambar 1
        if ($request->hasFile('gambar1')) {
            if ($gambar1 && Storage::disk('public')->exists('konten/' . $gambar1)) {
                Storage::disk('public')->delete('konten/' . $gambar1);
            }
            $gambar1 = basename($request->file('gambar1')->store('konten', 'public'));
        }

        // Gambar 2
        if ($request->hasFile('gambar2')) {
            if ($gambar2 && Storage::disk('public')->exists('konten/' . $gambar2)) {
                Storage::disk('public')->delete('konten/' . $gambar2);
            }
            $gambar2 = basename($request->file('gambar2')->store('konten', 'public'));
        }

        // Gambar 3
        if ($request->hasFile('gambar3')) {
            if ($gambar3 && Storage::disk('public')->exists('konten/' . $gambar3)) {
                Storage::disk('public')->delete('konten/' . $gambar3);
            }
            $gambar3 = basename($request->file('gambar3')->store('konten', 'public'));
        }

        if ($request->has('hapus_gambar2') && $request->hapus_gambar2 == 1) {
        if ($konten->gambar2 && Storage::disk('public')->exists('konten/'.$konten->gambar2)) {
            Storage::disk('public')->delete('konten/'.$konten->gambar2);
        }
        $konten->gambar2 = null;
        }

        if ($request->has('hapus_gambar3') && $request->hapus_gambar3 == 1) {
            if ($konten->gambar3 && Storage::disk('public')->exists('konten/'.$konten->gambar3)) {
                Storage::disk('public')->delete('konten/'.$konten->gambar3);
            }
            $konten->gambar3 = null;
        }

        // Update konten
        $konten->update([
            'id_user'            => $idUser,
            'id_kategori_konten' => $kategori->id_kategori_konten,
            'isi_konten1'       => $request->isi_konten1,
            'gambar1'            => $gambar1,
            'isi_konten2'       => $request->isi_konten2,
            'gambar2'            => $gambar2,
            'isi_konten3'       => $request->isi_konten3,
            'gambar3'            => $gambar3,
        ]);

        return redirect()->route('admin.ppid.index')->with('success', 'Konten PPID Berhasil Diperbarui!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $kontenPpid = Konten::findOrFail($id);

        // Paths for konten files
        $filePath2 = 'konten/' . $kontenPpid->gambar1;
        $filePath3 = 'konten/' . $kontenPpid->gambar2;
        $filePath4 = 'konten/' . $kontenPpid->gambar3;

        // Delete konten images if exist
        if ($kontenPpid->gambar1 && Storage::disk('public')->exists($filePath2)) {
            Storage::disk('public')->delete($filePath2);
        }
        if ($kontenPpid->gambar2 && Storage::disk('public')->exists($filePath3)) {
            Storage::disk('public')->delete($filePath3);
        }
        if ($kontenPpid->gambar3 && Storage::disk('public')->exists($filePath4)) {
            Storage::disk('public')->delete($filePath4);
        }

        // Handle related kategori_konten deletion
        $kategori = KategoriKonten::find($kontenPpid->id_kategori_konten);
        if ($kategori) {
            // delete kategori icon if present
            if ($kategori->icon_konten && Storage::disk('public')->exists('icon/' . $kategori->icon_konten)) {
                Storage::disk('public')->delete('icon/' . $kategori->icon_konten);
            }

            // Only delete kategori if no other konten reference it (prevent accidental removal)
            $otherKontenCount = Konten::where('id_kategori_konten', $kategori->id_kategori_konten)
                ->where('id_kategori_konten', '!=', $kontenPpid->id_kategori_konten)
                ->count();

            if ($otherKontenCount === 0) {
                $kategori->delete();
            }
        }

        // Finally delete the konten record
        $kontenPpid->delete();

        return redirect()->route('admin.ppid.index')->with('success', 'Konten PPID Berhasil Dihapus!');
    }
}
