<?php

namespace App\Http\Controllers\pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\admin\Header;

class PpidController extends Controller
{
    public function index(): View
    {
        // Ambil header untuk halaman download (asumsi id_kategori_header = 4)
        $header = Header::where('id_kategori_header', 6)->first();

        // Kirim data header ke view
        return view('pengguna.ppid.index', [
            'header' => $header
        ]);
    }
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

        $viewName = 'pengguna.ppid.show'; // Default view
        $viewData = [];

        // === LOGIKA BARU UNTUK HALAMAN SPESIFIK ===
        if ($slug == 'profil') {
            // Konten untuk halaman "Profil PPID"
            $viewData['pageContent'] = [
            'title' => 'Profil PPID',
            'content' => "<p>PPID adalah kepanjangan dari Pejabat Pengelola Informasi dan Dokumentasi, dimana PPID berfungsi sebagai pengelola dan penyampai dokumen yang dimiliki oleh badan publik sesuai dengan amanat Undang-Undang Nomor 14 tahun 2008 tentang Keterbukaan Informasi Publik. Dengan keberadaan PPID maka pemohon informasi tidak perlu bersurat dan menunggu lama untuk mendapatkan jawaban.</p><h4>Visi dan Misi PPID</h4><p><strong>Visi</strong>: MEWUJUDKAN PELAYANAN INFORMASI SECARA TRANSPARAN DAN AKUNTABEL UNTUK MASYARAKAT INFORMASI</p><p><strong>Misi</strong>: 1. Meningkatkan pelayanan informasi yang berkualitas. 2. Meningkatkan partisipasi masyarakat dalam keterbukaan informasi publik.</p><h4>Tugas dan Tanggung Jawab PPID</h4><p>PPID bertugas dan bertanggungjawab mengkoordinasikan dan mengkonsolidasikan pengumpulan bahan informasi dan dokumentasi dari PPID Pelaksana/Pembantu. PPID juga menyimpan, mendokumentasikan, menyediakan dan memberi pelayanan informasi kepada publik.</p>",
            'image' => 'struktur-ppid.jpg',
            // === KONTEN BARU DITAMBAHKAN DI SINI ===
            'additional_content' => "<h4>PPID Pelaksana</h4><p>PPID Pelaksana bertanggung jawab melaksanakan layanan Informasi Publik di masing-masing unit/satuan kerja. PPID Pelaksana berwenang mengkoordinasikan dan mengkonsolidasikan pengumpulan bahan informasi dan dokumentasi dari masing-masing unit kerjanya.</p><h4>PPID Pembantu</h4><p>PPID Pembantu juga bertanggung jawab untuk membantu PPID utama dalam melaksanakan tugas dan fungsinya. Mereka berada di bawah koordinasi PPID utama dan membantu dalam proses pengelolaan serta pelayanan informasi di tingkat yang lebih spesifik.</p>"
            ];
        } elseif ($slug == 'informasi-publik') {
            // Konten untuk halaman "Keterbukaan Informasi Publik"
            $viewName = 'pengguna.ppid.informasi_publik'; // Gunakan view baru
            $viewData['pageContent'] = [
                'title' => 'Keterbukaan Informasi Publik',
                'files' => [
                    ['name' => 'Rencana Kerja Pemerintah Daerah (RKPD) Prov. Kalimantan Selatan Tahun 2024', 'filename' => 'sample.pdf'],
                    ['name' => 'Dokumen Laporan Kinerja Pemerintah Provinsi Kalimantan Selatan Tahun 2023', 'filename' => 'sample.pdf'],
                    ['name' => 'Program strategis atau prioritas Pemerintah Provinsi Kalimantan Selatan Tahun 2024, berdasarkan RKPD 2024', 'filename' => 'sample.pdf'],
                    ['name' => 'Agenda penting terkait pelaksanaan tugas Pemerintah Provinsi Kalimantan Selatan', 'filename' => 'sample.pdf'],
                    ['name' => 'Arsip Laporan Keuangan Pemerintah Provinsi Kalimantan Selatan Tahun 2023', 'filename' => 'sample.pdf'],
                    ['name' => 'Arsip Dokumen Laporan Keuangan Tahun 2024', 'filename' => 'sample.pdf'],
                ]
            ];
        } elseif ($slug == 'prosedur-permohonan-keberatan') {
            // Konten untuk halaman "Prosedur Permohonan & Keberatan"
            $viewName = 'pengguna.ppid.prosedur'; // Gunakan view baru
            $viewData['pageContent'] = [
                'title' => 'Prosedur Permohonan & Keberatan',
                'content' => "
                    <h4>TATA CARA MEMPEROLEH INFORMASI PUBLIK DAN TATA CARA INFORMASI PENGAJUAN KEBERATAN DAN PROSES PENYELESAIAN SENGKETA INFORMASI PUBLIK</h4>
                    
                    <h5>Langkah 1: Mengajukan Permohonan Informasi</h5>
                    <p>Permohonan mengajukan permohonan melalui website, e-mail, surat atau datang langsung ke PPID Badan Publik.</p>
                    
                    <h5>Langkah 2: Meja Layanan Informasi</h5>
                    <p>Pemohon mengisi formulir dengan menyertakan salinan identitas. Petugas melakukan registrasi dan memberikan bukti permohonan.</p>
                    
                    <h5>Langkah 3: PPID</h5>
                    <p>Memberikan tanggapan permohonan dalam jangka waktu 10 hari kerja, + 5 hari kerja jika informasi tidak dikuasai.</p>
                    
                    <h5>Langkah 4: Pemohon Informasi</h5>
                    <p>✔ Permohonan SELESAI jika pemohon PUAS<br>✖ Mengajukan keberatan dalam jangka waktu 30 hari kerja kepada Atasan PPID jika pemohon TIDAK PUAS.</p>
                    
                    <h5>Langkah 5: Atasan PPID</h5>
                    <p>Memberikan tanggapan tertulis atas keberatan yang diajukan selambat-lambatnya 30 hari kerja.</p>
                    
                    <h5>Langkah 6: Komisi Informasi</h5>
                    <p>Jika TIDAK PUAS dengan keputusan Atasan PPID, pemohon dapat mengajukan keberatan ke Komisi Informasi dalam jangka waktu 14 hari kerja.</p>
                    
                    <hr class='my-4'>
                    
                    <h4>Tata Cara Penyelesaian Sengketa Informasi</h4>
                    <p><strong>Tata Cara Pengajuan Permohonan Penyelesaian Sengketa ke Komisi Informasi:</strong></p>
                    <p>Permohonan Penyelesaian Sengketa Informasi dapat diajukan secara langsung (datang langsung), melalui permohonan secara tertulis (surat) dikirim melalui email atau surat tercatat dan secara online di ppid.kalselprov@gmail.com</p>
                    <p><strong>Permohonan Penyelesaian Sengketa Informasi Secara Langsung:</strong></p>
                    <ol type='a'>
                        <li>Pemohon mengisi Form Permohonan Penyelesaian Sengketa Informasi yang telah disediakan petugas;</li>
                        <li>Membawa bukti surat permohonan informasi kepada Badan Publik dan tanda terimanya;</li>
                        <li>Membawa bukti jawaban permohonan informasi dari Badan Publik beserta tanda terimanya (jika ada);</li>
                        <li>Membawa bukti pengajuan keberatan kepada Badan Publik dan tanda terimanya;</li>
                    </ol>
                "
            ];
        }
        // Tambahkan elseif untuk slug 'prosedur-permohonan-keberatan' nanti di sini

        $viewData['allPpidItems'] = $ppidItemsWithStatus;
        
        return view($viewName, $viewData);
    }
}
