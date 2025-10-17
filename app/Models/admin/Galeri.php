<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    protected $table = 'galeri';
    protected $primaryKey = 'id_galeri';
    public $timestamps = false;
    protected $fillable = [
        'id_user',
        'gambar',
        'judul',
        'tanggal_upload',
    ];
}
