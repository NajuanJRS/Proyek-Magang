<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class LayananKami extends Model
{
    protected $table = 'layanan_kami';
    public $timestamps = false;
    protected $primaryKey = 'id_layanan';
    protected $fillable = [
        'id_user',
        'icon',
        'judul',
        'isi_layanan1',
        'gambar1',
        'isi_layanan2',
        'gambar2',
        'isi_layanan3',
        'gambar3',
    ];
}
