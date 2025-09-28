<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class KategoriFile extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    protected $fillable = [
        'nama_kategori',
    ];
    public $timestamps = false;

    public function download()
    {
        return $this->hasMany(FileDownload::class, 'id_kategori', 'id_kategori');
    }
}
