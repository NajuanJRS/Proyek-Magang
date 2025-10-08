<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriFaq extends Model
{
    use HasFactory;

    protected $table = 'kategori_faq';
    protected $primaryKey = 'id_kategori_faq';
    public $timestamps = false;

    protected $fillable = ['nama_kategori', 'slug'];

    // Relasi ke tabel Faq
    public function faqs()
    {
        return $this->hasMany(Faq::class, 'id_kategori_faq');
    }
}
