<?php

namespace App\Http\Controllers\pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\admin\Header;
use App\Models\admin\Pejabat;
use App\Models\admin\Jabatan;
use App\Models\admin\Galeri;
use App\Models\admin\KategoriKonten;

class ProfilController extends Controller
{
    public function index(): View
    {
        $header = Header::where('id_kategori_header', 2)->first();

        $cards = KategoriKonten::where('menu_konten', 'profil')->get();

        return view('pengguna.profil.index', [
            'header' => $header,
            'cards' => $cards
        ]);
    }

    public function show(string $slug): View
    {
        $allProfiles = KategoriKonten::where('menu_konten', 'profil')->get()->map(function ($profile) use ($slug) {
            $profile->active = $profile->slug == $slug;
            $profile->url = route('profil.show', $profile->slug);
            return $profile;
        });
        if ($slug == 'galeri-kami') {
            $galeriItems = Galeri::orderBy('tanggal_upload', 'desc')->get();

            return view('pengguna.profil.galeri', [
                'galeriItems' => $galeriItems,
                'allProfiles' => $allProfiles
            ]);
        }

        $viewName = 'pengguna.profil.show';
        $viewData = [];

        if ($slug == 'profil-singkat-pejabat') {
            $viewName = 'pengguna.profil.pejabat';

            $jabatanKepalaDinas = Jabatan::where('nama_jabatan', 'Kepala Dinas')->first();
            $pejabatKepala = $jabatanKepalaDinas ? Pejabat::with('jabatan')->where('id_jabatan', $jabatanKepalaDinas->id_jabatan)->first() : null;
            $pejabatLainnya = $jabatanKepalaDinas ? Pejabat::with('jabatan')->where('id_jabatan', '!=', $jabatanKepalaDinas->id_jabatan)->get() : collect();
            $kadisBackground = Header::where('id_kategori_header', 8)->first();

            $viewData['pejabatKepala'] = $pejabatKepala;
            $viewData['pejabatLainnya'] = $pejabatLainnya;
            $viewData['kadisBackground'] = $kadisBackground;

        } else {
            $activeCategory = KategoriKonten::where('slug', $slug)->firstOrFail();
            $profileContent = $activeCategory->konten;

            $viewData['activeCategory'] = $activeCategory;
            $viewData['profileContent'] = $profileContent;
        }

        $viewData['allProfiles'] = $allProfiles;

        return view($viewName, $viewData);
    }
}
