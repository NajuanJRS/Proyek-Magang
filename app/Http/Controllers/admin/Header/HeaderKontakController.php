<?php

namespace App\Http\Controllers\admin\Header;

use App\Http\Controllers\Controller;
use App\Models\admin\Header;
use App\Models\admin\KategoriHeader;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HeaderKontakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $headerKontak = Header::when($search, function ($query, $search) {
            $query->where('nama_kategori', 'like', "%$search%")
                  ->orWhere('headline', 'like', "%$search%")
                  ->orWhere('sub_heading', 'like', "%$search%");
        })->paginate(10);

        return view('Admin.kontak.headerKontak.headerKontak', compact('headerKontak'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Header $headerKontak)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Header $headerKontak)
    {
        $headerKontak = Header::findOrFail($headerKontak->id_header);
        $kategoriHeader = KategoriHeader::all();
        return view('Admin.kontak.headerKontak.formEditHeaderKontak', compact('headerKontak', 'kategoriHeader'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Header $headerKontak)
    {
        $request->validate([
            'id_user' => 'nullable|exists:user,id_user',
            'headline' => 'nullable|min:5',
            'sub_heading' => 'nullable|min:5',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $idUser = Auth::check() && Auth::user()->role === 'admin'
        ? 1
        : Auth::id();

        $data = [
            'id_user'    => $idUser,
            'headline' => $request->headline,
            'sub_heading' => $request->sub_heading,
        ];

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            $oldFilePath = 'header/' . $headerKontak->gambar;
            if ($headerKontak->gambar && Storage::disk('public')->exists($oldFilePath)) {
                Storage::disk('public')->delete($oldFilePath);
            }

            // Upload gambar baru
            $path = $request->file('gambar')->store('header', 'public');
            $data['gambar'] = basename($path);
        }

        $headerKontak->update($data);

        return redirect()->route('admin.headerKontak.index')->with('success', 'Data Heading Berhasil Diperbarui!');
    }
}
