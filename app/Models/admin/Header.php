<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class Header extends Model
{
    protected $table = 'header';
    protected $primaryKey = 'id_header';
    public $timestamps = false;
    protected $fillable = [
        'id_user',
        'id_kategori_header',
        'gambar',
        'headline',
        'sub_heading',
    ];

    public function kategoriHeader()
    {
        return $this->belongsTo(KategoriHeader::class, 'id_kategori_header', 'id_kategori_header');
    }
}
