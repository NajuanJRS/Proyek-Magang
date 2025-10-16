<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    protected $table = 'galeri';
<<<<<<< HEAD
    public $timestamps = false;
    protected $primaryKey = 'id_galeri';
    protected $fillable = [
        'id_user',
        'judul',
        'gambar',
=======
    protected $primaryKey = 'id_galeri';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'gambar',
        'judul',
>>>>>>> 8efaa07de001f916471b4e563bd96870d09acc23
        'tanggal_upload',
    ];
}
