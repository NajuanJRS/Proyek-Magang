<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Header;
use App\Models\admin\Jabatan;
use App\Models\admin\KategoriHeader;
use App\Models\admin\Pejabat;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PejabatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Data pejabat
        $pejabat = Pejabat::with('jabatan')
            ->when($search, function ($query, $search) {
                $query->where('nama_pejabat', 'like', "%$search%")
                    ->orWhere('nip', 'like', "%$search%");
            })
            ->paginate(10);

        // Data headerKartu
        $headerKartu = Header::with('kategoriHeader')
            ->when($search, function ($query, $search) {
                $query->where('headline', 'like', "%$search%")
                    ->orWhere('sub_heading', 'like', "%$search%");
            })
            ->paginate(10);

        return view('Admin.profile.pejabat.pejabat', compact('pejabat', 'headerKartu'));
    }

    /**
     * Form tambah pejabat
     */
    public function create(Pejabat $pejabat): View
    {
        $jabatan = Jabatan::all(); // ambil semua jabatan
        return view('Admin.profile.pejabat.formPejabat', compact('pejabat', 'jabatan'));
    }

    /**
     * Simpan data pejabat baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|min:5|max:18',
            'nama_pejabat' => 'required|min:5|max:100',
            'id_jabatan' => 'required|exists:jabatan,id_jabatan',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $idUser = Auth::check() && Auth::user()->role === 'admin'
        ? 1
        : Auth::id();

        $path = $request->file('gambar')->store('pejabat', 'public');
        $filename = basename($path);

        Pejabat::create([
            'id_user' => $idUser,
            'nip' => $request->nip,
            'nama_pejabat' => $request->nama_pejabat,
            'id_jabatan' => $request->id_jabatan,
            'gambar' => $filename,
        ]);

        return redirect()->route('admin.pejabat.index')->with('success', 'Informasi Pejabat Berhasil Ditambahkan!');
    }

    /**
     * Form edit pejabat
     */
    public function edit(Pejabat $pejabat)
    {
        $jabatan = Jabatan::all();
        return view('Admin.profile.pejabat.formEditPejabat', compact('pejabat', 'jabatan'));
    }


    public function editHeader($id)
    {
        $headerKartu = Header::findOrFail($id);
        $kategoriHeader = KategoriHeader::all();

        return view('Admin.profile.pejabat.formEditKartuPejabat', compact('headerKartu', 'kategoriHeader'));
}

    /**
     * Update data pejabat
     */
    public function update(Request $request, Pejabat $pejabat)
    {
        $request->validate([
            'nip' => 'required|min:5|max:18',
            'nama_pejabat' => 'required|min:5|max:100',
            'id_jabatan' => 'required|exists:jabatan,id_jabatan',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $idUser = Auth::check() && Auth::user()->role === 'admin'
        ? 1
        : Auth::id();

        $data = [
            'id_user' => $idUser,
            'nip' => $request->nip,
            'nama_pejabat' => $request->nama_pejabat,
            'id_jabatan' => $request->id_jabatan,
        ];

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            $oldFilePath = 'pejabat/' . $pejabat->gambar;
            if ($pejabat->gambar && Storage::disk('public')->exists($oldFilePath)) {
                Storage::disk('public')->delete($oldFilePath);
            }

            // Upload gambar baru
            $path = $request->file('gambar')->store('pejabat', 'public');
            $data['gambar'] = basename($path);
        }

        $pejabat->update($data);

        return redirect()->route('admin.pejabat.index')->with('success', 'Informasi Pejabat Berhasil Diperbarui!');
    }

    public function updateHeader(Request $request, $id)
    {
        $headerKartu = Header::findOrFail($id);

        $request->validate([
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Jika ada upload gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama kalau ada
            $oldFilePath = 'header/' . $headerKartu->gambar;
            if ($headerKartu->gambar && Storage::disk('public')->exists($oldFilePath)) {
                Storage::disk('public')->delete($oldFilePath);
            }

            // Upload gambar baru
            $path = $request->file('gambar')->store('header', 'public');
            $data['gambar'] = basename($path);
        }

        $data = [
            'gambar' => $headerKartu->gambar, // Tetap gunakan gambar lama sebagai default
        ];
        
        $headerKartu->update($data);

        return redirect()->route('admin.pejabat.index')->with('success', 'Background Kepala Pejabat Berhasil Diperbarui!');
    }

    /**
     * Hapus data pejabat
     */
    public function destroy(Pejabat $pejabat)
    {
        $filePath = 'pejabat/' . $pejabat->gambar;

        if ($pejabat->gambar && Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }

        $pejabat->delete();

        return redirect()->route('admin.pejabat.index')->with('success', 'Informasi Pejabat Berhasil Dihapus!');
    }
}
