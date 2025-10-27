<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\KategoriFile;
use App\Traits\ManajemenGambarTrait; // 1. Panggil Trait
use Illuminate\Contracts\View\View; // Import View
use Illuminate\Http\RedirectResponse; // Import RedirectResponse
use Illuminate\Http\Request;
use Illuminate\Support\Str;
// use Illuminate\Support\Facades\Storage; // Tidak perlu lagi jika hanya pakai Trait

class DownloadController extends Controller
{
    // 2. Gunakan Trait
    use ManajemenGambarTrait;

    public function index(): View // Tambah View return type
    {
        $kartuDownload = KategoriFile::paginate(15);
        return view('Admin.download.kontenDownload.kontenDownload', compact('kartuDownload'));
    }

    public function create(): View // Tambah View return type
    {
        return view('Admin.download.kontenDownload.formKontenDownload');
    }

    public function store(Request $request): RedirectResponse // Hapus param $kategoriFile, tambah RedirectResponse
    {
        // 3. Sesuaikan Validasi Icon
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:1024', // Max 1MB
            'halaman_induk' => 'required|string|max:255', // Buat required agar jelas
        ]);

        // 4. Proses Icon dengan Trait
        $pathIcon = null;
        if ($request->hasFile('icon')) {
            $pathIcon = $this->prosesDanSimpanGambar(
                $request->file('icon'),
                'icon', // Tipe gambar
                'icon'  // Folder tujuan
            );
             if (!$pathIcon && $request->file('icon')->isValid()) { // Cek jika file valid tapi proses gagal
                 return redirect()->back()->withErrors(['icon' => 'Gagal memproses ikon.'])->withInput();
            }
        }
        // Jika icon nullable dan tidak diupload, $pathIcon akan tetap null

        // 5. Gunakan path dari Trait
        KategoriFile::create([
            'nama_kategori' => $request->nama_kategori,
            'slug' => Str::slug($request->nama_kategori),
            'icon' => $pathIcon, // Simpan path icon hasil Trait (bisa null)
            'halaman_induk' => $request->halaman_induk,
        ]);

        return redirect()->route('admin.kontenDownload.index')->with('success', 'Konten Download Berhasil Ditambahkan!');
    }

    public function edit($id): View // Tambah View return type
    {
        $kartuDownload = KategoriFile::findOrFail($id);
        return view('Admin.download.kontenDownload.formEditKontenDownload', compact('kartuDownload'));
    }

    public function update(Request $request, $id): RedirectResponse // Tambah RedirectResponse return type
    {
        $kartuDownload = KategoriFile::findOrFail($id);

        // 6. Sesuaikan Validasi Update Icon
         $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:1024', // Max 1MB
            'halaman_induk' => 'required|string|max:255',
        ]);


        $data = [
            'nama_kategori' => $request->nama_kategori,
            'slug' => Str::slug($request->nama_kategori),
            'halaman_induk' => $request->halaman_induk,
        ];

        // 7. Proses Update Icon dengan Trait
        if ($request->hasFile('icon')) {
            $this->hapusGambarLama($kartuDownload->icon); // Hapus icon lama
            $pathIconBaru = $this->prosesDanSimpanGambar($request->file('icon'), 'icon', 'icon');
             if (!$pathIconBaru && $request->file('icon')->isValid()) {
                 return redirect()->back()->withErrors(['icon' => 'Gagal memproses ikon baru.'])->withInput();
            }
            $data['icon'] = $pathIconBaru; // Gunakan path baru
        }
        // Jika tidak ada file baru, $data['icon'] tidak di-set, nilai lama tetap

        $kartuDownload->update($data);

        return redirect()->route('admin.kontenDownload.index')->with('success', 'Konten Download Berhasil Diupdate!');
    }

    public function destroy($id): RedirectResponse // Tambah RedirectResponse return type
    {
        $kartuDownload = KategoriFile::with('download')->findOrFail($id); // Eager load relasi

        // Hapus file-file terkait (FileDownload) - Logika ini tetap
        foreach ($kartuDownload->download as $file) {
            // Pastikan path lengkap ke file
            $filePath = 'upload/file/' . $file->file; // Sesuai FileDownloadController
             // Gunakan helper Trait untuk hapus file ini juga (meskipun bukan gambar)
             // Jika ingin Trait hanya untuk gambar, gunakan Storage::disk('public')->delete($filePath);
            $this->hapusGambarLama($filePath); // Bisa digunakan untuk file apa saja di public disk
            // Hapus record FileDownload itu sendiri jika perlu (tergantung relasi on cascade)
            // $file->delete(); // Jika tidak on cascade
        }
         // Hapus record FileDownload terkait (jika tidak ada ON DELETE CASCADE di DB)
        $kartuDownload->download()->delete();


        // 8. Gunakan Trait untuk Hapus Icon Kategori
        $this->hapusGambarLama($kartuDownload->icon);

        // Hapus Kategori itu sendiri
        $kartuDownload->delete();

        return redirect()->route('admin.kontenDownload.index')->with('success', 'Konten Download dan Semua Filenya Berhasil Dihapus!');
    }
}
