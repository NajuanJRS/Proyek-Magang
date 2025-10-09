<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileDownload extends Model
{
    use HasFactory;

    protected $table = 'file_download';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id_kategori_download',
        'nama_file',
        'path_file',
    ];

    public function kategoriDownload()
    {
        return $this->belongsTo(KategoriDownload::class, 'id_kategori_download');
    }
}
