<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class MenuHeader extends Model
{
    protected $table = 'menu_header';
    protected $primaryKey = 'id_menu';
    public $timestamps = false;
    protected $fillable = [
        'nama_menu',
    ];

    public function pageHeader()
    {
        return $this->hasMany(PageHeader::class, 'id_menu', 'id_menu');
    }
}
