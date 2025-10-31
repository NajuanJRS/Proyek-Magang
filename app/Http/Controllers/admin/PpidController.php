<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\KategoriKonten;
use App\Models\admin\Konten;
use App\Traits\ManajemenGambarTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
// use Illuminate\Support\Facades\Storage; // Tidak perlu lagi
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Support\Str;

class PpidController extends Controller
{
    use ManajemenGambarTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $kontenPpid = Konten::with('kategoriKonten')
            ->whereHas('kategoriKonten', function ($query) use ($search) {
                $query->where('menu_konten', 'PPID');
                if (!empty($search)) {
                     $query->where('judul_konten', 'like', "%{$search}%");
                }
            })
            ->orderBy('id_konten', 'desc')
            ->paginate(10);

        return view('Admin.ppid.kontenPpid.kontenPpid', compact('kontenPpid'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('Admin.ppid.kontenPpid.formKontenPpid');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $messages = [
            'judul_konten.required' => 'Judul wajib diisi.',
            'judul_konten.min' => 'Judul minimal harus berisi :min karakter.',
            'judul_konten.max' => 'Judul maksimal :max karakter.',
            'icon_konten.required' => 'Icon mitra wajib diunggah.',
            'icon_konten.image' => 'File harus berupa Icon.',
            'icon_konten.mimes' => 'Format IconIcon harus jpeg, png, jpg, svg, atau webp.',
            'icon_konten.max' => 'Ukuran Icon maksimal :max KB.',
            'isi_konten1.required' => 'Isi Konten 1 wajib diisi.',
            'isi_konten1.min' => 'Isi Konten 1 minimal harus berisi :min karakter.',
            'gambar1.image' => 'File harus berupa gambar.',
            'gambar1.mimes' => 'Format gambar 1 harus jpeg, png, jpg, svg, atau webp.',
            'gambar1.max' => 'Ukuran gambar 1 maksimal :max KB.',
            'gambar2.image' => 'File harus berupa gambar.',
            'gambar2.mimes' => 'Format gambar 2 harus jpeg, png, jpg, svg, atau webp.',
            'gambar2.max' => 'Ukuran gambar 2 maksimal :max KB.',
            'gambar3.mimes' => 'Format gambar 3 harus jpeg, png, jpg, svg, atau webp.',
            'gambar3.max' => 'Ukuran gambar 3 maksimal :max KB.',
        ];

        $validator = Validator::make($request->all(),[
            'judul_konten'  => 'required|string|min:10|max:255',
            'icon_konten'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:1024',
            'isi_konten1'  => 'required|string|min:10',
            'gambar1'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'isi_konten2'  => 'nullable|string',
            'gambar2'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'isi_konten3'  => 'nullable|string',
            'gambar3'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
        ], $messages);

        if ($validator->fails()) {
        return back()
        ->withErrors($validator)
        ->withInput();
        }

        try {
        $pathIconKonten = null;
        if ($request->hasFile('icon_konten')) {
            $pathIconKonten = $this->prosesDanSimpanGambar($request->file('icon_konten'), 'icon', 'icon');
             if (!$pathIconKonten) {
                 return redirect()->back()->withErrors(['icon_konten' => 'Gagal memproses ikon.'])->withInput();
            }
        }

        $kategori = KategoriKonten::create([
            'menu_konten'     => 'PPID',
            'judul_konten'  => $request->judul_konten,
            'icon_konten'   => $pathIconKonten,
            'slug'          => Str::slug($request->judul_konten),
        ]);

        $pathGambar1 = null;
        $pathGambar2 = null;
        $pathGambar3 = null;

        if ($request->hasFile('gambar1')) {
            $pathGambar1 = $this->prosesDanSimpanGambar($request->file('gambar1'), 'konten', 'konten');
             if (!$pathGambar1) { $kategori->delete(); return redirect()->back()->withErrors(['gambar1' => 'Gagal memproses gambar 1.'])->withInput(); }
        }
        if ($request->hasFile('gambar2')) {
            $pathGambar2 = $this->prosesDanSimpanGambar($request->file('gambar2'), 'konten', 'konten');
             if (!$pathGambar2) { $this->hapusGambarLama($pathGambar1); $kategori->delete(); return redirect()->back()->withErrors(['gambar2' => 'Gagal memproses gambar 2.'])->withInput(); }
        }
        if ($request->hasFile('gambar3')) {
            $pathGambar3 = $this->prosesDanSimpanGambar($request->file('gambar3'), 'konten', 'konten');
             if (!$pathGambar3) { $this->hapusGambarLama($pathGambar1); $this->hapusGambarLama($pathGambar2); $kategori->delete(); return redirect()->back()->withErrors(['gambar3' => 'Gagal memproses gambar 3.'])->withInput(); }
        }

        Konten::create([
            'id_user'             => Auth::id() ?? 1,
            'id_kategori_konten'  => $kategori->id_kategori_konten,
            'isi_konten1'        => $request->isi_konten1,
            'gambar1'             => $pathGambar1,
            'isi_konten2'        => $request->isi_konten2,
            'gambar2'             => $pathGambar2,
            'isi_konten3'        => $request->isi_konten3,
            'gambar3'             => $pathGambar3,
        ]);

        Cache::forget('ppid.kategori_konten');
        Cache::forget('ppid.all_items_nav');

        return redirect()->route('admin.ppid.index') // Sesuaikan route
            ->with('success', 'Konten PPID Berhasil Ditambahkan!');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['general' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Konten $kontenPpid)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $kontenPpid = Konten::with('kategoriKonten')->findOrFail($id);
        return view('Admin.ppid.kontenPpid.formEditKontenPpid', compact('kontenPpid'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $messages = [
            'judul_konten.required' => 'Judul wajib diisi.',
            'judul_konten.min' => 'Judul minimal harus berisi :min karakter.',
            'judul_konten.max' => 'Judul maksimal :max karakter.',
            'icon_konten.required' => 'Icon mitra wajib diunggah.',
            'icon_konten.image' => 'File harus berupa Icon.',
            'icon_konten.mimes' => 'Format IconIcon harus jpeg, png, jpg, svg, atau webp.',
            'icon_konten.max' => 'Ukuran Icon maksimal :max KB.',
            'isi_konten1.required' => 'Isi Konten 1 wajib diisi.',
            'isi_konten1.min' => 'Isi Konten 1 minimal harus berisi :min karakter.',
            'gambar1.image' => 'File harus berupa gambar.',
            'gambar1.mimes' => 'Format gambar 1 harus jpeg, png, jpg, svg, atau webp.',
            'gambar1.max' => 'Ukuran gambar 1 maksimal :max KB.',
            'gambar2.image' => 'File harus berupa gambar.',
            'gambar2.mimes' => 'Format gambar 2 harus jpeg, png, jpg, svg, atau webp.',
            'gambar2.max' => 'Ukuran gambar 2 maksimal :max KB.',
            'gambar3.mimes' => 'Format gambar 3 harus jpeg, png, jpg, svg, atau webp.',
            'gambar3.max' => 'Ukuran gambar 3 maksimal :max KB.',
        ];

        $validator = Validator::make($request->all(),[
            'judul_konten'  => 'required|string|min:10|max:255',
            'icon_konten'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:1024',
            'isi_konten1'  => 'required|string|min:10',
            'gambar1'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'isi_konten2'  => 'nullable|string',
            'gambar2'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'isi_konten3'  => 'nullable|string',
            'gambar3'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
        ], $messages);

        if ($validator->fails()) {
        return back()
        ->withErrors($validator)
        ->withInput();
        }

        try {
        $konten = Konten::with('kategoriKonten')->findOrFail($id);
        $kategori = $konten->kategoriKonten;
        $slugLama = $kategori->slug;
        $slugBaru = $slugLama; // Inisialisasi

        $kategoriData = [
            'judul_konten'  => $request->judul_konten,
        ];

        if ($request->hasFile('icon_konten')) {
            $this->hapusGambarLama($kategori->icon_konten);
            $pathIconBaru = $this->prosesDanSimpanGambar($request->file('icon_konten'), 'icon', 'icon');
            if (!$pathIconBaru) {
                return redirect()->back()->withErrors(['icon_konten' => 'Gagal memproses ikon baru.'])->withInput();
            }
            $kategoriData['icon_konten'] = $pathIconBaru;
        }

        if ($request->judul_konten !== $kategori->judul_konten) {
            $kategoriData['slug'] = Str::slug($request->judul_konten);
            $slugBaru = $kategoriData['slug'];
        }

        $kategori->update($kategoriData);

        $kontenData = [
            'isi_konten1' => $request->isi_konten1,
            'isi_konten2' => $request->isi_konten2,
            'isi_konten3' => $request->isi_konten3,
        ];

        if ($request->hasFile('gambar1')) {
            $this->hapusGambarLama($konten->gambar1);
            $pathGambar1Baru = $this->prosesDanSimpanGambar($request->file('gambar1'), 'konten', 'konten');
            if (!$pathGambar1Baru) return redirect()->back()->withErrors(['gambar1' => 'Gagal memproses gambar 1.'])->withInput();
            $kontenData['gambar1'] = $pathGambar1Baru;
        }

        if ($request->hasFile('gambar2')) {
            $this->hapusGambarLama($konten->gambar2);
            $pathGambar2Baru = $this->prosesDanSimpanGambar($request->file('gambar2'), 'konten', 'konten');
            if (!$pathGambar2Baru) return redirect()->back()->withErrors(['gambar2' => 'Gagal memproses gambar 2.'])->withInput();
            $kontenData['gambar2'] = $pathGambar2Baru;
        } elseif ($request->has('hapus_gambar2') && $request->hapus_gambar2 == 1) {
            $this->hapusGambarLama($konten->gambar2);
            $kontenData['gambar2'] = null;
        }

        if ($request->hasFile('gambar3')) {
            $this->hapusGambarLama($konten->gambar3);
             $pathGambar3Baru = $this->prosesDanSimpanGambar($request->file('gambar3'), 'konten', 'konten');
             if (!$pathGambar3Baru) return redirect()->back()->withErrors(['gambar3' => 'Gagal memproses gambar 3.'])->withInput();
            $kontenData['gambar3'] = $pathGambar3Baru;
        } elseif ($request->has('hapus_gambar3') && $request->hapus_gambar3 == 1) {
            $this->hapusGambarLama($konten->gambar3);
            $kontenData['gambar3'] = null;
        }

        $konten->update($kontenData);

        Cache::forget('ppid.kategori_konten');
        Cache::forget('ppid.all_items_nav');

        // 2. Hapus cache halaman detail (slug lama)
        Cache::forget("ppid.content.{$slugLama}");

        // 3. Hapus cache halaman detail (slug baru, jika berubah)
        if ($slugBaru !== $slugLama) {
            Cache::forget("ppid.content.{$slugBaru}");
        }

        return redirect()->route('admin.ppid.index')->with('success', 'Konten PPID Berhasil Diperbarui!'); // Sesuaikan route
        } catch (\Exception $e) {
            return back()
                ->withErrors(['general' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $kontenPpid = Konten::with('kategoriKonten')->findOrFail($id);

        $this->hapusGambarLama($kontenPpid->gambar1);
        $this->hapusGambarLama($kontenPpid->gambar2);
        $this->hapusGambarLama($kontenPpid->gambar3);

        $kategori = $kontenPpid->kategoriKonten;
        $slugYangDihapus = null;
        if ($kategori) {
            $slugYangDihapus = $kategori->slug;
             // Cek konten lain
            $otherKontenExists = Konten::where('id_kategori_konten', $kategori->id_kategori_konten)
                                        ->where('id_konten', '!=', $id)
                                        ->exists();

            if (!$otherKontenExists) {
                $this->hapusGambarLama($kategori->icon_konten);
                $kategori->delete();
            }
        }

        $kontenPpid->delete();

        Cache::forget('ppid.kategori_konten');
        Cache::forget('ppid.all_items_nav');

        // 2. Hapus cache halaman detail (jika slug-nya ada)
        if ($slugYangDihapus) {
            Cache::forget("ppid.content.{$slugYangDihapus}");
        }

        return redirect()->route('admin.ppid.index')->with('success', 'Konten PPID Berhasil Dihapus!'); // Sesuaikan route
    }
}
