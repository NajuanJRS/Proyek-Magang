<?php

namespace App\Http\Controllers\pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfilController extends Controller
{
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
            $viewName = 'pengguna.profil.pejabat'; // Gunakan view khusus untuk halaman pejabat
            $viewData['pejabat'] = [
                'kepala' => [
                    'nama' => 'Drs. H. AHMAD FIKRI, M.AP',
                    'jabatan' => 'Kepala Dinas Sosial',
                    'sambutan' => 'Assalamualaikum Warahmatullahi Wabarakatuh. Selamat datang di portal digital resmi Dinas Sosial Provinsi Kalimantan Selatan...',
                    'foto' => 'foto-pejabat.jpg', // foto close up
                    'background' => 'gambar-kartu-pajabat.jpg' // foto background
                ],
                'lainnya' => [
                    ['nama' => 'MURJANI, S.Pd., M.M', 'jabatan' => 'Sekretaris', 'foto' => 'foto-pejabat1.jpg'],
                    ['nama' => 'H. ACHMADI, S.Sos', 'jabatan' => 'Sekretaris', 'foto' => 'foto-pejabat1.jpg'],
                    ['nama' => 'Drs. H. SURYA FUJIANORROCHIM, M.AP', 'jabatan' => 'Kepala Bidang Pemberdayaan Sosial', 'foto' => 'foto-pejabat1.jpg'],
                    ['nama' => 'ROKHADI, SE', 'jabatan' => 'Kepala Sub Bagian Keuangan dan Aset', 'foto' => 'foto-pejabat1.jpg'],
                ]
            ];
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
