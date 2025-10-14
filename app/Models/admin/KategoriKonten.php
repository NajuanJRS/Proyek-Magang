<?php

namespace App\Models\admin;

<<<<<<< HEAD
=======
use Illuminate\Database\Eloquent\Factories\HasFactory;
>>>>>>> 54734343a0ed76c05c4e664b6699a738ed34efab
use Illuminate\Database\Eloquent\Model;

class KategoriKonten extends Model
{
<<<<<<< HEAD
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
=======
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

>>>>>>> 54734343a0ed76c05c4e664b6699a738ed34efab
