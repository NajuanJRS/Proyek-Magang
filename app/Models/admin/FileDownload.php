<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileDownload extends Model
{
    use HasFactory;

    protected $table = 'file_download';
    protected $primaryKey = 'id_file';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'id_kategori',
        'nama_file',
        'file',
    ];

    public function kategoriDownload()
    {
        return $this->belongsTo(KategoriDownload::class, 'id_kategori', 'id_kategori');
    }
}