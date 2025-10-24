<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Mitra;
use App\Traits\ManajemenGambarTrait; // 1. Panggil Trait
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse; // Tambahkan RedirectResponse
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Storage; // Tidak perlu lagi

class MitraController extends Controller
{
    // 2. Gunakan Trait
    use ManajemenGambarTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        // Sesuaikan pencarian, 'nama_kategori' dan 'keterangan' tidak ada di tabel mitra
        $mitra = Mitra::when($search, function ($query, $search) {
            $query->where('nama_mitra', 'like', "%$search%");
               // ->orWhere('link_mitra', 'like', "%$search%"); // Mungkin ingin mencari link juga?
        })->paginate(10);

        return view('Admin.beranda.mitra.mitra', compact('mitra'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        // Tidak perlu mengambil semua mitra saat membuat baru
        // $mitra = Mitra::all();
        return view('Admin.beranda.mitra.formMitra');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse // Tambah return type
    {
        // 3. Sesuaikan Validasi
        $request->validate([
            // 'id_user' => 'nullable|exists:users,id_user', // Otomatis
            'nama_mitra' => 'required|string|max:100', // Tambah max length
            'link_mitra' => 'nullable|url|max:255', // Validasi URL
            'gambar'     => 'required|image|mimes:jpeg,png,jpg,svg,webp|max:1024', // Max 1MB untuk logo mitra
        ]);

        $idUser = Auth::check() && Auth::user()->role === 'admin'
            ? 1
            : Auth::id();

        // 4. Proses Gambar Mitra dengan Trait
        $pathGambar = null;
        if ($request->hasFile('gambar')) {
            $pathGambar = $this->prosesDanSimpanGambar(
                $request->file('gambar'),
                'mitra',    // Tipe gambar
                'mitra'     // Folder tujuan
            );
            if (!$pathGambar) {
                 return redirect()->back()->withErrors(['gambar' => 'Gagal memproses gambar mitra.'])->withInput();
            }
        } else {
             return redirect()->back()->withErrors(['gambar' => 'Gambar mitra wajib diunggah.'])->withInput();
        }


        // 5. Gunakan path dari Trait
        Mitra::create([
            'id_user'    => $idUser,
            'nama_mitra' => $request->nama_mitra,
            'link_mitra' => $request->link_mitra,
            'gambar'     => $pathGambar, // Path hasil Trait
        ]);

        return redirect()->route('admin.mitra.index')->with('success', 'Mitra Berhasil Ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mitra $mitra)
    {
        // Tidak digunakan di admin
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mitra $mitra): View // Tambah View return type
    {
        // FindOrFail tidak perlu jika menggunakan Route Model Binding
        // $mitra = Mitra::findOrFail($mitra->id_mitra);
        return view('Admin.beranda.mitra.formEditMitra', compact('mitra'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mitra $mitra): RedirectResponse // Tambah return type
    {
        // 6. Sesuaikan Validasi Update
        $request->validate([
            // 'id_user' => 'nullable|exists:users,id_user',
            'nama_mitra' => 'required|string|max:100', // Nama mitra wajib saat update
            'link_mitra' => 'nullable|url|max:255',
            'gambar'     => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:1024', // Ganti 'gambar_slider' -> 'gambar', max 1MB
        ]);

        $idUser = Auth::check() && Auth::user()->role === 'admin'
            ? 1
            : Auth::id();

        // Hapus field yang tidak ada di tabel 'mitra'
        $data = [
            'id_user'    => $idUser,
            'nama_mitra' => $request->nama_mitra,
            'link_mitra' => $request->link_mitra,
            // 'id_kategori_header' => $request->id_kategori_header, // Hapus
            // 'keterangan' => $request->keterangan, // Hapus
        ];

        // 7. Proses Update Gambar Mitra dengan Trait
        if ($request->hasFile('gambar')) {
            $this->hapusGambarLama($mitra->gambar); // Hapus gambar lama
            $pathGambarBaru = $this->prosesDanSimpanGambar($request->file('gambar'), 'mitra', 'mitra');
            if (!$pathGambarBaru) {
                return redirect()->back()->withErrors(['gambar' => 'Gagal memproses gambar mitra baru.'])->withInput();
            }
            $data['gambar'] = $pathGambarBaru; // Gunakan path baru
        }

        $mitra->update($data);

        return redirect()->route('admin.mitra.index')->with('success', 'Mitra Berhasil Diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mitra $mitra): RedirectResponse // Tambah return type
    {
        // 8. Gunakan Trait untuk Hapus Gambar Mitra
        $this->hapusGambarLama($mitra->gambar);

        // Hapus data dari database
        $mitra->delete();

        return redirect()->route('admin.mitra.index')->with('success', 'Mitra Berhasil Dihapus!');
    }
}
