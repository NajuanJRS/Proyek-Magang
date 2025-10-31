<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Berita;
use App\Traits\ManajemenGambarTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    use ManajemenGambarTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $berita = Berita::when($search, function ($query, $search) {
            $query->where('judul', 'like', "%{$search}%")
                  ->orWhere('isi_berita1', 'like', "%{$search}%")
                  ->orWhere('isi_berita2', 'like', "%{$search}%")
                  ->orWhere('isi_berita3', 'like', "%{$search}%");
        })
        ->orderBy('id_berita', 'desc')
        ->paginate(10);

        $berita->appends(['search' => $search]);

        return view('Admin.berita.kontenBerita.kontenBerita', compact('berita'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('Admin.berita.kontenBerita.formKontenBerita');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $messages = [
            'judul.required' => 'Judul wajib diisi.',
            'judul.min' => 'Judul minimal harus berisi :min karakter.',
            'judul.max' => 'Judul maksimal :max karakter.',
            'isi_berita1.required' => 'Isi berita 1 wajib diisi.',
            'isi_berita1.min' => 'Isi berita 1 minimal harus berisi :min karakter.',
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
            'judul' => 'required|string|min:10|max:255',
            'isi_berita1' => 'required|string|min:10',
            'gambar1' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'isi_berita2' => 'nullable|string',
            'gambar2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'isi_berita3' => 'nullable|string',
            'gambar3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
        ], $messages);

        if ($validator->fails()) {
        return back()
        ->withErrors($validator)
        ->withInput();
        }

        try{
        $slug = $this->getUniqueSlug($request->judul);

        $pathGambar1 = null;
        $pathGambar2 = null;
        $pathGambar3 = null;

        if ($request->hasFile('gambar1')) {
            $pathGambar1 = $this->prosesDanSimpanGambar($request->file('gambar1'), 'berita', 'berita');
        }
        if ($request->hasFile('gambar2')) {
            $pathGambar2 = $this->prosesDanSimpanGambar($request->file('gambar2'), 'berita', 'berita');
        }
        if ($request->hasFile('gambar3')) {
            $pathGambar3 = $this->prosesDanSimpanGambar($request->file('gambar3'), 'berita', 'berita');
        }

        $idUser = Auth::check() && Auth::user()->role === 'admin' ? 1 : Auth::id();

        Berita::create([
            'id_user'    => $idUser,
            'judul'      => $request->judul,
            'slug'       => $slug,
            'isi_berita1' => $request->isi_berita1,
            'gambar1'     => $pathGambar1,
            'isi_berita2' => $request->isi_berita2,
            'gambar2'     => $pathGambar2,
            'isi_berita3' => $request->isi_berita3,
            'gambar3'     => $pathGambar3,
            'dibaca'     => 0,
            'tgl_posting'=> now(),
        ]);

        return redirect()->route('admin.berita.index')->with('success', 'Berita Berhasil Ditambahkan!');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['general' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Berita $berita)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $berita = Berita::findOrFail($id);
        return view('Admin.berita.kontenBerita.formEditKontenBerita', compact('berita'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $messages = [
            'judul.required' => 'Judul wajib diisi.',
            'judul.min' => 'Judul minimal harus berisi :min karakter.',
            'judul.max' => 'Judul maksimal :max karakter.',
            'isi_berita1.required' => 'Isi Konten 1 wajib diisi.',
            'isi_berita1.min' => 'Isi Konten 1 minimal harus berisi :min karakter.',
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
            'judul' => 'required|string|min:10|max:255',
            'isi_berita1' => 'required|string|min:10',
            'gambar1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'isi_berita2' => 'nullable|string',
            'gambar2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'isi_berita3' => 'nullable|string',
            'gambar3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
        ], $messages);

        if ($validator->fails()) {
        return back()
        ->withErrors($validator)
        ->withInput();
        }

        try {
        $berita = Berita::findOrFail($id);
        $idUser = Auth::check() && Auth::user()->role === 'admin' ? 1 : Auth::id();

        $data = [
            'id_user'    => $idUser,
            'judul'      => $request->judul,
            'isi_berita1' => $request->isi_berita1,
            'isi_berita2' => $request->isi_berita2,
            'isi_berita3' => $request->isi_berita3,
        ];

        if ($request->judul !== $berita->judul) {
            $data['slug'] = $this->getUniqueSlug($request->judul, $id);
        }

        if ($request->hasFile('gambar1')) {
            $this->hapusGambarLama($berita->gambar1);
            $data['gambar1'] = $this->prosesDanSimpanGambar($request->file('gambar1'), 'berita', 'berita');
        }

        if ($request->hasFile('gambar2')) {
            $this->hapusGambarLama($berita->gambar2);
            $data['gambar2'] = $this->prosesDanSimpanGambar($request->file('gambar2'), 'berita', 'berita');
        } elseif ($request->has('hapus_gambar2') && $request->hapus_gambar2 == 1) {
            $this->hapusGambarLama($berita->gambar2);
            $data['gambar2'] = null;
        }

        if ($request->hasFile('gambar3')) {
            $this->hapusGambarLama($berita->gambar3);
            $data['gambar3'] = $this->prosesDanSimpanGambar($request->file('gambar3'), 'berita', 'berita');
        } elseif ($request->has('hapus_gambar3') && $request->hapus_gambar3 == 1) {
            $this->hapusGambarLama($berita->gambar3);
            $data['gambar3'] = null;
        }

        $berita->update($data);
        return redirect()->route('admin.berita.index')->with('success', 'Berita Berhasil Diperbarui!');
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
        $berita = Berita::findOrFail($id);

        $this->hapusGambarLama($berita->gambar1);
        $this->hapusGambarLama($berita->gambar2);
        $this->hapusGambarLama($berita->gambar3);

        $berita->delete();
        return redirect()->route('admin.berita.index')->with('success', 'Berita Berhasil Dihapus!');
    }

    /**
     * Generate a unique slug for the news item.
     */
    private function getUniqueSlug(string $title, ?int $exceptId = null): string
    {
        $slug = Str::slug($title, '-');
        $originalSlug = $slug;
        $count = 1;

        $query = Berita::where('slug', $slug);

        if ($exceptId !== null) {
            $query->where('id_berita', '!=', $exceptId);
        }

        while ($query->exists()) {
            $count++;
            $slug = $originalSlug . '-' . $count;
            $query = Berita::where('slug', $slug);
            if ($exceptId !== null) {
                $query->where('id_berita', '!=', $exceptId);
            }
        }

        return $slug;
    }
}
