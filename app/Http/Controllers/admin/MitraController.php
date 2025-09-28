<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Mitra;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MitraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $mitra = Mitra::when($search, function ($query, $search) {
            $query->where('nama_kategori', 'like', "%$search%")
                  ->orWhere('keterangan', 'like', "%$search%");
        })->paginate(10);

        return view('Admin.beranda.mitra.mitra', compact('mitra'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $mitra = Mitra::all();
        return view('Admin.beranda.mitra.formMitra', compact('mitra'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'nullable|exists:user,id_user',
            'nama_mitra' => 'required',
            'link_mitra' => 'nullable|url',
            'gambar'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Praktik terbaik untuk upload file
        $path = $request->file('gambar')->store('mitra', 'public');
        $filename = basename($path);

        $idUser = Auth::check() && Auth::user()->role === 'admin'
        ? 1
        : Auth::id();

        Mitra::create([
            'id_user'    => $idUser,
            'nama_mitra' => $request->nama_mitra,
            'link_mitra' => $request->link_mitra,
            'gambar'     => $filename,
        ]);

        return redirect()->route('admin.mitra.index')->with('success', 'Data Berhasil Disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mitra $mitra)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mitra $mitra)
    {
        $mitra = Mitra::findOrFail($mitra->id_mitra);
        return view('Admin.beranda.mitra.formEditMitra', compact('mitra'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mitra $mitra)
    {
        $request->validate([
            'id_user' => 'nullable|exists:user,id_user',
            'nama_mitra' => 'nullable|min:5',
            'link_mitra' => 'nullable|min:5',
            'gambar_slider' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $idUser = Auth::check() && Auth::user()->role === 'admin'
        ? 1
        : Auth::id();

        $data = [
            'id_user'    => $idUser,
            'id_kategori_header' => $request->id_kategori_header,
            'keterangan' => $request->keterangan,
        ];

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            $oldFilePath = 'mitra/' . $mitra->gambar;
            if ($mitra->gambar && Storage::disk('public')->exists($oldFilePath)) {
                Storage::disk('public')->delete($oldFilePath);
            }

            // Upload gambar baru
            $path = $request->file('gambar')->store('mitra', 'public');
            $data['gambar'] = basename($path);
        }

        $mitra->update($data);

        return redirect()->route('admin.mitra.index')->with('success', 'Data Slider Berhasil Diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mitra $mitra)
    {
        $filePath = 'mitra/' . $mitra->gambar;

        if ($mitra->gambar && Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }

        // Hapus data dari database
        $mitra->delete();

        return redirect()->route('admin.mitra.index')->with('success', 'Data Berhasil Dihapus!');
    }
}
