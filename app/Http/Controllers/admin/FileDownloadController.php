<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\FileDownload;
use App\Models\admin\KategoriFile;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileDownloadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $download = FileDownload::when($search, function ($query, $search) {
            $query->where('nama_file', 'like', "%$search%")
                  ->orWhere('kategori', 'like', "%$search%")
                  ->orWhere('file', 'like', "%$search%");
        })->paginate(10);
        return view('Admin.konfigurasiKonten.download.fileDownload', compact('download'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $kategori = KategoriFile::all();
        return view('Admin.konfigurasiKonten.download.formFileDownload', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'id_user' => 'nullable|exists:user,id_user',
            'nama_file' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar|max:2048',
            'tgl_file' => 'nullable|date',
        ]);

        $idUser = Auth::check() && Auth::user()->role === 'admin'
        ? 1
        : Auth::id();

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('upload/file', $fileName, 'public');

        $path1 = $request->file('icon')->store('icon', 'public');
        $fileIcon = basename($path1);

        FileDownload::create([
            'id_user'    => $idUser,
            'id_kategori' => $request->id_kategori,
            'icon' => $fileIcon,
            'file' => $fileName,       // hanya nama file
            'nama_file' => $request->nama_file,
            'tgl_file' => now(),
        ]);

        return redirect()->route('admin.download.index')->with('success', 'File berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(FileDownload $fileDownload)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $fileDownload = FileDownload::findOrFail($id);
        $kategori = KategoriFile::all();
        return view('Admin.konfigurasiKonten.download.formEditFileDownload', compact('fileDownload', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'id_user' => 'nullable|exists:user,id_user',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama_file' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar|max:2048',
            'tgl_file' => 'nullable|date',
        ]);

        $idUser = Auth::check() && Auth::user()->role === 'admin'
        ? 1
        : Auth::id();

        $fileDownload = FileDownload::findOrFail($id);
        $data = [
            'id_user'    => $idUser,
            'id_kategori' => $request->id_kategori,
            'nama_file' => $request->nama_file,
            'tgl_file' => now(),
        ];

        if ($request->hasFile('icon')) {
            if ($fileDownload->icon && Storage::disk('public')->exists('icon/' . $fileDownload->icon)) {
                Storage::disk('public')->delete('icon/' . $fileDownload->icon);
            }

            $path = $request->file('icon')->store('icon', 'public');
            $data['icon'] = basename($path);
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('upload/file', $fileName, 'public');

            // hapus file lama kalau ada
            if ($fileDownload->file && Storage::disk('public')->exists('upload/file/' . $fileDownload->file)) {
                Storage::disk('public')->delete('upload/file/' . $fileDownload->file);
            }
    }

        $data['file'] = $fileName ?? $fileDownload->file;
        $fileDownload->update($data);

        return redirect()->route('admin.download.index')->with('success', 'File berhasil ditambahkan!');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $fileDownload = FileDownload::findOrFail($id);
        $filePath1 = 'icon/' . $fileDownload->icon;

        if ($fileDownload->icon && Storage::disk('public')->exists($filePath1)) {
            Storage::disk('public')->delete($filePath1);
        }

        // hapus file dari storage kalau ada
        if ($fileDownload->file && Storage::disk('public')->exists('upload/file/' . $fileDownload->file)) {
            Storage::disk('public')->delete('upload/file/' . $fileDownload->file);
        }

        $fileDownload->delete();

        return redirect()->route('admin.download.index')->with('success', 'File berhasil dihapus!');
    }
}
