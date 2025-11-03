<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\FileDownload;
use Illuminate\Http\Request;

class DaftarFileDownloadController extends Controller
{
    public function index(Request $request)
    {
        $query = FileDownload::with('kategoriDownload');

        if ($request->halaman_induk) {
            $query->whereHas('kategoriDownload', function ($q) use ($request) {
                $q->where('halaman_induk', $request->halaman_induk);
            });
        }
        $judulHalaman = match (strtolower($request->halaman_induk)) {
            'download' => 'File Download',
            'ppid' => 'File PPID',
            default => 'Daftar File',
        };

        $fileDownload = $query->paginate(10);

        return view('admin.fileDownload.daftarFileDownload', compact('fileDownload', 'judulHalaman'));
    }
}
