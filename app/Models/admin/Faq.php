<?php

namespace App\Models\admin; // Pastikan namespace-nya benar

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\admin\KategoriFaq; // Impor model KategoriFaq

class Faq extends Model
{
    use HasFactory;

    protected $table = 'faq';
    protected $primaryKey = 'id_faq';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'id_kategori_faq',
        'pertanyaan',
        'jawaban',
    ];

    // === TAMBAHKAN FUNGSI RELASI INI ===
    public function kategoriFaq()
    {
        return $this->belongsTo(KategoriFaq::class, 'id_kategori_faq', ownerKey: 'id_kategori_faq');
    }
}
