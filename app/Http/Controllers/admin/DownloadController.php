<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\KategoriFile;
use App\Traits\ManajemenGambarTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DownloadController extends Controller
{
    use ManajemenGambarTrait;

    public function index(): View
    {
        $kartuDownload = KategoriFile::paginate(15);
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

        KategoriFile::create([
            'nama_kategori' => $request->nama_kategori,
            'slug' => Str::slug($request->nama_kategori),
            'icon' => $pathIcon,
            'halaman_induk' => $request->halaman_induk,
        ]);

        return redirect()->route('admin.kontenDownload.index')->with('success', 'Konten Download Berhasil Ditambahkan!');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['general' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function edit($id): View
    {
        $kartuDownload = KategoriFile::findOrFail($id);
        return view('Admin.download.kontenDownload.formEditKontenDownload', compact('kartuDownload'));
    }

    public function update(Request $request, $id): RedirectResponse
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
        $kartuDownload = KategoriFile::findOrFail($id);
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

        return redirect()->route('admin.kontenDownload.index')->with('success', 'Konten Download Berhasil Diupdate!');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['general' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function destroy($id): RedirectResponse
    {
        $kartuDownload = KategoriFile::with('download')->findOrFail($id);
        foreach ($kartuDownload->download as $file) {
            $filePath = 'upload/file/' . $file->file;
            $this->hapusGambarLama($filePath);
        }
        $kartuDownload->download()->delete();

        $this->hapusGambarLama($kartuDownload->icon);

        $kartuDownload->delete();

        return redirect()->route('admin.kontenDownload.index')->with('success', 'Konten Download dan Semua Filenya Berhasil Dihapus!');
    }
}
