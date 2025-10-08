<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $table = 'faq';
    public $timestamps = false;
    protected $primaryKey = 'id_faq';
    protected $fillable = [
        'id_user',
        'id_kategori_faq',
        'pertanyaan',
        'jawaban',
    ];

    public function kategoriFaq()
    {
        return $this->belongsTo(KategoriFaq::class, 'id_kategori_faq', 'id_kategori_faq');
    }
}
