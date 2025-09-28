<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class Pejabat extends Model
{
    protected $table = 'pejabat';
    public $timestamps = false;
    protected $primaryKey = 'nip';
    protected $keyType = 'string';
    protected $fillable = [
        'nip',
        'id_jabatan',
        'nama_pejabat',
        'kata_sambutan',
        'gambar',
        'nip',
    ];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan');
    }
}
