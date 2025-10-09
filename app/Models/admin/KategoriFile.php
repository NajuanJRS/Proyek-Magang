<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class KategoriFile extends Model
{
    protected $table = 'kategori_download';
    protected $primaryKey = 'id_kategori';
    protected $fillable = [
        'icon',
        'nama_kategori',
        'slug',
        'halaman_induk',
    ];
    public $timestamps = false;

    public function download()
    {
        return $this->hasMany(FileDownload::class, 'id_kategori', 'id_kategori');
    }
}
