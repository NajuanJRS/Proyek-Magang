<?php

namespace App\Http\Controllers\pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\admin\Berita;

class BeritaController extends Controller
{
    // Method baru untuk halaman arsip berita
    public function index(Request $request): View
    {
        $currentPage = $request->get('page', 1);
        $perPage = ($currentPage == 1) ? 9 : 12;

        $berita = Berita::orderBy('tgl_posting', 'desc')->paginate($perPage);

        return view('pengguna.berita.index', [
            'berita' => $berita
        ]);
    }

    // Method untuk halaman detail berita
    public function show(string $slug): View
    {
        $article = Berita::where('slug', $slug)->firstOrFail();

        // Ubah struktur data agar sesuai dengan view yang ada
        $content = [];
        if ($article->gambar1) {
            $content[] = ['type' => 'image', 'url' => $article->gambar1, 'caption' => 'Gambar Utama'];
        }
        if ($article->isi_berita1) {
            $content[] = ['type' => 'text', 'content' => $article->isi_berita1];
        }
        if ($article->gambar2) {
            $content[] = ['type' => 'image', 'url' => $article->gambar2, 'caption' => 'Gambar Pendukung 1'];
        }
        if ($article->isi_berita2) {
            $content[] = ['type' => 'text', 'content' => $article->isi_berita2];
        }
        if ($article->gambar3) {
            $content[] = ['type' => 'image', 'url' => $article->gambar3, 'caption' => 'Gambar Pendukung 2'];
        }
        
        $articleData = [
            'title' => $article->judul,
            'author' => 'Admin Dinsos', // Sementara
            'date' => \Carbon\Carbon::parse($article->tgl_posting)->isoFormat('dddd, D MMMM YYYY'),
            'views' => $article->dibaca,
            'content' => $content
        ];

        return view('pengguna.berita.show', [
            'article' => $articleData
        ]);
    }
}
