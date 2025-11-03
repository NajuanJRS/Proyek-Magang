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
use Illuminate\Support\Facades\Cache;

class ProfilController extends Controller
{
    public function index(): View
    {
        $durasiCache = now()->addMinutes(60);

        $header = Cache::remember('profil_header', $durasiCache, function () {
            return Header::where('id_kategori_header', 2)->first();
        });

        $cards = Cache::remember('profil_cards_menu', $durasiCache, function () {
            return KategoriKonten::where('menu_konten', 'profil')->get();
        });

        return view('pengguna.profil.index', [
            'header' => $header,
            'cards' => $cards
        ]);
    }

    public function show(string $slug): View
    {
        $durasiCache = now()->addMinutes(60);

        $baseProfiles = Cache::remember('profil_all_categories', $durasiCache, function() {
            return KategoriKonten::where('menu_konten', 'profil')->get();
        });

        $allProfiles = $baseProfiles->map(function ($profile) use ($slug) {
            $profile->active = $profile->slug == $slug;
            $profile->url = route('profil.show', $profile->slug);
            return $profile;
        });

        if ($slug == 'galeri-kami') {

            $galeriItems = Cache::remember('profil_galeri_items', $durasiCache, function () {
                return Galeri::orderBy('tanggal_upload', 'desc')->get();
            });

            return view('pengguna.profil.galeri', [
                'galeriItems' => $galeriItems,
                'allProfiles' => $allProfiles
            ]);
        }

        $viewName = 'pengguna.profil.show';
        $viewData = [];

        if ($slug == 'profil-singkat-pejabat') {
            $viewName = 'pengguna.profil.pejabat';

            $jabatanKepalaDinasId = Jabatan::where('nama_jabatan', 'Kepala Dinas')->first()?->id_jabatan;

            $pejabatKepala = Cache::remember('profil_pejabat_kepala', $durasiCache, function () use ($jabatanKepalaDinasId) {
                return $jabatanKepalaDinasId
                    ? Pejabat::with('jabatan')->where('id_jabatan', $jabatanKepalaDinasId)->first()
                    : null;
            });

            $pejabatLainnya = Cache::remember('profil_pejabat_lainnya', $durasiCache, function () use ($jabatanKepalaDinasId) {
                return $jabatanKepalaDinasId
                    ? Pejabat::with('jabatan')->where('id_jabatan', '!=', $jabatanKepalaDinasId)->get()
                    : collect();
            });

            $kadisBackground = Cache::remember('profil_pejabat_background', $durasiCache, function () {
                return Header::where('id_kategori_header', 8)->first();
            });

            $viewData['pejabatKepala'] = $pejabatKepala;
            $viewData['pejabatLainnya'] = $pejabatLainnya;
            $viewData['kadisBackground'] = $kadisBackground;

        } else {
            $activeCategory = Cache::remember('profil_kategori_' . $slug, $durasiCache, function () use ($slug) {
                return KategoriKonten::with('konten')->where('slug', $slug)->firstOrFail();
            });
            $profileContent = $activeCategory->konten;

            $viewData['activeCategory'] = $activeCategory;
            $viewData['profileContent'] = $profileContent;
        }

        $viewData['allProfiles'] = $allProfiles;

        return view($viewName, $viewData);
    }
}
