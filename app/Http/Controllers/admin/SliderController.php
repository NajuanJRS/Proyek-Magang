<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
// use App\Models\admin\KategoriHeader; // Tidak perlu
use App\Models\admin\Header;
use App\Traits\ManajemenGambarTrait; // 1. Panggil Trait
use Illuminate\Contracts\View\View; // Import View
use Illuminate\Http\RedirectResponse; // Import RedirectResponse
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
// use Illuminate\Support\Facades\Storage; // Tidak perlu lagi

class SliderController extends Controller
{
    // 2. Gunakan Trait
    use ManajemenGambarTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        // Filter hanya untuk id_kategori_header = 1 (Hero Section)
        $slider = Header::where('id_kategori_header', 1)
            ->when($search, function ($query, $search) {
                $query->where('headline', 'like', "%{$search}%")
                      ->orWhere('sub_heading', 'like', "%{$search}%");
            })->paginate(10);

        return view('Admin.beranda.slider.slider', compact('slider'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('Admin.beranda.slider.formSlider');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // 3. Sesuaikan Validasi
        $request->validate([
            'headline' => 'required|string|min:5|max:100',
            'sub_heading' => 'required|string|min:5|max:255',
            'gambar'     => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120', // Naikkan max 5MB
        ]);

        $idUser = Auth::check() && Auth::user()->role === 'admin'
            ? 1
            : Auth::id();

        // 4. Proses Gambar Header dengan Trait (tipe 'slider_header')
        $pathGambar = null;
        if ($request->hasFile('gambar')) {
            $pathGambar = $this->prosesDanSimpanGambar(
                $request->file('gambar'),
                'slider_header', // <-- Gunakan tipe spesifik untuk slider
                'header'         // Folder tujuan tetap 'header'
            );
            if (!$pathGambar) {
                 return redirect()->back()->withErrors(['gambar' => 'Gagal memproses gambar slider.'])->withInput();
            }
        } else {
             return redirect()->back()->withErrors(['gambar' => 'Gambar slider wajib diunggah.'])->withInput();
        }

        // 5. Gunakan path dari Trait
        Header::create([
            'id_user'    => $idUser,
            'id_kategori_header' => '1', // Selalu '1' untuk Hero Section
            'headline' => $request->headline,
            'sub_heading' => $request->sub_heading,
            'gambar'     => $pathGambar, // Path hasil Trait
        ]);

        Cache::forget('beranda_hero_slides');

        return redirect()->route('admin.slider.index')->with('success', 'Hero Section Berhasil Ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Header $slider)
    {
        // Tidak digunakan di admin
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $slider = Header::where('id_kategori_header', 1)->findOrFail($id); // Pastikan hanya edit slider
        return view('Admin.beranda.slider.formEditSlider', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $slider = Header::where('id_kategori_header', 1)->findOrFail($id); // Pastikan hanya update slider

        // 6. Sesuaikan Validasi Update
        $request->validate([
            'headline' => 'required|string|min:5|max:100',
            'sub_heading' => 'required|string|min:5|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120', // Naikkan max 5MB
        ]);

        $idUser = Auth::check() && Auth::user()->role === 'admin'
            ? 1
            : Auth::id();

        $data = [
            'id_user'    => $idUser,
            'headline' => $request->headline,
            'sub_heading' => $request->sub_heading,
        ];

        // 7. Proses Update Gambar Header dengan Trait (tipe 'slider_header')
        if ($request->hasFile('gambar')) {
            $this->hapusGambarLama($slider->gambar); // Hapus gambar lama
            $pathGambarBaru = $this->prosesDanSimpanGambar(
                $request->file('gambar'),
                'slider_header', // <-- Gunakan tipe spesifik untuk slider
                'header'         // Folder tujuan tetap 'header'
            );
             if (!$pathGambarBaru) {
                 return redirect()->back()->withErrors(['gambar' => 'Gagal memproses gambar slider baru.'])->withInput();
            }
            $data['gambar'] = $pathGambarBaru; // Gunakan path baru
        }
        // Jika tidak ada gambar baru, $data['gambar'] tidak diset, gambar lama tetap

        $slider->update($data);

        Cache::forget('beranda_hero_slides');

        return redirect()->route('admin.slider.index')->with('success', 'Hero Section Berhasil Diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $slider = Header::where('id_kategori_header', 1)->findOrFail($id); // Pastikan hanya hapus slider

        // 8. Gunakan Trait untuk Hapus Gambar Header
        $this->hapusGambarLama($slider->gambar);

        // Hapus data dari database
        $slider->delete();

        Cache::forget('beranda_hero_slides');

        return redirect()->route('admin.slider.index')->with('success', 'Hero Section Berhasil Dihapus!');
    }
}

