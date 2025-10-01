<?php

namespace App\Http\Controllers\pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(string $kategori = 'umum'): View
    {
        // Data dummy untuk semua FAQ, diurutkan berdasarkan kategori
        $allFaqs = [
            'umum' => [
                ['q' => 'Apa itu Data Terpadu Kesejahteraan Sosial (DTKS)?', 'a' => 'DTKS adalah sistem data elektronik yang memuat informasi sosial, ekonomi, dan demografi dari individu dengan status kesejahteraan terendah di Indonesia.'],
                ['q' => 'Bagaimana cara terdaftar di DTKS?', 'a' => 'Pendaftaran dilakukan melalui musyawarah desa/kelurahan atau pengajuan mandiri ke dinas sosial setempat dengan membawa KTP dan KK.'],
            ],
            'bantuan-sosial' => [
                ['q' => 'Bagaimana cara mendapatkan bantuan sosial dari pemerintah?', 'a' => 'Syarat utamanya adalah terdaftar dalam DTKS. Bantuan akan disalurkan sesuai dengan program yang berjalan dan kriteria yang ditetapkan oleh pemerintah.'],
                ['q' => 'Apakah bisa mengaktifkan BPJS PBI di Dinas Sosial?', 'a' => 'Aktivasi atau pendaftaran BPJS PBI (Penerima Bantuan Iuran) dapat difasilitasi oleh Dinas Sosial bagi warga yang terdaftar dalam DTKS dan memenuhi syarat.'],
            ],
            'profil' => [
                ['q' => 'Apa visi dan misi Dinas Sosial?', 'a' => 'Visi kami adalah terwujudnya kesejahteraan sosial bagi seluruh masyarakat. Misi kami meliputi pemberdayaan, rehabilitasi, dan perlindungan sosial.'],
                ['q' => 'Di mana lokasi kantor Dinas Sosial?', 'a' => 'Kantor kami berlokasi di Jl. R. Soeprapto No. 8, Antasan Besar, Banjarmasin Tengah.'],
            ],
            'layanan' => [
                ['q' => 'Layanan apa saja yang tersedia?', 'a' => 'Kami menyediakan berbagai layanan seperti pemulangan orang terlantar, pengangkatan anak, penyaluran logistik bencana, dan lainnya.'],
                ['q' => 'Bagaimana prosedur pengangkatan anak?', 'a' => 'Prosedur pengangkatan anak melibatkan beberapa tahapan verifikasi dan validasi oleh tim kami untuk memastikan kesejahteraan anak.'],
            ]
        ];

        // Daftar kategori untuk ditampilkan sebagai tombol filter
        $kategoriList = [
            'umum' => 'Umum',
            'bantuan-sosial' => 'Bantuan Sosial',
            'profil' => 'Profil',
            'layanan' => 'Layanan',
        ];

        // Ambil data FAQ untuk kategori yang sedang aktif
        $activeFaqs = $allFaqs[$kategori] ?? $allFaqs['umum'];

        return view('pengguna.faq.index', [
            'faqs' => $activeFaqs,
            'kategoriList' => $kategoriList,
            'kategoriAktif' => $kategori
        ]);
    }
}
