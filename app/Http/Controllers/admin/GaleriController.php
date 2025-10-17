<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GaleriController extends Controller
{
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
    public function create(Galeri $galeri): View
    {
        return view('Admin.profile.galeri.formgaleri', compact('galeri'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'nullable|exists:users,id_user',
            'judul' => 'required|min:5', // Sesuaikan dengan view
            'gambar'     => 'required|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
            'tanggal_upload' => 'nullable|date', // Sesuaikan dengan view
        ]);

        // Praktik terbaik untuk upload file
        $path = $request->file('gambar')->store('galeri', 'public');
        $filename = basename($path);

        $idUser = Auth::check() && Auth::user()->role === 'Admin'
        ? 1
        : Auth::id();

        Galeri::create([
            'id_user'    => $idUser,
            'judul' => $request->judul,
            'gambar'     => $filename,
            'tanggal_upload' => $request->tanggal_upload ?? now(),
        ]);

        return redirect()->route('admin.galeri.index')->with('success', 'Galeri Berhasil Ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Galeri $galeri)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Galeri $galeri)
    {
        $galeri = Galeri::findOrFail($galeri->id_galeri);
        return view('Admin.profile.galeri.formEditGaleri', compact('galeri'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Galeri $galeri)
    {
        $request->validate([
            'id_user' => 'nullable|exists:users,id_user',
            'judul' => 'nullable|min:5',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
            'tanggal_upload' => 'nullable|date',
        ]);

        $idUser = Auth::check() && Auth::user()->role === 'Admin'
        ? 1
        : Auth::id();

        $data = [
            'id_user'    => $idUser,
            'judul' => $request->judul,
        ];

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            $oldFilePath = 'galeri/' . $galeri->gambar;
            if ($galeri->gambar && Storage::disk('public')->exists($oldFilePath)) {
                Storage::disk('public')->delete($oldFilePath);
            }

            // Upload gambar baru
            $path = $request->file('gambar')->store('galeri', 'public');
            $data['gambar'] = basename($path);
        }

        $galeri->update($data);

        return redirect()->route('admin.galeri.index')->with('success', 'Galeri Berhasil Diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Galeri $galeri)
    {
        $filePath = 'galeri/' . $galeri->gambar;

        if ($galeri->gambar && Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }

        // Hapus data dari database
        $galeri->delete();

        return redirect()->route('admin.galeri.index')->with('success', 'Galeri Berhasil Dihapus!');
    }
}
