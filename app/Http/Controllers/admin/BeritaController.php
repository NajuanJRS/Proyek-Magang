<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Berita;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $berita = Berita::when($search, function ($query, $search) {
            $query->where('judul', 'like', "%$search%")
                  ->orWhere('isi_berita', 'like', "%$search%");
        })->paginate(10);
        return view('Admin.redaksi.berita', compact('berita'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('Admin.redaksi.formBerita');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'judul' => 'required|min:5',
            'isi_berita1' => 'required|min:5',
            'gambar1' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gambar2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gambar3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tgl_posting' => 'nullable|date',
            'dibaca' => 'nullable',
        ]);

        $slug = Str::slug($request->judul, '-');

        // Upload gambar1 (wajib)
        $path1 = $request->file('gambar1')->store('berita', 'public');
        $fileGambar1 = basename($path1);

        // Upload gambar2 (opsional)
        $fileGambar2 = null;
        if ($request->hasFile('gambar2')) {
            $path2 = $request->file('gambar2')->store('berita', 'public');
            $fileGambar2 = basename($path2);
        }

        // Upload gambar3 (opsional)
        $fileGambar3 = null;
        if ($request->hasFile('gambar3')) {
            $path3 = $request->file('gambar3')->store('berita', 'public');
            $fileGambar3 = basename($path3);
        }

            $idUser = Auth::check() && Auth::user()->role === 'admin'
            ? 1
            : Auth::id();

            Berita::create([
                'id_user'    => $idUser,
                'judul'      => $request->judul,
                'slug'       => $slug,
                'isi_berita1' => $request->isi_berita1,
                'gambar1'     => $fileGambar1,
                'isi_berita2' => $request->isi_berita2,
                'gambar2'     => $fileGambar2,
                'isi_berita3' => $request->isi_berita3,
                'gambar3'     => $fileGambar3,
                'dibaca'     => 0,
                'tgl_posting'=> now(),
            ]);

        return redirect()->route('admin.berita.index')->with('success', 'Data Pejabat Berhasil Disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Berita $berita)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $berita = Berita::findOrFail($id);
        return view('Admin.redaksi.formEditBerita', compact('berita'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_user' => 'nullable|exists:user,id_user',
            'judul' => 'required|min:5',
            'isi_berita1' => 'required|min:5',
            'gambar1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'isi_berita2' => 'nullable|min:5',
            'gambar2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'isi_berita3' => 'nullable|min:5',
            'gambar3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tgl_posting' => 'nullable|date',
            'dibaca' => 'nullable',
        ]);
        
        $berita = Berita::findOrFail($id);
        $idUser = Auth::check() && Auth::user()->role === 'admin'
        ? 1
        : Auth::id();

        $data = [
            'id_user'    => $idUser,
            'judul'      => $request->judul,
            'isi_berita1' => $request->isi_berita1,
            'isi_berita2' => $request->isi_berita2,
            'isi_berita3' => $request->isi_berita3,
            'dibaca'     => 0,
            'tgl_posting'=> now(),
        ];

        // Handle Gambar 1
    if ($request->hasFile('gambar1')) {
        if ($berita->gambar1 && Storage::disk('public')->exists('berita/' . $berita->gambar1)) {
            Storage::disk('public')->delete('berita/' . $berita->gambar1);
        }
        $path1 = $request->file('gambar1')->store('berita', 'public');
        $data['gambar1'] = basename($path1);
    }

    // Handle Gambar 2
    if ($request->hasFile('gambar2')) {
        if ($berita->gambar2 && Storage::disk('public')->exists('berita/' . $berita->gambar2)) {
            Storage::disk('public')->delete('berita/' . $berita->gambar2);
        }
        $path2 = $request->file('gambar2')->store('berita', 'public');
        $data['gambar2'] = basename($path2);
    }

    // Handle Gambar 3
    if ($request->hasFile('gambar3')) {
        if ($berita->gambar3 && Storage::disk('public')->exists('berita/' . $berita->gambar3)) {
            Storage::disk('public')->delete('berita/' . $berita->gambar3);
        }
        $path3 = $request->file('gambar3')->store('berita', 'public');
        $data['gambar3'] = basename($path3);
    }
    if ($request->filled('judul')) {
            $data['slug'] = Str::slug($request->judul, '-');
    }
        $berita->update($data);

        return redirect()->route('admin.berita.index')->with('success', 'Data Berhasil Diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);
        $filePath = 'berita/' . $berita->gambar;

        if ($berita->gambar && Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }

        $berita->delete();
        return redirect()->route('admin.berita.index')->with('success', 'Data Berhasil Dihapus!');
    }
}
