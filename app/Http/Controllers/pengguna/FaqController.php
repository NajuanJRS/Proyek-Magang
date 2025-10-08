<?php

namespace App\Http\Controllers\pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\admin\Faq;

class FaqController extends Controller
{
    public function index(string $kategori = 'umum'): View
    {
        // Data dummy untuk semua FAQ, diurutkan berdasarkan kategori
        $allFaqs = Faq::all();

        // Daftar kategori untuk ditampilkan sebagai tombol filter
        $kategoriList = [
            'umum' => 'Umum',
            'bantuan-sosial' => 'Bantuan Sosial',
            'profil' => 'Profil',
            'layanan' => 'Layanan',
        ];

        // Ambil data FAQ untuk kategori yang sedang aktif
        $activeFaqs = [];
        if ($kategori == 'umum') {
            $activeFaqs = $allFaqs->map(function ($faq) {
                return ['q' => $faq->pertanyaan, 'a' => $faq->jawaban];
            })->all();
        }

        return view('pengguna.faq.index', [
            'faqs' => $activeFaqs,
            'kategoriList' => $kategoriList,
            'kategoriAktif' => $kategori
        ]);
    }
}
