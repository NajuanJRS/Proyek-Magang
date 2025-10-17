<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\KategoriFile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function index()
    {
        $kartuDownload = KategoriFile::paginate(15);
        return view('Admin.download.kontenDownload.kontenDownload', compact('kartuDownload'));
    }

    public function create()
    {
        return view('Admin.download.kontenDownload.formKontenDownload');
    }

    public function store(Request $request, KategoriFile $kategoriFile)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048', // validasi icon
            'halaman_induk' => 'nullable|string|max:255',
        ]);

        $path = $request->file('icon')->store('icon', 'public');
        $fileName = basename($path); // hanya ambil nama file

        KategoriFile::create([
            'nama_kategori' => $request->nama_kategori,
            'slug' => Str::slug($request->nama_kategori),
            'icon' => $fileName, // simpan path icon
            'halaman_induk' => $request->halaman_induk,
        ]);

        return redirect()->route('admin.kontenDownload.index')->with('success', 'Kartu Download Berhasil Ditambahkan!');
    }

    public function edit($id)
    {
        $kartuDownload = KategoriFile::findOrFail($id);
        return view('Admin.download.kontenDownload.formEditKontenDownload', compact('kartuDownload'));
    }

    public function update(Request $request, $id)
    {
        $kartuDownload = KategoriFile::findOrFail($id);

        $data = [
            'nama_kategori' => $request->nama_kategori,
            'slug' => Str::slug($request->nama_kategori),
            'halaman_induk' => $request->halaman_induk,
        ];

        if ($request->hasFile('icon')) {
            $oldFilePath = 'icon/' . $kartuDownload->icon;
            if ($kartuDownload->icon && Storage::disk('public')->exists($oldFilePath)) {
                Storage::disk('public')->delete($oldFilePath);
            }

            $path = $request->file('icon')->store('icon', 'public');
            $data['icon'] = basename($path);
        }

        $kartuDownload->update($data);

        return redirect()->route('admin.kontenDownload.index')->with('success', 'Kartu Download Berhasil Diupdate!');
    }

    public function destroy($id)
    {
    $kartuDownload = KategoriFile::with('download')->findOrFail($id);

    foreach ($kartuDownload->download as $file) {
        $filePath = 'upload/file/' . $file->file;
        if ($file->file && Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }
    }

    if ($kartuDownload->icon && Storage::disk('public')->exists('icon/' . $kartuDownload->icon)) {
        Storage::disk('public')->delete('icon/' . $kartuDownload->icon);
    }

    $kartuDownload->delete();

    return redirect()->route('admin.kontenDownload.index')->with('success', 'Kartu Download dan Semua Filenya Berhasil Dihapus!');
    }
}
