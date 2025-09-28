<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\LayananKami;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LayananKamiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $layanan = LayananKami::when($search, function ($query, $search) {
            $query->where('judul', 'like', "%$search%")
                  ->orWhere('isi', 'like', "%$search%");
        })->paginate(10);

        return view('Admin.konfigurasiKonten.layanan.layananKami', compact('layanan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('Admin.konfigurasiKonten.layanan.formLayananKami');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'isi_layanan1' => 'required|string|max:5000',
            'gambar1' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'isi_layanan2' => 'nullable|string|max:5000',
            'gambar2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'isi_layanan3' => 'nullable|string|max:5000',
            'gambar3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Upload icon (opsional)
        $fileIcon = null;
        if ($request->hasFile('icon')) {
            $path4 = $request->file('icon')->store('icon', 'public');
            $fileIcon = basename($path4);
        }

        // Upload gambar1 (wajib)
        $path1 = $request->file('gambar1')->store('layanan', 'public');
        $fileGambar1 = basename($path1);

        // Upload gambar2 (opsional)
        $fileGambar2 = null;
        if ($request->hasFile('gambar2')) {
            $path2 = $request->file('gambar2')->store('layanan', 'public');
            $fileGambar2 = basename($path2);
        }

        // Upload gambar3 (opsional)
        $fileGambar3 = null;
        if ($request->hasFile('gambar3')) {
            $path3 = $request->file('gambar3')->store('layanan', 'public');
            $fileGambar3 = basename($path3);
        }

            $idUser = Auth::check() && Auth::user()->role === 'admin'
            ? 1
            : Auth::id();

        LayananKami::create([
            'id_user'    => $idUser,
            'icon' => $fileIcon,
            'judul' => $request->judul,
            'isi_layanan1' => $request->isi_layanan1,
            'gambar1' => $fileGambar1,
            'isi_layanan2' => $request->isi_layanan2,
            'gambar2' => $fileGambar2,
            'isi_layanan3' => $request->isi_layanan3,
            'gambar3' => $fileGambar3,
        ]);

        return redirect()->route('admin.layanan.index')->with('success', 'Jabatan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(LayananKami $layananKami)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $layananKami = LayananKami::findOrFail($id);
        return view('Admin.konfigurasiKonten.layanan.formEditLayananKami', compact('layananKami'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'judul' => 'required|string|max:255',
            'isi_layanan1' => 'required|string|max:5000',
            'gambar1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'isi_layanan2' => 'nullable|string|max:5000',
            'gambar2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'isi_layanan3' => 'nullable|string|max:5000',
            'gambar3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $layananKami= LayananKami::findOrFail($id);
        $idUser = Auth::check() && Auth::user()->role === 'admin'
        ? 1
        : Auth::id();

        $data = [
            'id_user'    => $idUser,
            'icon' => $request->icon,
            'judul' => $request->judul,
            'isi_layanan1' => $request->isi_layanan1,
            'isi_layanan2' => $request->isi_layanan2,
            'isi_layanan3' => $request->isi_layanan3,
        ];
    // Handle icon
    if ($request->hasFile('icon')) {
        if ($layananKami->icon && Storage::disk('public')->exists('icon/' . $layananKami->icon)) {
            Storage::disk('public')->delete('icon/' . $layananKami->icon);
        }
        $path4 = $request->file('icon')->store('icon', 'public');
        $data['icon'] = basename($path4);
    }
            // Handle Gambar 1
    if ($request->hasFile('gambar1')) {
        if ($layananKami->gambar1 && Storage::disk('public')->exists('layanan/' . $layananKami->gambar1)) {
            Storage::disk('public')->delete('layanan/' . $layananKami->gambar1);
        }
        $path1 = $request->file('gambar1')->store('layanan', 'public');
        $data['gambar1'] = basename($path1);
    }

    // Handle Gambar 2
    if ($request->hasFile('gambar2')) {
        if ($layananKami->gambar2 && Storage::disk('public')->exists('layanan/' . $layananKami->gambar2)) {
            Storage::disk('public')->delete('layanan/' . $layananKami->gambar2);
        }
        $path2 = $request->file('gambar2')->store('layanan', 'public');
        $data['gambar2'] = basename($path2);
    }

    // Handle Gambar 3
    if ($request->hasFile('gambar3')) {
        if ($layananKami->gambar3 && Storage::disk('public')->exists('layanan/' . $layananKami->gambar3)) {
            Storage::disk('public')->delete('layanan/' . $layananKami->gambar3);
        }
        $path3 = $request->file('gambar3')->store('layanan', 'public');
        $data['gambar3'] = basename($path3);
    }

        $layananKami->update($data);

        return redirect()->route('admin.layanan.index')->with('success', 'Data Slider Berhasil Diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $layananKami = LayananKami::findOrFail($id);
        $filePath1 = 'icon/' . $layananKami->icon;
        $filePath2 = 'layanan/' . $layananKami->gambar1;
        $filePath3 = 'layanan/' . $layananKami->gambar2;
        $filePath4 = 'layanan/' . $layananKami->gambar3;

        if ($layananKami->icon && Storage::disk('public')->exists($filePath1)) {
            Storage::disk('public')->delete($filePath1);
        }
        if ($layananKami->gambar1 && Storage::disk('public')->exists($filePath2)) {
            Storage::disk('public')->delete($filePath2);
        }
        if ($layananKami->gambar2 && Storage::disk('public')->exists($filePath3)) {
            Storage::disk('public')->delete($filePath3);
        }
        if ($layananKami->gambar3 && Storage::disk('public')->exists($filePath4)) {
            Storage::disk('public')->delete($filePath4);
        }
        $layananKami->delete();

        return redirect()->route('admin.layanan.index')->with('success', 'Layanan berhasil dihapus!');
    }
}
