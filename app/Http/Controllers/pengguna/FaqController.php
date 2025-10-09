<?php

namespace App\Http\Controllers\pengguna;

use App\Http\Controllers\Controller;
use App\Models\admin\Faq;
use App\Models\admin\KategoriFaq;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(string $kategoriSlug = 'umum'): View
        {
            // Ambil semua kategori dari database untuk tombol filter
            $kategoriList = KategoriFaq::all();

            // Ambil data FAQ berdasarkan slug kategori yang aktif dari URL
            $faqs = Faq::whereHas('kategoriFaq', function ($query) use ($kategoriSlug) {
                $query->where('slug', $kategoriSlug);
            })->get();

            // Kirim data yang sudah difilter ke view
            return view('pengguna.faq.index', [
                'faqs' => $faqs,
                'kategoriList' => $kategoriList,
                'kategoriAktif' => $kategoriSlug
            ]);
        }
}
