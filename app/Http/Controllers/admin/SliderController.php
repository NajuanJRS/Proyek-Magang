<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Header;
use App\Traits\ManajemenGambarTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;


class SliderController extends Controller
{
    use ManajemenGambarTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
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
        $messages = [
            'headline.required' => 'Headline wajib diisi.',
            'headline.min' => 'Headline minimal harus berisi :min karakter.',
            'headline.max' => 'Headline maksimal :max karakter.',
            'sub_heading.required' => 'Sub Heading wajib diisi.',
            'sub_heading.max' => 'Sub Heading maksimal :max karakter.',
            'gambar' => 'Gambar wajib diisi.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, svg, atau webp.',
            'gambar.max' => 'Ukuran gambar maksimal :max KB.',
        ];

        $validator = Validator::make($request->all(),[
            'headline' => 'required|string|min:5|max:100',
            'sub_heading' => 'required|string|max:255',
            'gambar'     => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
        ], $messages);

        if ($validator->fails()) {
        return back()
        ->withErrors($validator)
        ->withInput();
        }

        try {
        $idUser = Auth::check() && Auth::user()->role === 'admin'
            ? 1
            : Auth::id();

        $pathGambar = null;
        if ($request->hasFile('gambar')) {
            $pathGambar = $this->prosesDanSimpanGambar(
                $request->file('gambar'),
                'slider_header',
                'header'
            );
            if (!$pathGambar) {
                 return redirect()->back()->withErrors(['gambar' => 'Gagal memproses gambar slider.'])->withInput();
            }
        } else {
             return redirect()->back()->withErrors(['gambar' => 'Gambar slider wajib diunggah.'])->withInput();
        }

        Header::create([
            'id_user'    => $idUser,
            'id_kategori_header' => '1',
            'headline' => $request->headline,
            'sub_heading' => $request->sub_heading,
            'gambar'     => $pathGambar,
        ]);

        Cache::forget('beranda_hero_slides');

        return redirect()->route('admin.slider.index')->with('success', 'Hero Section Berhasil Ditambahkan!');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['general' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
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
        $slider = Header::where('id_kategori_header', 1)->findOrFail($id);
        return view('Admin.beranda.slider.formEditSlider', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $slider = Header::where('id_kategori_header', 1)->findOrFail($id);

        $messages = [
            'headline.required' => 'Headline wajib diisi.',
            'headline.min' => 'Headline minimal harus berisi :min karakter.',
            'headline.max' => 'Headline maksimal :max karakter.',
            'sub_heading.required' => 'Sub Heading wajib diisi.',
            'sub_heading.max' => 'Sub Heading maksimal :max karakter.',
            'gambar' => 'Gambar wajib diisi.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, svg, atau webp.',
            'gambar.max' => 'Ukuran gambar maksimal :max KB.',
        ];

        $validator = Validator::make($request->all(),[
            'headline' => 'required|string|min:5|max:100',
            'sub_heading' => 'required|string|min:5|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
        ], $messages);

        if ($validator->fails()) {
        return back()
        ->withErrors($validator)
        ->withInput();
        }

        try {
        $idUser = Auth::check() && Auth::user()->role === 'admin'
            ? 1
            : Auth::id();

        $data = [
            'id_user'    => $idUser,
            'headline' => $request->headline,
            'sub_heading' => $request->sub_heading,
        ];

        if ($request->hasFile('gambar')) {
            $this->hapusGambarLama($slider->gambar);
            $pathGambarBaru = $this->prosesDanSimpanGambar(
                $request->file('gambar'),
                'slider_header',
                'header'
            );
             if (!$pathGambarBaru) {
                 return redirect()->back()->withErrors(['gambar' => 'Gagal memproses gambar slider baru.'])->withInput();
            }
            $data['gambar'] = $pathGambarBaru;
        }

        $slider->update($data);

        Cache::forget('beranda_hero_slides');

        return redirect()->route('admin.slider.index')->with('success', 'Hero Section Berhasil Diperbarui!');
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
        $slider = Header::where('id_kategori_header', 1)->findOrFail($id);

        $this->hapusGambarLama($slider->gambar);

        $slider->delete();

        Cache::forget('beranda_hero_slides');

        return redirect()->route('admin.slider.index')->with('success', 'Hero Section Berhasil Dihapus!');
    }
}

