<?php

namespace App\Http\Controllers\pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PpidController extends Controller
{
    public function show(string $slug): View
    {
        // --- DATA DUMMY (Nanti ini akan diambil dari database) ---

        // Daftar semua item PPID untuk sidebar
        $allPpidItems = [
            ['title' => 'Profil PPID', 'img' => 'Profil_PPID.png', 'slug' => 'profil'],
            ['title' => 'Keterbukaan Informasi Publik', 'img' => 'Keterbukaan_Informasi_Publik.png', 'slug' => 'informasi-publik'],
            ['title' => 'Prosedur Permohonan & Keberatan', 'img' => 'Tata_Cara_Memperoleh_Informasi_dan_Pengajuan_Keberatan.png', 'slug' => 'prosedur-permohonan-keberatan'],
        ];

        // Menandai item mana yang sedang aktif
        $ppidItemsWithStatus = array_map(function ($item) use ($slug) {
            $item['active'] = $item['slug'] == $slug;
            $item['url'] = url('/ppid/' . $item['slug']);
            return $item;
        }, $allPpidItems);

        // Konten utama untuk halaman "Profil PPID" (TELAH DIPERBARUI)
        $pageContent = [
            'title' => 'Profil PPID',
            'content' => "<p>PPID adalah kepanjangan dari Pejabat Pengelola Informasi dan Dokumentasi, dimana PPID berfungsi sebagai pengelola dan penyampai dokumen yang dimiliki oleh badan publik sesuai dengan amanat Undang-Undang Nomor 14 tahun 2008 tentang Keterbukaan Informasi Publik. Dengan keberadaan PPID maka pemohon informasi tidak perlu bersurat dan menunggu lama untuk mendapatkan jawaban.</p><h3>Visi dan Misi PPID</h3><p><strong>Visi</strong>: MEWUJUDKAN PELAYANAN INFORMASI SECARA TRANSPARAN DAN AKUNTABEL UNTUK MASYARAKAT INFORMASI</p><p><strong>Misi</strong>: 1. Meningkatkan pelayanan informasi yang berkualitas. 2. Meningkatkan partisipasi masyarakat dalam keterbukaan informasi publik.</p><h3>Tugas dan Tanggung Jawab PPID</h3><p>PPID bertugas dan bertanggungjawab mengkoordinasikan dan mengkonsolidasikan pengumpulan bahan informasi dan dokumentasi dari PPID Pelaksana/Pembantu. PPID juga menyimpan, mendokumentasikan, menyediakan dan memberi pelayanan informasi kepada publik.</p>",
            'image' => 'struktur-ppid.jpg',
            // === KONTEN BARU DITAMBAHKAN DI SINI ===
            'additional_content' => "<h3>PPID Pelaksana</h3><p>PPID Pelaksana bertanggung jawab melaksanakan layanan Informasi Publik di masing-masing unit/satuan kerja. PPID Pelaksana berwenang mengkoordinasikan dan mengkonsolidasikan pengumpulan bahan informasi dan dokumentasi dari masing-masing unit kerjanya.</p><h3>PPID Pembantu</h3><p>PPID Pembantu juga bertanggung jawab untuk membantu PPID utama dalam melaksanakan tugas dan fungsinya. Mereka berada di bawah koordinasi PPID utama dan membantu dalam proses pengelolaan serta pelayanan informasi di tingkat yang lebih spesifik.</p>"
        ];

        return view('pengguna.ppid.show', [
            'pageContent' => $pageContent,
            'allPpidItems' => $ppidItemsWithStatus
        ]);
    }
}