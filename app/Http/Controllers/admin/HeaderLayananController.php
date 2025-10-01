<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Header;
use App\Models\admin\KategoriHeader;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HeaderLayananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $headerLayanan = Header::when($search, function ($query, $search) {
            $query->where('nama_kategori', 'like', "%$search%")
                  ->orWhere('headline', 'like', "%$search%")
                  ->orWhere('sub_heading', 'like', "%$search%");
        })->paginate(10);

        return view('Admin.layanan.headerLayanan.headerLayanan', compact('headerLayanan'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Header $headerLayanan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Header $headerLayanan)
    {
        $headerLayanan = Header::findOrFail($headerLayanan->id_header);
        $kategoriHeader = KategoriHeader::all();
        return view('Admin.layanan.headerLayanan.formEditHeaderLayanan', compact('headerLayanan', 'kategoriHeader'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Header $headerLayanan)
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
            $oldFilePath = 'header/' . $headerLayanan->gambar;
            if ($headerLayanan->gambar && Storage::disk('public')->exists($oldFilePath)) {
                Storage::disk('public')->delete($oldFilePath);
            }

            // Upload gambar baru
            $path = $request->file('gambar')->store('header', 'public');
            $data['gambar'] = basename($path);
        }

        $headerLayanan->update($data);

        return redirect()->route('admin.headerLayanan.index')->with('success', 'Data Heading Berhasil Diperbarui!');
    }
}
