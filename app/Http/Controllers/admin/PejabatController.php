<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Jabatan;
use App\Models\admin\Pejabat;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class pejabatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $pejabat = Pejabat::with('jabatan') // ambil relasi jabatan
            ->when($search, function ($query, $search) {
                $query->where('nama_pejabat', 'like', "%$search%")
                      ->orWhere('nip', 'like', "%$search%")
                      ->orWhere('jabatan', 'like', "%$search%");
            })
            ->paginate(10);

        return view('Admin.konfigurasiKonten.pejabat.pejabat', compact('pejabat'));
    }

    /**
     * Form tambah pejabat
     */
    public function create(Pejabat $pejabat): View
    {
        $jabatan = Jabatan::all(); // ambil semua jabatan
        return view('Admin.konfigurasiKonten.pejabat.formPejabat', compact('pejabat', 'jabatan'));
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
            'kata_sambutan' => 'nullable|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $path = $request->file('gambar')->store('pejabat', 'public');
        $filename = basename($path);

        Pejabat::create([
            'nip' => $request->nip,
            'nama_pejabat' => $request->nama_pejabat,
            'id_jabatan' => $request->id_jabatan,
            'kata_sambutan' => $request->kata_sambutan,
            'gambar' => $filename,
        ]);

        return redirect()->route('admin.pejabat.index')->with('success', 'Data Pejabat Berhasil Disimpan!');
    }

    /**
     * Form edit pejabat
     */
    public function edit(Pejabat $pejabat)
    {
        $jabatan = Jabatan::all();
        return view('Admin.konfigurasiKonten.pejabat.formEditPejabat', compact('pejabat', 'jabatan'));
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
            'kata_sambutan' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = [
            'nip' => $request->nip,
            'nama_pejabat' => $request->nama_pejabat,
            'kata_sambutan' => $request->kata_sambutan,
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

        return redirect()->route('admin.pejabat.index')->with('success', 'Data Pejabat Berhasil Diperbarui!');
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

        return redirect()->route('admin.pejabat.index')->with('success', 'Data Pejabat Berhasil Dihapus!');
    }
}
