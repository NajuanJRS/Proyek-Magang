<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class LayananController extends Controller
{
    public function show(string $slug): View
    {
        // --- DATA DUMMY (Nanti ini akan diambil dari database) ---

        // Daftar semua layanan untuk sidebar, diambil dari array yang Anda berikan.
        $allServices = [
            ['title' => 'Pemulangan Orang Telantar', 'img' => 'pemulangan_orang_telantar.png', 'slug' => 'pemulangan-orang-telantar'],
            ['title' => 'Pendaftaran Lembaga Kesejahteraan Sosial (LKS)', 'img' => 'penerbitan_surat_tanda_pendaftaran_lembaga_kesejahteraan_sosial.png', 'slug' => 'pendaftaran-lks'],
            ['title' => 'Prosedur Pengangkatan Anak', 'img' => 'prosedur_pengangkatan_anak.png', 'slug' => 'prosedur-pengangkatan-anak'],
            ['title' => 'Penyaluran Logistik Bufferstock Bencana', 'img' => 'penyaluran_logistik_bufferstock_bencana.png', 'slug' => 'penyaluran-logistik-bencana'],
            ['title' => 'Bantuan Usaha Ekonomi Produktif (UEP)', 'img' => 'penetapan_penerima_bantuan_uep.png', 'slug' => 'penetapan-bantuan-uep'],
            ['title' => 'Prosedur Pengusulan Gelar Pahlawan Nasional', 'img' => 'prosedur_pengusulan_gelar_pahlawan_nasional.png', 'slug' => 'pengusulan-gelar-pahlawan'],
            ['title' => 'Program Perbaikan Rumah (RS-RTLH)', 'img' => 'penetapan_penerima_bantuan_rehabilitasi_sosial_rtlhs.png', 'slug' => 'penetapan-bantuan-rtlhs'],
            ['title' => 'Izin Undian Gratis Berhadiah (UGB)', 'img' => 'penerbitan_surat_pertimbangan_teknis_penyelenggaraan_ugb.png', 'slug' => 'penerbitan-surat-ugb'],
            ['title' => 'Izin Pengumpulan Uang & Barang (PUB)', 'img' => 'penerbitan_surat_pertimbangan_teknis_penyelenggaraan_pub.png', 'slug' => 'penerbitan-surat-pub'],
            ['title' => 'Prosedur Seleksi Klien pada Panti Sosial Dinas', 'img' => 'prosedur_seleksi_klien_pada_panti_sosial.png', 'slug' => 'prosedur-seleksi-klien-panti'],
        ];

        // Menandai layanan mana yang sedang aktif berdasarkan slug dari URL
        $servicesWithStatus = array_map(function ($service) use ($slug) {
            $service['active'] = $service['slug'] == $slug;
            $service['url'] = url('/layanan/' . $service['slug']);
            return $service;
        }, $allServices);

        // Ambil data konten utama (untuk sementara kita hardcode)
        $serviceContent = [
            'title' => 'Pemulangan Orang Telantar',
            'content' => "
                <h4>Persyaratan yang Perlu Disiapkan</h4>
                <ol>
                <li>Mempunyai Kartu Tanda Penduduk atau Surat Keterangan Penduduk sesuai domisili yang bersangkutan;</li>
                <li>Orang Terlantar hanya dapat dipulangkan sesuai Alamat di Identitas Diri;</li>
                <li>Surat pengantar dari Dinas Sosial Kabupaten/Kota;</li>
                <li>Surat pengantar dari Kepolisian setempat;</li>
                <li>Surat penerusan Orang Terlantar dari Dinas Sosial Provinsi;</li>
                <li>Surat Keluar / Bebas dari Lembaga Pemasyarakatan (LAPAS), untuk napi yang habis masa hukumannya / keluar Lembaga Pemasyarakatan akibat melakukan pelanggaran hukum di wilayah hukum Provinsi Kalimantan Selatan;</li>
                <li>Surat Pengantar dari Syahbandar Pelabuhan bagi Korban Kecelakaan Perahu, Kapal Terdampar di wilayah Provinsi Kalimantan Selatan;</li>
                <li>Orang Terlantar kehilangan harta benda dalam wilayah hukum Provinsi Kalimantan Selatan;</li>
                <li>Orang Terlantar mencari keluarga dan tidak ditemukan di wilayah Provinsi Kalimantan Selatan;</li>
                <li>Repatriasi / pelintas batas WNI di negara lain;</li>
                <li>Terdampak bencana alam dan bencana sosial termasuk korban konflik sosial;</li>
                <li>Orang Terlantar tidak sakit (dapat beraktifitas tanpa bantuan orang lain).</li>
                </ol>
                <h3>Langkah-langkah Prosedur</h3>
                <ol>
                <li>Pemulangan / penelusuran Orang Terlantar yang dikirimkan ke Dinas Sosial Provinsi Kalimantan Selatan dalam kondisi SEHAT FISIK dan SEHAT ROHANI, apabila sakit agar di rawat di Rumah Sakit di daerahnya masing-masing sampai kondisinya pulih kembali. Kondisi sakit kami tidak akan meneruskan pemulangan ke tempat asalnya, termasuk sakit jiwa;</li>
                <li>Sebelum pemulangan/penerusan Orang Terlantar dilakukan wawancara terlebih dahulu oleh Dinas Sosial Kabupaten/Kota agar mengetahui permasalahan yang terjadi sebelum diteruskan ke Dinas Sosial Provinsi Kalimantan Selatan, hasil wawancara agar dilampirkan;</li>
                <li>Dinas Sosial Kabupaten / Kota menyeleksi dengan ketat proses pemulangan orang terlantar ke tempat asalnya, terutama yang tidak memiliki Identitas Pengenal / KTP, yang tidak memiliki Identitas Pengenal tidak memulangkan dan atau meneruskannya;</li>
                <li>Pemulangan / penerusan Orang Terlantar hanya menggunakan angkutan umum berupa angkutan darat/bis atau angkutan laut/kapal BUKAN angkutan pesawat udara, karena anggaran yang tersedia sangat terbatas dan Tiket yang sudah disiapkan tidak bisa dirubah atau dalam bentuk uang atau dperjualbelikan;</li>
                <li>Pemulangan / penerusan Orang Terlantar akibat kecelakaan perahu/kapal terdampar melampirkan Surat Keterangan dari Kepolisian Perairan atau Kantor Syahbandar Pelabuhan;</li>
                <li>Pemulangan / penerusan Orang Terlantar TIDAK diberikan pelayanan kepada Pencari Kerja ke suatu daerah dan atau berhenti dari perusahaan akibat gaji terlalu kecil atau tidak sesuai perjanjian/kontrak kerja;</li>
                <li>Pemulangan/penerusan Orang Terlantar ke tempat asalnya ke wilayah Kabupaten/Kota dalam Provinsi Kalimantan Selatan dan atau ke wilayah luar Provinsi Kalimantan Selatan yang berdekatan Dengan Kabupaten/Kota agar dapat langsung dipulangkan sesuai aturan tanpa melalui Dinas Sosial Provinsi Kalimantan Selatan.</li>
                </ol>
                <h4 class='text-danger fw-bold mt-4'>PELAYANAN TIDAK DIPUNGUT BIAYA/TARIF (GRATIS)</h4>
                "
            ];

        return view('layanan.show', [
            'service' => $serviceContent,
            'allServices' => $servicesWithStatus
        ]);
    }
}
