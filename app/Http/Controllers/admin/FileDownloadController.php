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
     * Tampilkan daftar file berdasarkan kategori (slug optional)
     */
    public function index(Request $request, $slug = null)
    {
        $search = $request->input('search');
        $kategori = null;

        $query = FileDownload::query();

        if ($slug) {
            $kategori = KategoriFile::where('slug', $slug)->firstOrFail();
            $query->where('id_kategori', $kategori->id_kategori);
        }

        $download = $query->paginate(10);

        return view('Admin.download.fileDownload.fileDownload', compact('download', 'kategori'));
    }

    /**
     * Form tambah file (dengan id/slug kategori)
     */
    public function create($kategoriSlugOrId = null)
    {
        $kategori = null;

        if ($kategoriSlugOrId) {
            $kategori = is_numeric($kategoriSlugOrId)
                ? KategoriFile::find($kategoriSlugOrId)
                : KategoriFile::where('slug', $kategoriSlugOrId)->first();
        }

        if (!$kategori) {
            return redirect()->route('admin.kontenDownload.index')
                ->with('error', 'Kategori tidak ditemukan.');
        }

        return view('Admin.download.fileDownload.formFileDownload', compact('kategori'));
    }


    /**
     * Simpan file baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'id_kategori' => 'required|exists:kategori_download,id_kategori',
            'nama_file'   => 'required|string|max:255',
            'file'        => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar',
        ]);

        $idUser = Auth::check() && Auth::user()->role === 'admin' ? 1 : Auth::id();

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('upload/file', $fileName, 'public');

        FileDownload::create([
            'id_user'     => $idUser,
            'id_kategori' => $request->id_kategori,
            'nama_file'   => $request->nama_file,
            'file'        => $fileName,
        ]);

        $kategori = KategoriFile::find($request->id_kategori);
        return redirect()
            ->route('admin.fileDownload.index', $kategori->slug)
            ->with('success', 'File Berhasil Ditambahkan!');
    }

    /**
     * Form edit file.
     */
    public function edit($id, $kategoriSlug = null): View
    {
        $fileDownload = FileDownload::findOrFail($id);

        $kategori = $kategoriSlug
            ? KategoriFile::where('slug', $kategoriSlug)->first()
            : KategoriFile::find($fileDownload->id_kategori);

        return view('Admin.download.fileDownload.formEditFileDownload', compact('fileDownload', 'kategori'));
    }

    /**
     * Update file.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'id_kategori' => 'required|exists:kategori_download,id_kategori',
            'nama_file'   => 'required|string|max:255',
            'file'        => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar',
        ]);

        $fileDownload = FileDownload::findOrFail($id);
        $data = [
            'nama_file' => $request->nama_file,
            'id_kategori' => $request->id_kategori,
        ];

        if ($request->hasFile('file')) {
            // Hapus file lama
            if ($fileDownload->file && Storage::disk('public')->exists('upload/file/' . $fileDownload->file)) {
                Storage::disk('public')->delete('upload/file/' . $fileDownload->file);
            }

            // Upload baru
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('upload/file', $fileName, 'public');
            $data['file'] = $fileName;
        }

        $fileDownload->update($data);

        $kategori = KategoriFile::find($request->id_kategori);
        return redirect()
            ->route('admin.fileDownload.index', $kategori->slug)
            ->with('success', 'File Berhasil Diperbarui!');
    }

    /**
     * Hapus file.
     */
    public function destroy($id): RedirectResponse
    {
        $fileDownload = FileDownload::findOrFail($id);

        if ($fileDownload->file && Storage::disk('public')->exists('upload/file/' . $fileDownload->file)) {
            Storage::disk('public')->delete('upload/file/' . $fileDownload->file);
        }

        $kategori = KategoriFile::find($fileDownload->id_kategori);
        $fileDownload->delete();

        return redirect()
            ->route('admin.fileDownload.index', $kategori->slug)
            ->with('success', 'File Berhasil Dihapus!');
    }
}
