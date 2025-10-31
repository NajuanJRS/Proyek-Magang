<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Faq;
use App\Models\admin\KategoriFaq;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache; // <--- 1. TAMBAHKAN INI

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        // ... (kode index tidak berubah) ...
        $search = $request->input('search');

        $faq = Faq::with('kategoriFaq') // eager load relasi kategori
            ->when($search, function ($query, $search) {
                $query->where('pertanyaan', 'like', "%$search%")
                    ->orWhereHas('kategoriFaq', function ($q) use ($search) {
                        $q->where('nama_kategori_faq', 'like', "%$search%");
                    });
            })->orderBy('id_faq', 'desc')
            ->paginate(10);

        return view('Admin.faq.faq', compact('faq'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        // ... (kode create tidak berubah) ...
        $kategoriFaq = KategoriFaq::all();
        return view('Admin.faq.formFaq', compact('kategoriFaq'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // ... (kode validasi tidak berubah) ...
        $request->validate([
            'kategori_faq' => 'required|exists:kategori_faq,id_kategori_faq',
            'id_user' => 'nullable|exists:user,id_user',
            'pertanyaan' => 'required|min:5',
            'jawaban' => 'required|min:5',
        ]);

        $idUser = Auth::check() && Auth::user()->role === 'admin'
        ? 1
        : Auth::id();

        Faq::create([
            'id_user' => $idUser,
            'id_kategori_faq' => $request->kategori_faq,
            'pertanyaan' => $request->pertanyaan,
            'jawaban' => $request->jawaban,
        ]);

        // <--- 2. PANGGIL FUNGSI PEMBERSIH CACHE
        $this->clearFaqCache();

        return redirect()->route('admin.faq.index')->with('success', 'FAQ Berhasil Ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // ... (kode edit tidak berubah) ...
        $faq = Faq::findOrFail($id);
        $kategoriFaq = KategoriFaq::all();
        return view('Admin.faq.formEditFaq', compact('faq', 'kategoriFaq'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // ... (kode validasi dan persiapan data tidak berubah) ...
        $request->validate([
            'id_user' => 'nullable|exists:user,id_user',
            'kategori_faq' => 'required|exists:kategori_faq,id_kategori_faq',
            'pertanyaan' => 'required|min:5',
            'jawaban' => 'required|min:5',
        ]);
        $faq = Faq::findOrFail($id);
        $idUser = Auth::check() && Auth::user()->role === 'admin'
        ? 1
        : Auth::id();

        $data = [
            'id_user'    => $idUser,
            'id_kategori_faq' => $request->kategori_faq,
            'pertanyaan' => $request->pertanyaan,
            'jawaban'    => $request->jawaban,
        ];

        $faq->update($data);

        // <--- 3. PANGGIL FUNGSI PEMBERSIH CACHE
        $this->clearFaqCache();

        return redirect()->route('admin.faq.index')->with('success', 'FAQ Berhasil Diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);

        $faq->delete();

        // <--- 4. PANGGIL FUNGSI PEMBERSIH CACHE
        $this->clearFaqCache();

        return redirect()->route('admin.faq.index')->with('success', 'FAQ Berhasil Dihapus!');
    }

    /**
     * Private function to clear all relevant FAQ caches.
     */
    // <--- 5. TAMBAHKAN FUNGSI BARU INI DI AKHIR CLASS
    private function clearFaqCache()
    {
        Cache::forget('faq_kategori_list');
        // 1. Bersihkan cache untuk 'faq_counts'
        Cache::forget('faq_counts');

        // 2. Bersihkan cache untuk 'faqs_semua'
        Cache::forget('faqs_semua');

        // 3. Loop semua kategori dan bersihkan cache dinamis mereka
        $kategoriList = KategoriFaq::all();
        foreach ($kategoriList as $kategori) {
            Cache::forget('faqs_' . $kategori->slug);
        }
    }
}
