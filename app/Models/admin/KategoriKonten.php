<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class KategoriKonten extends Model
{
    protected $table = 'kategori_konten';
    public $timestamps = false;
    protected $primaryKey = 'id_kategori_konten';
    protected $fillable = [
        'menu_konten',
        'judul_konten',
        'icon_konten',
        'slug',
    ];

    public function konten()
    {
        return $this->hasMany(Konten::class, 'id_kategori_konten', 'id_kategori_konten');
    }
}
