<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\MenuHeader;
use App\Models\admin\PageHeader;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PageHeaderController extends Controller
{
    private const NULLABLE_DATE_RULE = 'nullable|date';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $pageHeader = PageHeader::when($search, function ($query, $search) {
            $query->where('nama_menu', 'like', "%$search%")
                  ->orWhere('judul', 'like', "%$search%")
                  ->orWhere('deskripsi', 'like', "%$search%");
        })->paginate(10);
        return view('Admin.pageHeader.pageHeader', compact('pageHeader'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $menuHeader = MenuHeader::all();
        return view('Admin.pageHeader.formPageHeader', compact('menuHeader'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'id_menu' => 'required|exists:menu_header,id_menu',
            'id_user' => 'nullable|exists:user,id_user',
            'judul' => 'required|string|max:255',
            'gambar_header' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'deskripsi' => 'required|string',
            'created_at' => self::NULLABLE_DATE_RULE,
            'updated_at' => self::NULLABLE_DATE_RULE,
        ]);

        $idUser = Auth::check() && Auth::user()->role === 'admin'
        ? 1
        : Auth::id();

        $gambar_header = $request->file('gambar_header');
        $fileName = time() . '_' . $gambar_header->getClientOriginalName();
        $gambar_header->storeAs('gambarHeader', $fileName, 'public');

        PageHeader::create([
            'id_menu' => $request->id_menu,
            'id_user'    => $idUser,
            'judul' => $request->judul,
            'gambar_header' => $fileName,       // hanya nama file
            'deskripsi' => $request->deskripsi,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.pageHeader.index')->with('success', 'Gambar berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(PageHeader $pageHeader)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $pageHeader = PageHeader::findOrFail($id);
        $menuHeader = MenuHeader::all();
        return view('Admin.pageHeader.formEditPageHeader', compact('pageHeader', 'menuHeader'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $request->validate([
        'id_menu' => 'required|exists:menu_header,id_menu',
        'id_user' => 'nullable|exists:user,id_user',
        'judul' => 'nullable|string|max:255',
        'gambar_header' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'deskripsi' => 'nullable|string',
    ]);

    $idUser = Auth::check() && Auth::user()->role === 'admin'
        ? 1
        : Auth::id();

    $pageHeader = PageHeader::findOrFail($id);

    $data = [
        'id_menu' => $request->id_menu,
        'id_user' => $idUser,
        'judul' => $request->judul,
        'deskripsi' => $request->deskripsi,
        'updated_at' => now(),
    ];

    // Kalau ada gambar baru
    if ($request->hasFile('gambar_header')) {
        $gambar_header = $request->file('gambar_header');
        $fileName = time() . '_' . $gambar_header->getClientOriginalName();
        $gambar_header->storeAs('gambarHeader', $fileName, 'public');

        // Hapus file lama kalau ada
        if ($pageHeader->gambar_header && Storage::disk('public')->exists('gambarHeader/' . $pageHeader->gambar_header)) {
            Storage::disk('public')->delete('gambarHeader/' . $pageHeader->gambar_header);
        }

        $data['gambar_header'] = $fileName;
    }

    $pageHeader->update($data);

    return redirect()->route('admin.pageHeader.index')->with('success', 'Page header berhasil diperbarui!');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pageHeader = PageHeader::findOrFail($id);

        // hapus file dari storage kalau ada
        if ($pageHeader->gambar_header && Storage::disk('public')->exists('gambarHeader/' . $pageHeader->gambar_header)) {
            Storage::disk('public')->delete('gambarHeader/' . $pageHeader->gambar_header);
        }

        $pageHeader->delete();

        return redirect()->route('admin.pageHeader.index')->with('success', 'Gambar berhasil dihapus!');
    }
}
