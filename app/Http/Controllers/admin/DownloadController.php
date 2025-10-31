<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\KategoriDownload;
use App\Traits\ManajemenGambarTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage; // Pastikan ini ada

class DownloadController extends Controller
{
    use ManajemenGambarTrait;

    public function index(): View
    {
        $kartuDownload = KategoriDownload::paginate(15);
        return view('Admin.download.kontenDownload.kontenDownload', compact('kartuDownload'));
    }

    public function create(): View
    {
        return view('Admin.download.kontenDownload.formKontenDownload');
    }

    public function store(Request $request): RedirectResponse
    {
        $messages = [
            'nama_kategori.required' => 'Nama sub kartu wajib diisi.',
            'nama_kategori.max' => 'Nama sub kartu maksimal :max karakter.',
            'icon.image' => 'File harus berupa gambar.',
            'icon.mimes' => 'Format gambar 1 harus jpeg, png, jpg, svg, atau webp.',
            'icon.max' => 'Ukuran gambar 1 maksimal :max KB.',
            'halaman_induk.required' => 'Nama halaman wajib diisi.',
        ];
        $validator = Validator::make($request->all(),[
            'nama_kategori' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:1024',
            'halaman_induk' => 'required|string',
        ], $messages);

        if ($validator->fails()) {
        return back()
        ->withErrors($validator)
        ->withInput();
        }

        try {
        $pathIcon = null;
        if ($request->hasFile('icon')) {
            $pathIcon = $this->prosesDanSimpanGambar(
                $request->file('icon'),
                'icon',
                'icon'
            );
             if (!$pathIcon && $request->file('icon')->isValid()) {
                 return redirect()->back()->withErrors(['icon' => 'Gagal memproses ikon.'])->withInput();
            }
        }

        KategoriDownload::create([
            'nama_kategori' => $request->nama_kategori,
            'slug' => Str::slug($request->nama_kategori),
            'icon' => $pathIcon,
            'halaman_induk' => $request->halaman_induk,
        ]);

        // === PERBAIKAN "SLEDGEHAMMER" ===
        $this->clearAllListCaches();
        // ===============================

        return redirect()->route('admin.kontenDownload.index')->with('success', 'Konten Download Berhasil Ditambahkan!');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['general' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function edit($id): View
    {
        $kartuDownload = KategoriDownload::findOrFail($id);
        return view('Admin.download.kontenDownload.formEditKontenDownload', compact('kartuDownload'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $kartuDownload = KategoriDownload::findOrFail($id);

        $slugLama = $kartuDownload->slug;
        $halamanIndukLama = $kartuDownload->halaman_induk;

        $messages = [
            'nama_kategori.required' => 'Nama sub kartu wajib diisi.',
            'nama_kategori.max' => 'Nama sub kartu maksimal :max karakter.',
            'icon.image' => 'File harus berupa gambar.',
            'icon.mimes' => 'Format gambar 1 harus jpeg, png, jpg, svg, atau webp.',
            'icon.max' => 'Ukuran gambar 1 maksimal :max KB.',
            'halaman_induk.required' => 'Nama halaman wajib diisi.',
        ];
        $validator = Validator::make($request->all(),[
            'nama_kategori' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:1024',
            'halaman_induk' => 'required|string',
        ], $messages);

        if ($validator->fails()) {
        return back()
        ->withErrors($validator)
        ->withInput();
        }

        try {

        $data = [
            'nama_kategori' => $request->nama_kategori,
            'slug' => Str::slug($request->nama_kategori),
            'halaman_induk' => $request->halaman_induk,
        ];

        if ($request->hasFile('icon')) {
            $this->hapusGambarLama($kartuDownload->icon);
            $pathIconBaru = $this->prosesDanSimpanGambar($request->file('icon'), 'icon', 'icon');
             if (!$pathIconBaru && $request->file('icon')->isValid()) {
                 return redirect()->back()->withErrors(['icon' => 'Gagal memproses ikon baru.'])->withInput();
            }
            $data['icon'] = $pathIconBaru;
        }

        $kartuDownload->update($data);
        
        $slugBaru = $data['slug'];
        $halamanIndukBaru = $data['halaman_induk'];

        // === PERBAIKAN "SLEDGEHAMMER" ===
        $this->clearAllListCaches(); // Hapus semua cache list

        // Hapus cache detail (per-slug) yang LAMA
        if ($halamanIndukLama == 'download') {
            Cache::forget("kategori_download_detail_{$slugLama}");
        } elseif ($halamanIndukLama == 'ppid') {
            Cache::forget("ppid.content.{$slugLama}");
        }

        // Hapus cache detail (per-slug) yang BARU (jika berubah)
        if ($slugBaru !== $slugLama || $halamanIndukBaru !== $halamanIndukLama) {
            if ($halamanIndukBaru == 'download') {
                Cache::forget("kategori_download_detail_{$slugBaru}");
            } elseif ($halamanIndukBaru == 'ppid') {
                Cache::forget("ppid.content.{$slugBaru}");
            }
        }
        // ===============================

        return redirect()->route('admin.kontenDownload.index')->with('success', 'Konten Download Berhasil Diupdate!');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['general' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function destroy($id): RedirectResponse
    {
        $kartuDownload = KategoriDownload::with('files')->findOrFail($id); // Eager load relasi

        $slug = $kartuDownload->slug;
        $halamanInduk = $kartuDownload->halaman_induk;

        // Hapus file fisik dari storage
        foreach ($kartuDownload->files as $file) {
            if ($file->file && Storage::disk('public')->exists('upload/file/' . $file->file)) {
                Storage::disk('public')->delete('upload/file/' . $file->file);
            }
        }
        // Hapus record file di database
        $kartuDownload->files()->delete();


        // Gunakan Trait untuk Hapus Icon Kategori
        $this->hapusGambarLama($kartuDownload->icon);

        $kartuDownload->delete();

        // === PERBAIKAN "SLEDGEHAMMER" ===
        $this->clearAllListCaches(); // Hapus semua cache list

        // Hapus cache detail (per-slug) yang spesifik
        if ($halamanInduk == 'download') {
            Cache::forget("kategori_download_detail_{$slug}");
        } elseif ($halamanInduk == 'ppid') {
            Cache::forget("ppid.content.{$slug}");
        }
        // ===============================

        return redirect()->route('admin.kontenDownload.index')->with('success', 'Konten Download dan Semua Filenya Berhasil Dihapus!');
    }
    
    /**
     * Menghapus semua cache list yang terkait dengan Download dan PPID.
     */
    private function clearAllListCaches()
    {
        // 1. Cache untuk halaman index /download (dari pengguna/DownloadController)
        Cache::forget('kategori_download_semua');

        // 2. Cache untuk halaman index /ppid (dari pengguna/PpidController)
        Cache::forget('ppid.kategori_konten');
        Cache::forget('ppid.kategori_download');

        // 3. Cache untuk sidebar navigasi /ppid/show (dari pengguna/PpidController)
        Cache::forget('ppid.all_items_nav');
    }
}
