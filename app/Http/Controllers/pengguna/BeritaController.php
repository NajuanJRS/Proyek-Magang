<?php

namespace App\Http\Controllers\pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\admin\Berita;
use App\Models\admin\Header;
use Illuminate\Pagination\LengthAwarePaginator;

class BeritaController extends Controller
{
    public function index(Request $request): View
    {
        $header = Header::where('id_kategori_header', 4)->first();
        $currentPage = $request->get('page', 1);

        $perPageFirst = 9;
        $perPageOthers = 12;

        $totalItems = Berita::count();

        $offset = 0;
        if ($currentPage > 1) {
            $offset = $perPageFirst + ($currentPage - 2) * $perPageOthers;
        }

        $itemsToTake = ($currentPage == 1) ? $perPageFirst : $perPageOthers;

        $beritaItems = Berita::orderBy('tgl_posting', 'desc')
                            ->skip($offset)
                            ->take($itemsToTake)
                            ->get();

        $berita = new LengthAwarePaginator(
            $beritaItems,
            $totalItems,
            $perPageOthers,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('pengguna.berita.index', [
            'header' => $header,
            'berita' => $berita
        ]);
    }


    public function show(string $slug): View
    {
        $article = Berita::where('slug', $slug)->firstOrFail();

        $article->increment('dibaca');

        $latestNews = Berita::where('slug', '!=', $slug)
                            ->orderBy('tgl_posting', 'desc')
                            ->take(5)
                            ->get();

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
        if ($article->isi_berita3) {
            $content[] = ['type' => 'text', 'content' => $article->isi_berita3];
        }


        $articleData = [
            'title' => $article->judul,
            'author' => 'Admin Dinsos',
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
