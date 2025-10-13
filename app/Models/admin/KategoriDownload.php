<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriDownload extends Model
{
    use HasFactory;

    protected $table = 'kategori_download';
    protected $primaryKey = 'id_kategori';
    public $timestamps = false;

    protected $fillable = [
        'nama_kategori',
        'slug',
        'icon',
        'halaman_induk',
    ];

    public function files()
    {
        return $this->hasMany(FileDownload::class, 'id_kategori');
    }
}
