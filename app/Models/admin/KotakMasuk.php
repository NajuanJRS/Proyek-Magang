<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class KotakMasuk extends Model
{
    public $timestamps = false;
    protected $table = 'kotak_masuk';
    protected $primaryKey = 'id_kotak';
    protected $fillable = [
        'nama',
        'email',
        'telepon',
        'isi_pesan',
        'status_dibaca',
        'tgl_kirim',
    ];
}
