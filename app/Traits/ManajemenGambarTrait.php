<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver; // Pastikan driver GD
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Log; // Untuk logging error (opsional)

trait ManajemenGambarTrait
{
    /**
     * Memproses dan menyimpan gambar yang diunggah dengan optimalisasi.
     *
     * @param UploadedFile $file File gambar yang diunggah.
     * @param string $tipe Jenis gambar ('berita', 'galeri', 'logo', 'icon', 'slider_header', 'page_header', dll.).
     * @param string $folderTujuan Folder di 'storage/app/public/'.
     * @return string|null Path relatif file yang disimpan atau null jika gagal.
     */
    public function prosesDanSimpanGambar(UploadedFile $file, string $tipe, string $folderTujuan): ?string
    {
        $originalSize = $file->getSize(); // Ukuran asli dalam bytes

        // --- Aturan Skip Optimasi ---
        $skipThresholdBerita = 200 * 1024; // 200 KB
        $skipThresholdGaleri = 300 * 1024; // 300 KB
        $skipThresholdIcon   = 10 * 1024;  // 10 KB
        $skipThresholdSlider = 300 * 1024; // 300 KB <-- BATAS BARU UNTUK SLIDER HEADER

        // Cek apakah perlu skip optimasi
        $shouldSkip = false;
        if ($tipe === 'berita' && $originalSize < $skipThresholdBerita) {
            $shouldSkip = true;
        } elseif ($tipe === 'galeri' && $originalSize < $skipThresholdGaleri) {
            $shouldSkip = true;
        } elseif (($tipe === 'icon' || $tipe === 'logo') && $originalSize < $skipThresholdIcon) {
            $shouldSkip = true;
        } elseif ($tipe === 'slider_header' && $originalSize < $skipThresholdSlider) { // <-- KONDISI BARU UNTUK SLIDER
             $shouldSkip = true;
        }
        // Page header lainnya akan selalu dioptimasi (tidak ada kondisi skip spesifik)

        // Jika perlu skip, simpan file asli
        if ($shouldSkip) {
            try {
                $extension = $file->guessExtension() ?? 'png';
                $allowedExtensions = ['jpeg', 'jpg', 'png', 'gif', 'svg', 'webp'];
                 if (!in_array(strtolower($extension), $allowedExtensions)) {
                    $extension = 'png';
                    Log::warning("Ekstensi file asli tidak valid untuk tipe $tipe: " . $file->getClientOriginalName() . ", dipaksa ke PNG.");
                }
                $namaFile = Str::uuid() . '.' . $extension;
                $pathRelatif = $file->storeAs($folderTujuan, $namaFile, 'public');
                return $pathRelatif;
            } catch (\Exception $e) {
                Log::error("Gagal menyimpan gambar asli (skip optimization, tipe: $tipe): " . $e->getMessage());
                return null;
            }
        }

        // Jika tidak di-skip, lanjutkan dengan proses optimalisasi Intervention
        try {
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file);

            // Tentukan aturan berdasarkan tipe
            $lebarMaks = 1024;
            $kualitas = 80;
            $format = 'webp';

            switch ($tipe) {
                case 'berita':
                case 'konten':
                    $lebarMaks = 1200;
                    $kualitas = 80;
                    $format = 'webp';
                    break;
                case 'galeri':
                    $lebarMaks = 1200;
                    $kualitas = 85;
                    $format = 'webp';
                    break;
                case 'logo':
                case 'icon':
                    $lebarMaks = 200;
                    $kualitas = 90;
                    $format = 'png';
                    break;
                 case 'slider_header': // <-- ATURAN BARU UNTUK SLIDER (> 300KB)
                    $lebarMaks = 1920;
                    $kualitas = 90; // Kualitas tinggi
                    $format = 'webp';
                    break;
                case 'page_header': // <-- TIPE BARU UNTUK HEADER HALAMAN LAIN
                case 'background_pejabat': // Background kartu pejabat pakai aturan ini juga
                    $lebarMaks = 1920;
                    $kualitas = 75; // Kualitas standar (lebih rendah)
                    $format = 'webp';
                    break;
                case 'pejabat':
                    $lebarMaks = 400;
                    $kualitas = 85;
                    $format = 'webp';
                    break;
                case 'mitra':
                    $lebarMaks = 300;
                    $kualitas = 85;
                    $format = 'png';
                    break;
                // Default case jika tipe tidak cocok
                default:
                    $lebarMaks = 1024;
                    $kualitas = 80;
                    $format = 'webp';
                    Log::warning("Tipe gambar tidak dikenal: $tipe. Menggunakan aturan default.");
                    break;

            }

            // --- Proses Optimalisasi ---
            if ($image->width() > $lebarMaks) {
                $image->scaleDown(width: $lebarMaks);
            }

            $encodedImage = $image->encodeByExtension($format, quality: $kualitas);

            $namaFile = Str::uuid() . '.' . $format;
            $pathRelatif = $folderTujuan . '/' . $namaFile;

            Storage::disk('public')->put($pathRelatif, (string) $encodedImage);
            return $pathRelatif;

        } catch (\Exception $e) {
            Log::error("Gagal memproses gambar ($tipe) dengan Intervention: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Menghapus file gambar lama dari storage.
     */
    protected function hapusGambarLama(?string $pathRelatif): void
    {
        if ($pathRelatif && Storage::disk('public')->exists($pathRelatif)) {
            Storage::disk('public')->delete($pathRelatif);
        }
    }
}
