<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konten extends Model
{
    use HasFactory;

    protected $table = 'konten';
    protected $primaryKey = 'id_konten';
    public $timestamps = false;

    protected $fillable = [
        'id_kategori_konten',
        'gambar1_konten',
        'isi_konten1',
        'gambar2_konten',
        'isi_konten2',
        'gambar3_konten',
        'isi_konten3',
    ];

    // Relasi ke tabel KategoriKonten
    public function kategori()
    {
        return $this->belongsTo(KategoriKonten::class, 'id_kategori_konten');
    }
}
