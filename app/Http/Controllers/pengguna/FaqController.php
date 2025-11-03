<?php

namespace App\Http\Controllers\pengguna;

use App\Http\Controllers\Controller;
use App\Models\admin\Faq;
use App\Models\admin\KategoriFaq;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

class FaqController extends Controller
{
    public function index(Request $request, string $kategoriSlug = 'semua'): View
    {
        $keyword = $request->input('keyword');

        $kategoriList = Cache::remember('faq_kategori_list', now()->addHours(24), function () {
            return KategoriFaq::all();
        });

        if ($keyword) {


            $faqCounts = [];
            $totalCount = 0;

            $queryForAll = Faq::query();
            $queryForAll->where(function ($q) use ($keyword) {
                $q->where('pertanyaan', 'LIKE', "%{$keyword}%")
                  ->orWhere('jawaban', 'LIKE', "%{$keyword}%");
            });
            $totalCount = $queryForAll->count();
            $faqCounts['semua'] = $totalCount;

            foreach ($kategoriList as $kategori) {
                $queryPerCategory = Faq::where('id_kategori_faq', $kategori->id_kategori_faq);
                $queryPerCategory->where(function ($q) use ($keyword) {
                    $q->where('pertanyaan', 'LIKE', "%{$keyword}%")
                      ->orWhere('jawaban', 'LIKE', "%{$keyword}%");
                });
                $faqCounts[$kategori->slug] = $queryPerCategory->count();
            }

            $faqQuery = Faq::query();
            if ($kategoriSlug !== 'semua') {
                $faqQuery->whereHas('kategoriFaq', function ($query) use ($kategoriSlug) {
                    $query->where('slug', $kategoriSlug);
                });
            }
            $faqQuery->where(function ($query) use ($keyword) {
                $query->where('pertanyaan', 'LIKE', "%{$keyword}%")
                      ->orWhere('jawaban', 'LIKE', "%{$keyword}%");
            });
            $faqs = $faqQuery->get();

        } else {


            $faqCounts = Cache::remember('faq_counts', now()->addHours(1), function () use ($kategoriList) {
                $counts = [];
                $counts['semua'] = Faq::count();

                foreach ($kategoriList as $kategori) {
                    $counts[$kategori->slug] = $kategori->faqs()->count();
                }
                return $counts;
            });

            $faqCacheKey = 'faqs_' . $kategoriSlug;

            $faqs = Cache::remember($faqCacheKey, now()->addHours(1), function () use ($kategoriSlug) {
                $faqQuery = Faq::query();
                if ($kategoriSlug !== 'semua') {
                    $faqQuery->whereHas('kategoriFaq', function ($query) use ($kategoriSlug) {
                        $query->where('slug', $kategoriSlug);
                    });
                }
                return $faqQuery->with('kategoriFaq')->get();
            });
        }

        return view('pengguna.faq.index', [
            'faqs' => $faqs,
            'kategoriList' => $kategoriList,
            'kategoriAktif' => $kategoriSlug,
            'keyword' => $keyword,
            'faqCounts' => $faqCounts
        ]);
    }
}
