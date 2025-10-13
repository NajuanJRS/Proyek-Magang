<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriKonten extends Model
{
    use HasFactory;

    protected $table = 'kategori_konten';
    protected $primaryKey = 'id_kategori_konten';
    public $timestamps = false;

    protected $fillable = [
        'nama_menu_kategori',
        'judul_konten',
        'icon_konten',
        'slug_konten',
    ];

    // Relasi ke tabel Konten
    public function konten()
    {
        return $this->hasOne(Konten::class, 'id_kategori_konten');
    }
}

