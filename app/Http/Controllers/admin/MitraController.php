<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Mitra;
use App\Traits\ManajemenGambarTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class MitraController extends Controller
{
    use ManajemenGambarTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $mitra = Mitra::when($search, function ($query, $search) {
            $query->where('nama_mitra', 'like', "%$search%");
        })->paginate(10);

        return view('Admin.beranda.mitra.mitra', compact('mitra'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('Admin.beranda.mitra.formMitra');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $messages = [
        'nama_mitra.required' => 'Nama Mitra wajib diisi.',
        'nama_mitra.min' => 'Nama Mitra minimal harus berisi :min karakter.',
        'nama_mitra.max' => 'Nama Mitra maksimal :max karakter.',
        'link_mitra.max' => 'Link Mitra maksimal :max karakkter',
        'link_mitra.url' => 'URL yang anda masukkan tidak valid',
        'gambar.required' => 'Gambar mitra wajib diunggah.',
        'gambar.image' => 'File harus berupa gambar.',
        'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, svg, atau webp.',
        'gambar.max' => 'Ukuran gambar maksimal :max KB.',
        ];

        $validator = Validator::make($request->all(),[
            'nama_mitra' => 'required|string|max:100',
            'link_mitra' => 'nullable|url|max:255',
            'gambar'     => 'required|image|mimes:jpeg,png,jpg,svg,webp|max:1024',
        ], $messages);

        if ($validator->fails()) {
        return back()
        ->withErrors($validator)
        ->withInput();
        }

        try{
        $idUser = Auth::check() && Auth::user()->role === 'admin'
            ? 1
            : Auth::id();

        $pathGambar = null;
        if ($request->hasFile('gambar')) {
            $pathGambar = $this->prosesDanSimpanGambar(
                $request->file('gambar'),
                'mitra',
                'mitra'
            );
            if (!$pathGambar) {
                 return redirect()->back()->withErrors(['gambar' => 'Gagal memproses gambar mitra.'])->withInput();
            }
        } else {
             return redirect()->back()->withErrors(['gambar' => 'Gambar mitra wajib diunggah.'])->withInput();
        }

        Mitra::create([
            'id_user'    => $idUser,
            'nama_mitra' => $request->nama_mitra,
            'link_mitra' => $request->link_mitra,
            'gambar'     => $pathGambar,
        ]);

        Cache::forget('beranda_mitra');

        return redirect()->route('admin.mitra.index')->with('success', 'Mitra Berhasil Ditambahkan!');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['general' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Mitra $mitra)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mitra $mitra): View
    {
        return view('Admin.beranda.mitra.formEditMitra', compact('mitra'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mitra $mitra): RedirectResponse
    {

        $messages = [
            'nama_mitra.required' => 'Nama Mitra wajib diisi.',
            'nama_mitra.min' => 'Nama Mitra minimal harus berisi :min karakter.',
            'nama_mitra.max' => 'Nama Mitra maksimal :max karakter.',
            'link_mitra.max' => 'Link Mitra maksimal :max karakkter',
            'link_mitra.url' => 'URL yang anda masukkan tidak valid',
            'gambar.required' => 'Gambar mitra wajib diunggah.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, svg, atau webp.',
            'gambar.max' => 'Ukuran gambar maksimal :max KB.',
        ];
        $validator = Validator::make($request->all(),[
            'id_user' => 'nullable|exists:users,id_user',
            'nama_mitra' => 'required|string|max:100',
            'link_mitra' => 'nullable|url|max:255',
            'gambar'     => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:1024',
        ], $messages);

        if ($validator->fails()) {
        return back()
        ->withErrors($validator)
        ->withInput();
        }

        try{
        $idUser = Auth::check() && Auth::user()->role === 'admin'
            ? 1
            : Auth::id();

        $data = [
            'id_user'    => $idUser,
            'nama_mitra' => $request->nama_mitra,
            'link_mitra' => $request->link_mitra,
        ];

        if ($request->hasFile('gambar')) {
            $this->hapusGambarLama($mitra->gambar);
            $pathGambarBaru = $this->prosesDanSimpanGambar($request->file('gambar'), 'mitra', 'mitra');
            if (!$pathGambarBaru) {
                return redirect()->back()->withErrors(['gambar' => 'Gagal memproses gambar mitra baru.'])->withInput();
            }
            $data['gambar'] = $pathGambarBaru;
        }

        $mitra->update($data);

        Cache::forget('beranda_mitra');

        return redirect()->route('admin.mitra.index')->with('success', 'Mitra Berhasil Diperbarui!');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['general' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mitra $mitra): RedirectResponse
    {
        $this->hapusGambarLama($mitra->gambar);

        $mitra->delete();

        Cache::forget('beranda_mitra');

        return redirect()->route('admin.mitra.index')->with('success', 'Mitra Berhasil Dihapus!');
    }
}
