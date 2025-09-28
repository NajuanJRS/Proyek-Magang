<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class KategoriHeader extends Model
{
    protected $table = 'kategori_header';
    protected $primaryKey = 'id_kategori_header';
    public $timestamps = false;
    protected $fillable = [
        'nama_kategori',
    ];

    public function sliders()
    {
        return $this->hasMany(Header::class, 'id_kategori_header', 'id_kategori_header');
    }
}
