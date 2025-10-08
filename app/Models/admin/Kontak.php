<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class Kontak extends Model
{
    protected $table = 'kontak';
    public $timestamps = false;
    protected $primaryKey = 'id_kontak';
    protected $fillable = [
        'nomor_telepon',
        'email',
        'jam_pelayanan',
        'map',
        'alamat',
    ];
}
