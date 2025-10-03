<?php

namespace App\Http\Controllers\pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\admin\Header;
use App\Models\admin\Pejabat;
use App\Models\admin\Jabatan;

class ProfilController extends Controller
{
    public function index(): View
    {
        // Ambil data header dari database di mana id_kategori_header adalah 2
        // Kita gunakan 'first()' karena kita hanya butuh satu data header untuk halaman ini
        $header = Header::where('id_kategori_header', 2)->first();

        // Kirim data header ke view
        return view('pengguna.profil.index', [
            'header' => $header
        ]);
    }

    public function show(string $slug): View
    {
        // --- DATA DUMMY (Nanti ini akan diambil dari database) ---

        $allProfiles = [
            ['title' => 'Sejarah Dinas Sosial', 'img' => 'sejarah.png', 'slug' => 'sejarah'],
            ['title' => 'Visi dan Misi Dinas Sosial', 'img' => 'visi-misi.png', 'slug' => 'visi-misi'],
            ['title' => 'Tugas Pokok dan Fungsi', 'img' => 'tupoksi.png', 'slug' => 'tugas-pokok-fungsi'],
            ['title' => 'Struktur Organisasi', 'img' => 'struktur.png', 'slug' => 'struktur-organisasi'],
            ['title' => 'Ruang Lingkup', 'img' => 'ruang-lingkup.png', 'slug' => 'ruang-lingkup'],
            ['title' => 'Profil Singkat Pejabat', 'img' => 'pejabat.png', 'slug' => 'pejabat'],
            ['title' => 'Peraturan, Keputusan, dan Kebijakan', 'img' => 'peraturan.png', 'slug' => 'peraturan'],
        ];

        $profilesWithStatus = array_map(function ($profile) use ($slug) {
            $profile['active'] = $profile['slug'] == $slug;
            $profile['url'] = url('/profil/' . $profile['slug']);
            return $profile;
        }, $allProfiles);

        $viewName = 'pengguna.profil.show'; // Default view
        $viewData = [];

        // === LOGIKA BARU UNTUK HALAMAN SPESIFIK ===
        if ($slug == 'pejabat') {
            $viewName = 'pengguna.profil.pejabat';

            // Ambil ID Jabatan untuk 'Kepala Dinas'
            $jabatanKepalaDinas = Jabatan::where('nama_jabatan', 'Kepala Dinas')->first();

            // Ambil data Kepala Dinas
            $pejabatKepala = Pejabat::with('jabatan')
                                    ->where('id_jabatan', $jabatanKepalaDinas->id_jabatan)
                                    ->first();

            // Ambil data pejabat lainnya (selain Kepala Dinas)
            $pejabatLainnya = Pejabat::with('jabatan')
                                     ->where('id_jabatan', '!=', $jabatanKepalaDinas->id_jabatan)
                                     ->get();

            $viewData['pejabatKepala'] = $pejabatKepala;
            $viewData['pejabatLainnya'] = $pejabatLainnya;
            
        }elseif ($slug == 'struktur-organisasi') {
            $viewName = 'pengguna.profil.struktur'; // Gunakan view baru untuk struktur
            $viewData['pageData'] = [
                'title' => 'Struktur Organisasi Dinas Sosial Provinsi Kalimantan Selatan',
                'image' => 'struktur-organisasi.jpg'
            ];
        }else {
            // Logika untuk halaman profil lainnya (contoh: Sejarah)
            $viewData['profileContent'] = [
                'title' => 'Sejarah Dinas Sosial',
                'content' => "<p>Cikal bakal lembaga yang menangani kesejahteraan sosial di Indonesia dimulai sesaat setelah proklamasi kemerdekaan...</p>"
            ];
        }

        $viewData['allProfiles'] = $profilesWithStatus;

        return view($viewName, $viewData);
    }
}
