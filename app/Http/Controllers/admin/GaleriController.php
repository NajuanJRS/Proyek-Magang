<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Galeri;
use App\Traits\ManajemenGambarTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

class GaleriController extends Controller
{
    use ManajemenGambarTrait;

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
    public function create(): View
    {
        return view('Admin.profile.galeri.formgaleri');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $messages = [
            'judul.required' => 'Judul wajib diisi.',
            'gambar.required' => 'Gambar wajib diisi.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, svg, atau webp.',
            'gambar.max' => 'Ukuran gambar maksimal :max KB.',
        ];

        $validator = Validator::make($request->all(),[
            'judul' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,svg,webp|max:5120',
        ], $messages);

        if ($validator->fails()) {
        return back()
        ->withErrors($validator)
        ->withInput();
        }

        try {
        $pathGambar = null;
        if ($request->hasFile('gambar')) {
            $pathGambar = $this->prosesDanSimpanGambar(
                $request->file('gambar'),
                'galeri',
                'galeri'
            );
        }

        if (!$pathGambar && $request->hasFile('gambar')) {
             return redirect()->back()->withErrors(['gambar' => 'Gagal memproses gambar.'])->withInput();
        }

        $idUser = Auth::check() && Auth::user()->role === 'admin'
            ? 1
            : Auth::id();

        Galeri::create([
            'id_user'    => $idUser,
            'judul' => $request->judul,
            'gambar'     => $pathGambar,
            'tanggal_upload' => now(),
        ]);

        return redirect()->route('admin.galeri.index')->with('success', 'Galeri Berhasil Ditambahkan!');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['general' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Galeri $galeri)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Galeri $galeri): View
    {
        return view('Admin.profile.galeri.formEditGaleri', compact('galeri'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Galeri $galeri): RedirectResponse
    {
        $messages = [
            'judul.required' => 'Judul wajib diisi.',
            'gambar.required' => 'Gambar wajib diisi.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, svg, atau webp.',
            'gambar.max' => 'Ukuran gambar maksimal :max KB.',
        ];

        $validator = Validator::make($request->all(),[
            'judul' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:5120',
        ], $messages);

        if ($validator->fails()) {
        return back()
        ->withErrors($validator)
        ->withInput();
        }

        try {
        $idUser = Auth::check() && Auth::user()->role === 'admin'
            ? 1
            : Auth::id();

        $data = [
            'id_user'    => $idUser,
            'judul' => $request->judul,
        ];

        if ($request->hasFile('gambar')) {
            $this->hapusGambarLama($galeri->gambar);
            $pathGambarBaru = $this->prosesDanSimpanGambar($request->file('gambar'), 'galeri', 'galeri');

             if (!$pathGambarBaru) {
                return redirect()->back()->withErrors(['gambar' => 'Gagal memproses gambar baru.'])->withInput();
            }
            $data['gambar'] = $pathGambarBaru;
        }

        $galeri->update($data);

        return redirect()->route('admin.galeri.index')->with('success', 'Galeri Berhasil Diperbarui!');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['general' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Galeri $galeri): RedirectResponse
    {
        $this->hapusGambarLama($galeri->gambar);

        $galeri->delete();

        return redirect()->route('admin.galeri.index')->with('success', 'Galeri Berhasil Dihapus!');
    }
}
