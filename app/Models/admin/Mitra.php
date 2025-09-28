<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    protected $table = 'mitra';
    protected $primaryKey = 'id_mitra';
    public $timestamps = false;
    protected $fillable = [
        'gambar',
        'nama_mitra',
        'link_mitra',
    ];
}
