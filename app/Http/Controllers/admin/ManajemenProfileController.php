<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\ManajemenProfile;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ManajemenProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $profile = ManajemenProfile::when($search, function ($query, $search) {
            $query->where('judul', 'like', "%$search%");
        })->paginate(10);
        return view('Admin.manajemenProfile.profile.profile', compact('profile'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('Admin.manajemenProfile.profile.formProfile');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'id_user' => 'nullable|exists:user,id_user',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'judul' => 'required|min:5',
            'isi_konten' => 'required|min:5',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tgl_posting' => 'nullable|date',
            'dibaca' => 'nullable',
        ]);

        $path1 = $request->file('icon')->store('icon', 'public');
        $fileIcon = basename($path1);

        $path2 = $request->file('gambar')->store('profile', 'public');
        $fileGambar = basename($path2);

        $idUser = Auth::check() && Auth::user()->role === 'admin'
        ? 1
        : Auth::id();

        ManajemenProfile::create([
            'id_user'    => $idUser,
            'icon' => $fileIcon,
            'judul' => $request->judul,
            'isi_konten' => $request->isi_konten,
            'gambar' => $fileGambar,
            'tgl_posting' => now(),
            'dibaca' => 0,
        ]);

        return redirect()->route('admin.profile.index')->with('success', 'Data Pejabat Berhasil Disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ManajemenProfile $manajemenProfile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $profile = ManajemenProfile::findOrFail($id);
        return view('Admin.manajemenProfile.profile.formEditProfile', compact('profile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_user' => 'nullable|exists:user,id_user',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'judul' => 'required|min:5',
            'isi_konten' => 'required|min:5',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tgl_posting' => 'nullable|date',
            'dibaca' => 'nullable',
        ]);
        $profile = ManajemenProfile::findOrFail($id);

        $idUser = Auth::check() && Auth::user()->role === 'admin'
        ? 1
        : Auth::id();

        $data = [
            'id_user'    => $idUser,
            'judul'      => $request->judul,
            'isi_konten' => $request->isi_konten,
            'dibaca'     => 0,
            'tgl_posting'=> now(),
        ];

        if ($request->hasFile('icon')) {
            if ($profile->icon && Storage::disk('public')->exists('icon/' . $profile->icon)) {
                Storage::disk('public')->delete('icon/' . $profile->icon);
            }

            $path = $request->file('icon')->store('icon', 'public');
            $data['icon'] = basename($path);
        }
        
        if ($request->hasFile('gambar')) {
            if ($profile->gambar && Storage::disk('public')->exists('profile/' . $profile->gambar)) {
                Storage::disk('public')->delete('profile/' . $profile->gambar);
            }

            $path = $request->file('gambar')->store('profile', 'public');
            $data['gambar'] = basename($path);
        }

        $profile->update($data);

        return redirect()->route('admin.profile.index')->with('success', 'Data Berhasil Diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $profile = ManajemenProfile::findOrFail($id);
        $filePath1 = 'icon/' . $profile->icon;

        if ($profile->gambar && Storage::disk('public')->exists($filePath1)) {
            Storage::disk('public')->delete($filePath1);
        }
        $filePath2 = 'profile/' . $profile->gambar;

        if ($profile->gambar && Storage::disk('public')->exists($filePath2)) {
            Storage::disk('public')->delete($filePath2);
        }

        $profile->delete();
        return redirect()->route('admin.profile.index')->with('success', 'Data Berhasil Dihapus!');
    }
}
