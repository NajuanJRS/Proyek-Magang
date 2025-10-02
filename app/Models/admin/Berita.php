<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'berita';

    // Primary key dari tabel
    protected $primaryKey = 'id_berita';

    // Nonaktifkan timestamps (created_at, updated_at) jika tidak ada di tabel Anda
    public $timestamps = false;

    // Kolom yang bisa diisi
    protected $fillable = [
        'id_user',
        'judul',
        'gambar1',
        'isi_berita1',
        'gambar2',
        'isi_berita2',
        'gambar3',
        'isi_berita3',
        'tgl_posting',
        'dibaca',
    ];
}
