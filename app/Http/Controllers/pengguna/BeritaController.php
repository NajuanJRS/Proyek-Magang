<?php

namespace App\Http\Controllers\pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\admin\Berita;
use App\Models\admin\Header;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class BeritaController extends Controller
{
    public function index(Request $request): View
    {
        $header = Cache::remember('header_berita', now()->addMinutes(60), function () {
            return Header::where('id_kategori_header', 4)->first();
        });

        $currentPage = $request->get('page', 1);
        $perPageFirst = 9;
        $perPageOthers = 12;

        $totalItems = Cache::remember('berita_total_count', now()->addMinutes(10), function () {
            return Berita::count();
        });

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

        $latestNews = Cache::remember('berita_sidebar_latest', now()->addMinutes(10), function () {
            return Berita::orderBy('tgl_posting', 'desc')
                            ->take(5)
                            ->get();
        });

        $sidebarArticles = $latestNews->reject(function ($item) use ($slug) {
            return $item->slug == $slug;
        });


        $content = [];
        if ($article->gambar1) {
            $content[] = ['type' => 'image', 'url' => $article->gambar1];
        }
        if ($article->isi_berita1) {
            $content[] = ['type' => 'text', 'content' => $article->isi_berita1];
        }
        if ($article->gambar3) {
            $content[] = ['type' => 'image', 'url' => $article->gambar3];
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
            'sidebarArticles' => $sidebarArticles
        ]);
    }
}
