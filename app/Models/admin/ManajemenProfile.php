<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class ManajemenProfile extends Model
{
    protected $table = 'manajemen_profile';
    public $timestamps = false;
    protected $primaryKey = 'id_profile';
    protected $fillable = [
        'id_user',
        'icon',
        'judul',
        'isi_konten',
        'gambar',
        'tgl_posting',
        'dibaca',
    ];
}
