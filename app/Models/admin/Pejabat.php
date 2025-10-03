<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pejabat extends Model
{
    use HasFactory;

    protected $table = 'pejabat';
    protected $primaryKey = 'nip'; // Menggunakan NIP sebagai primary key
    public $incrementing = false; // Karena NIP bukan auto-increment
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'nip',
        'id_jabatan',
        'nama_pejabat',
        'kata_sambutan',
        'gambar',
    ];

    // Relasi ke tabel Jabatan
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan');
    }
}
