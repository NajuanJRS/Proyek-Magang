<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    protected $table = 'galeri';
    public $timestamps = false;
    protected $primaryKey = 'id_galeri';
    protected $fillable = [
        'id_user',
        'judul',
        'gambar',
        'tanggal_upload',
    ];
}
