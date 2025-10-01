<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class BeritaController extends Controller
{
    /**
     * Menampilkan halaman detail sebuah berita.
     */
    public function show(string $slug): View
    {
        // --- DATA DUMMY (Nanti ini akan diambil dari database berdasarkan $slug) ---

        // Ini adalah struktur data yang ideal untuk konten fleksibel Anda
        $article = [
            'title' => 'Rapat Pembahasan Usulan Perubahan pada Pergub Kesejahteraan Sosial',
            'author' => 'Admin Dinsos',
            'date' => 'Kamis, 22 Agustus 2025',
            'views' => 321,
            'content' => [
                // Setiap elemen dalam array ini adalah satu "blok" konten.
                // Blok pertama selalu gambar utama/thumbnail.
                [
                    'type'    => 'image',
                    'url'     => 'berita1.jpg',
                    'caption' => 'Suasana rapat pembahasan yang berlangsung di aula utama.'
                ],
                [
                    'type'    => 'text',
                    'content' => 'Rapat dilaksanakan menindaklanjuti usulan perubahan Pergub No. 077/2022 tentang Tata Cara Penyelenggaraan Kesejahteraan Sosial. Rapat ini dilaksanakan karena adanya usulan perubahan Pasal 6 dan Pasal 7 pada Peraturan Gubernur Kalimantan Selatan Nomor 037 Tahun 2024 tentang Tata Cara Pelaksanaan Penyelenggaraan Kesejahteraan Sosial.'
                ],
                [
                    'type'    => 'text',
                    'content' => 'Diharapkan dengan dilaksanakan rapat ini dapat meningkatkan Kesejahteraan Sosial di Provinsi Kalimantan Selatan. Dalam rapat ini dihadiri oleh Kepala UPTD Dinas Sosial Prov.Kalsel beserta jajaran dari Biro Hukum Setda Prov.Kalsel.'
                ],
                [
                    'type'    => 'image',
                    'url'     => 'berita2.jpg',
                    'caption' => 'Peserta rapat memberikan masukan dan pandangan.'
                ],
                [
                    'type'    => 'image',
                    'url'     => 'berita5.jpg',
                    'caption' => 'Sesi diskusi panel setelah pemaparan materi utama.'
                ],
                // Perhatikan, tidak ada 'isikonten2'. Sistem akan langsung menampilkan
                // gambar2, lalu gambar3, sesuai urutan dalam array ini.
            ]
        ];

        // Kirim data artikel ke view
        return view('berita.show', [
            'article' => $article
        ]);
    }
}
