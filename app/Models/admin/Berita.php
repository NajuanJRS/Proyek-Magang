<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $table = 'berita';
    public $timestamps = false;
    protected $primaryKey = 'id_berita';
    protected $fillable = [
        'id_user',
        'judul',
        'isi_berita1',
        'gambar1',
        'isi_berita2',
        'gambar2',
        'isi_berita3',
        'gambar3',
        'tgl_posting',
        'dibaca',
    ];

}
