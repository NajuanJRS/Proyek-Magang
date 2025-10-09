<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class KategoriFaq extends Model
{
    protected $table = 'kategori_faq';
    protected $primaryKey = 'id_kategori_faq';
    public $timestamps = false;

    protected $fillable = [
        'nama_kategori_faq',
        'slug'
    ];

    public function faqs()
    {
        return $this->hasMany(Faq::class, 'id_kategori_faq', 'id_kategori_faq');
    }
}
