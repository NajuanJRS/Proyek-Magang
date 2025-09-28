<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class PageHeader extends Model
{
    protected $table = 'page_header';
    protected $primaryKey = 'id_page';
    protected $fillable = [
        'id_menu',
        'id_user',
        'judul',
        'deskripsi',
        'gambar_header',
        'created_at',
        'updated_at',
    ];

    public function menuHeader()
    {
        return $this->belongsTo(MenuHeader::class, 'id_menu', 'id_menu');
    }
}
