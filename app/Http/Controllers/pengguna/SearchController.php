<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(Request $request): View
    {
        // Ambil input keyword dan kategori dari URL
        $keyword = $request->input('keyword');
        $activeFilter = $request->input('kategori', 'semua'); // Defaultnya 'semua'

        // Opsi filter untuk ditampilkan di view
        $filters = [
            ['name' => 'Semua', 'count' => 10, 'slug' => 'semua'],
            ['name' => 'Berita & Kegiatan', 'count' => 4, 'slug' => 'berita'],
            ['name' => 'Layanan', 'count' => 2, 'slug' => 'layanan'],
            ['name' => 'Dokumen & Download', 'count' => 2, 'slug' => 'dokumen'],
            ['name' => 'Profil & Informasi', 'count' => 2, 'slug' => 'profil'],
        ];

        // --- Data Dummy untuk Hasil Pencarian ---
        $allResults = [
            ['title' => 'Penyaluran Bantuan Logistik Tahap II untuk Korban Banjir', 'url' => '#', 'date' => '26/08/2025', 'category' => 'Berita', 'category_slug' => 'berita', 'summary' => 'Dinas Sosial Provinsi Kalimantan Selatan kembali menyalurkan bantuan logistik berupa sembako dan perlengkapan tidur untuk warga terdampak...'],
            ['title' => 'Dinsos Kalsel Gelar Bimbingan Teknis Peningkatan Kapasitas Pendamping', 'url' => '#', 'date' => '22/08/2025', 'category' => 'Berita', 'category_slug' => 'berita', 'summary' => 'Sebanyak 150 pendamping Program Keluarga Harapan (PKH) dari seluruh kabupaten/kota mengikuti bimbingan teknis untuk meningkatkan kualitas...'],
            ['title' => 'Gubernur Serahkan Bantuan UEP Secara Simbolis', 'url' => '#', 'date' => '20/08/2025', 'category' => 'Berita', 'category_slug' => 'berita', 'summary' => 'Bantuan Usaha Ekonomi Produktif (UEP) diserahkan secara langsung oleh Gubernur Kalimantan Selatan sebagai upaya pengentasan kemiskinan...'],
            ['title' => 'Evaluasi Program RTLH Tahun Anggaran 2024 Capai Target', 'url' => '#', 'date' => '17/08/2025', 'category' => 'Berita', 'category_slug' => 'berita', 'summary' => 'Program rehabilitasi rumah tidak layak huni dilaporkan telah berhasil merealisasikan target tahunan dengan lebih dari 500 unit rumah diperbaiki...'],
            ['title' => 'Prosedur Pengangkatan Anak', 'url' => '#', 'date' => '19/08/2025', 'category' => 'Layanan', 'category_slug' => 'layanan', 'summary' => 'Berikut adalah tahapan dan persyaratan yang harus dipenuhi untuk melakukan proses pengangkatan anak secara legal melalui Dinas Sosial...'],
            ['title' => 'Pemulangan Orang Telantar', 'url' => '#', 'date' => '16/08/2025', 'category' => 'Layanan', 'category_slug' => 'layanan', 'summary' => 'Layanan ini bertujuan untuk membantu memulangkan orang telantar ke daerah asal mereka dengan aman dan bermartabat.'],
            ['title' => 'Formulir Pendaftaran Lembaga Kesejahteraan Sosial', 'url' => '#', 'date' => '15/08/2025', 'category' => 'Dokumen', 'category_slug' => 'dokumen', 'summary' => 'Unduh formulir resmi untuk pendaftaran Lembaga Kesejahteraan Sosial (LKS) di wilayah Provinsi Kalimantan Selatan.'],
            ['title' => 'Laporan Kinerja Tahun 2024', 'url' => '#', 'date' => '14/08/2025', 'category' => 'Dokumen', 'category_slug' => 'dokumen', 'summary' => 'Dokumen Laporan Akuntabilitas Kinerja Instansi Pemerintah (LAKIP) Dinas Sosial Provinsi Kalimantan Selatan untuk tahun anggaran 2024.'],
            ['title' => 'Visi dan Misi Dinas Sosial', 'url' => '#', 'date' => '12/08/2025', 'category' => 'Profil', 'category_slug' => 'profil', 'summary' => 'Visi kami adalah Kalsel Maju (Kalimantan Selatan Makmur, Sejahtera, dan Berkelanjutan) sebagai gerbang menuju Ibu Kota Negara...'],
            ['title' => 'Struktur Organisasi', 'url' => '#', 'date' => '10/08/2025', 'category' => 'Profil', 'category_slug' => 'profil', 'summary' => 'Lihat bagan struktur organisasi resmi Dinas Sosial Provinsi Kalimantan Selatan, lengkap dengan tugas pokok dan fungsi setiap bidang.'],
        ];

        // --- Logika Filter ---
        if ($activeFilter && $activeFilter !== 'semua') {
            $filteredResults = array_filter($allResults, function ($result) use ($activeFilter) {
                return $result['category_slug'] == $activeFilter;
            });
        } else {
            $filteredResults = $allResults;
        }

        // Kirim semua data yang diperlukan ke view
        return view('pencarian.index', [
            'keyword' => $keyword,
            'filters' => $filters,
            'results' => $filteredResults,
            'activeFilter' => $activeFilter,
        ]);
    }
}