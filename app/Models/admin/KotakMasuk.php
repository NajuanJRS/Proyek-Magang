<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class KotakMasuk extends Model
{
    protected $table = 'kotak_masuk';
    protected $primaryKey = 'id_kotak';
    protected $fillable = [
        'nama',
        'email',
        'telepon',
        'isi_pesan',
        'tgl_kirim',
    ];
}
