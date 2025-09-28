<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class FileDownload extends Model
{
    protected $table = 'file_download';
    public $timestamps = false;
    protected $primaryKey = 'id_file';
    protected $fillable = [
        'id_kategori',
        'id_user',
        'icon',
        'nama_file',
        'file',
        'tgl_file',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriFile::class, 'id_kategori', 'id_kategori');
    }
}
