<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'jabatan';
    public $timestamps = false;
    protected $primaryKey = 'id_jabatan';
    protected $fillable = [
        'nama_jabatan',
    ];

    public function pejabat()
    {
        return $this->hasMany(Pejabat::class, 'id_jabatan');
    }
}
