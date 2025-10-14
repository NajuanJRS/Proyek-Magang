<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konten extends Model
{
    protected $table = 'konten';
    public $timestamps = false;
    protected $primaryKey = 'id_konten';
    protected $fillable = [
        'id_kategori_konten',
        'id_user',
        'isi_konten1',
        'gambar1',
        'isi_konten2',
        'gambar2',
        'isi_konten3',
        'gambar3',
    ];

    public function kategoriKonten()
    {
        return $this->belongsTo(kategoriKonten::class, 'id_kategori_konten', 'id_kategori_konten');
    }
}
