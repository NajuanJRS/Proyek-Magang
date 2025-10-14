<?php

namespace App\Http\Controllers\pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\admin\Header;
use App\Models\admin\Pejabat;
use App\Models\admin\Jabatan;
use App\Models\admin\Konten;
use App\Models\admin\KategoriKonten;

class ProfilController extends Controller
{
    public function index(): View
    {
        // Ambil data header dari database (id_kategori_header = 2)
        $header = Header::where('id_kategori_header', 2)->first();

        // Ambil semua kartu kategori yang termasuk dalam 'profil'
        $cards = KategoriKonten::where('menu_konten', 'profil')->get();

        return view('pengguna.profil.index', [
            'header' => $header,
            'cards' => $cards // Perbaikan typo dari 'crads' menjadi 'cards'
        ]);
    }

    public function show(string $slug): View
    {
        // Ambil semua item profil dari database untuk sidebar
        $allProfiles = KategoriKonten::where('menu_konten', 'profil')->get()->map(function ($profile) use ($slug) {
            $profile->active = $profile->slug == $slug;
            $profile->url = route('profil.show', $profile->slug);
            return $profile;
        });

        $viewName = 'pengguna.profil.show'; // Default view untuk halaman profil biasa
        $viewData = [];

        // Logika untuk menangani halaman-halaman spesifik
        if ($slug == 'pejabat') {
            $viewName = 'pengguna.profil.pejabat'; // Gunakan view khusus untuk halaman pejabat

            $jabatanKepalaDinas = Jabatan::where('nama_jabatan', 'Kepala Dinas')->first();
            $pejabatKepala = $jabatanKepalaDinas ? Pejabat::with('jabatan')->where('id_jabatan', $jabatanKepalaDinas->id_jabatan)->first() : null;
            $pejabatLainnya = $jabatanKepalaDinas ? Pejabat::with('jabatan')->where('id_jabatan', '!=', $jabatanKepalaDinas->id_jabatan)->get() : collect();
            $kadisBackground = Header::where('id_kategori_header', 8)->first();

            $viewData['pejabatKepala'] = $pejabatKepala;
            $viewData['pejabatLainnya'] = $pejabatLainnya;
            $viewData['kadisBackground'] = $kadisBackground;

        } elseif ($slug == 'struktur-organisasi') {
            $viewName = 'pengguna.profil.struktur'; // Gunakan view khusus untuk struktur

            $activeCategory = KategoriKonten::where('slug', $slug)->firstOrFail();
            $konten = $activeCategory->konten;

            $viewData['pageData'] = [
                'title' => $activeCategory->judul_konten,
                'image' => $konten->gambar1 ?? 'default.jpg' // Ambil gambar dari tabel konten
            ];

        } else {
            // Logika untuk halaman profil lainnya (Sejarah, Visi Misi, dll.)
            $activeCategory = KategoriKonten::where('slug', $slug)->firstOrFail();
            $profileContent = $activeCategory->konten;

            $viewData['activeCategory'] = $activeCategory;
            $viewData['profileContent'] = $profileContent;
        }

        $viewData['allProfiles'] = $allProfiles;

        return view($viewName, $viewData);
    }
}
