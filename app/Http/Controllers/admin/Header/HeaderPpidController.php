<?php

namespace App\Http\Controllers\admin\Header;

use App\Http\Controllers\Controller;
use App\Models\admin\Header;
use App\Traits\ManajemenGambarTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class HeaderPpidController extends Controller
{
    use ManajemenGambarTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $headerPpid = Header::where('id_kategori_header', 6)
            ->when($search, function ($query, $search) {
                $query->where('headline', 'like', "%{$search}%")
                      ->orWhere('sub_heading', 'like', "%{$search}%");
            })->paginate(1);

        return view('Admin.ppid.headerPpid.headerPpid', compact('headerPpid'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Header $headerPpid)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Header $headerPpid): View
    {
        if ($headerPpid->id_kategori_header != 6) {
            abort(404);
        }
        return view('Admin.ppid.headerPpid.formEditHeaderPpid', compact('headerPpid'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Header $headerPpid): RedirectResponse
    {
        if ($headerPpid->id_kategori_header != 6) {
            abort(403, 'Unauthorized action.');
        }

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
            $this->hapusGambarLama($headerPpid->gambar);
            $pathGambarBaru = $this->prosesDanSimpanGambar(
                $request->file('gambar'),
                'page_header',
                'header'
            );
             if (!$pathGambarBaru) {
                 return redirect()->back()->withErrors(['gambar' => 'Gagal memproses gambar header baru.'])->withInput();
            }
            $data['gambar'] = $pathGambarBaru;
        }

        $headerPpid->update($data);

        Cache::forget('header_ppid');

        return redirect()->route('admin.headerPpid.index')->with('success', 'Heading PPID Berhasil Diperbarui!');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['general' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }

}
