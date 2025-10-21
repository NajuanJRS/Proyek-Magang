<?php

namespace App\Http\Controllers\pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\admin\Berita;
use App\Models\admin\Header;

class BeritaController extends Controller
{
        public function index(Request $request): View
    {
        // Ambil data header untuk halaman berita (asumsi id_kategori_header = 4)
        $header = Header::where('id_kategori_header', 4)->first();

        // Logika pagination yang sudah ada
        $currentPage = $request->get('page', 1);
        $perPage = ($currentPage == 1) ? 9 : 12;
        $berita = Berita::orderBy('tgl_posting', 'desc')->paginate($perPage);

        // Kirim data header dan berita ke view
        return view('pengguna.berita.index', [
            'header' => $header,
            'berita' => $berita
        ]);
    }


    // Method untuk halaman detail berita
    public function show(string $slug): View
    {
        $article = Berita::where('slug', $slug)->firstOrFail();

        //Hitungan Dibaca
        $article->increment('dibaca');

        // Ambil 4 berita terbaru lainnya (selain yang sedang dibuka) untuk sidebar
        $latestNews = Berita::where('slug', '!=', $slug)
                            ->orderBy('tgl_posting', 'desc')
                            ->take(5)
                            ->get();

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
            'article' => $articleData,
            'sidebarArticles' => $latestNews
        ]);
    }
}
