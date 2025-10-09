<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class KartuDownload extends Model
{
    protected $table = 'sub_kartu_download';
    protected $primaryKey = 'id_sub_kartu';
    protected $fillable = [
        'icon',
        'nama_sub_kartu',
        'slug',
    ];
    public $timestamps = false;
}
