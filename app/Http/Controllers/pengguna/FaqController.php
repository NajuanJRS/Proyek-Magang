<?php

namespace App\Http\Controllers\pengguna;

use App\Http\Controllers\Controller;
use App\Models\admin\Faq;
use App\Models\admin\KategoriFaq;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(Request $request, string $kategoriSlug = 'semua'): View
    {
        $keyword = $request->input('keyword');
        $kategoriList = KategoriFaq::all();

        $faqCounts = [];
        $totalCount = 0;

        $queryForAll = Faq::query();
        if ($keyword) {
            $queryForAll->where(function ($q) use ($keyword) {
                $q->where('pertanyaan', 'LIKE', "%{$keyword}%")
                  ->orWhere('jawaban', 'LIKE', "%{$keyword}%");
            });
        }
        $totalCount = $queryForAll->count();
        $faqCounts['semua'] = $totalCount;

        foreach ($kategoriList as $kategori) {
            $queryPerCategory = Faq::where('id_kategori_faq', $kategori->id_kategori_faq);
            if ($keyword) {
                $queryPerCategory->where(function ($q) use ($keyword) {
                    $q->where('pertanyaan', 'LIKE', "%{$keyword}%")
                      ->orWhere('jawaban', 'LIKE', "%{$keyword}%");
                });
            }
            $faqCounts[$kategori->slug] = $queryPerCategory->count();
        }

        $faqQuery = Faq::query();
        if ($kategoriSlug !== 'semua') {
            $faqQuery->whereHas('kategoriFaq', function ($query) use ($kategoriSlug) {
                $query->where('slug', $kategoriSlug);
            });
        }
        if ($keyword) {
            $faqQuery->where(function ($query) use ($keyword) {
                $query->where('pertanyaan', 'LIKE', "%{$keyword}%")
                      ->orWhere('jawaban', 'LIKE', "%{$keyword}%");
            });
        }
        $faqs = $faqQuery->get();

        return view('pengguna.faq.index', [
            'faqs' => $faqs,
            'kategoriList' => $kategoriList,
            'kategoriAktif' => $kategoriSlug,
            'keyword' => $keyword,
            'faqCounts' => $faqCounts
        ]);
    }
}

