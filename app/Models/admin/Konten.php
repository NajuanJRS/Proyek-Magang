<?php

namespace App\Models\admin;

<<<<<<< HEAD
=======
use Illuminate\Database\Eloquent\Factories\HasFactory;
>>>>>>> 54734343a0ed76c05c4e664b6699a738ed34efab
use Illuminate\Database\Eloquent\Model;

class Konten extends Model
{
<<<<<<< HEAD
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
        return $this->belongsTo(KategoriKonten::class, 'id_kategori_konten', 'id_kategori_konten');
=======
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
>>>>>>> 54734343a0ed76c05c4e664b6699a738ed34efab
    }
}
