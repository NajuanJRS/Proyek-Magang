<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\KategoriHeader;
use App\Models\admin\Header;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $slider = Header::when($search, function ($query, $search) {
            $query->where('nama_kategori', 'like', "%$search%")
                  ->orWhere('keterangan', 'like', "%$search%");
        })->paginate(10);

        return view('Admin.beranda.slider.slider', compact('slider'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Header $slider): View
    {
        $kategoriHeader = KategoriHeader::all();
        return view('Admin.beranda.slider.formSlider', compact('kategoriHeader'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'nullable|exists:users,id_user',
            'headline' => 'required|min:5', // Sesuaikan dengan view
            'sub_heading' => 'required|min:5', // Sesuaikan dengan view
            'gambar'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Praktik terbaik untuk upload file
        $path = $request->file('gambar')->store('header', 'public');
        $filename = basename($path);

        $idUser = Auth::check() && Auth::user()->role === 'admin'
        ? 1
        : Auth::id();

        Header::create([
            'id_user'    => $idUser,
            'id_kategori_header' => '1',
            'headline' => $request->headline,
            'sub_heading' => $request->sub_heading,
            'gambar'     => $filename,
        ]);

        return redirect()->route('admin.slider.index')->with('success', 'Hero Section Berhasil Ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Header $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $slider = Header::findOrFail($id);
        $kategoriHeader = KategoriHeader::all();
        return view('Admin.beranda.slider.formEditSlider', compact('slider', 'kategoriHeader'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Cari record secara eksplisit agar tidak bergantung pada route-model binding
        $slider = Header::findOrFail($id);

        $request->validate([
            'id_user'     => 'nullable|exists:users,id', // perbaiki nama tabel/kolom
            'headline'    => 'nullable|min:5',
            'sub_heading' => 'nullable|min:5',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // tentukan id_user (sama seperti sebelumnya)
        $idUser = Auth::check() && Auth::user()->role === 'admin' ? 1 : Auth::id();

        $data = [
            'id_user'     => $idUser,
            'headline'    => $request->input('headline'),
            'sub_heading' => $request->input('sub_heading'),
        ];

        if ($request->hasFile('gambar')) {
            // hapus gambar lama jika ada
            if (!empty($slider->gambar) && Storage::disk('public')->exists('header/' . $slider->gambar)) {
                Storage::disk('public')->delete('header/' . $slider->gambar);
            }
            // upload gambar baru
            $path = $request->file('gambar')->store('header', 'public');
            $data['gambar'] = basename($path);
        }

        // Gunakan fill + save untuk menghindari masalah mass-assignment jika model belum diatur
        $slider->fill($data);
        $slider->save();

        return redirect()->route('admin.slider.index')->with('success', 'Heading Berita Berhasil Diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Header $slider)
    {
        $filePath = 'header/' . $slider->gambar;

        if ($slider->gambar && Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }

        // Hapus data dari database
        $slider->delete();

        return redirect()->route('admin.slider.index')->with('success', 'Hero Section Berhasil Dihapus!');
    }
}
