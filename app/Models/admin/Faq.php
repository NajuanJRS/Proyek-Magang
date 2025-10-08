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
        'pertanyaan',
        'jawaban',
        'id_kategori_faq', // Pastikan kolom ini ada di fillable
    ];

    // === TAMBAHKAN FUNGSI RELASI INI ===
    public function kategori()
    {
        return $this->belongsTo(KategoriFaq::class, 'id_kategori_faq');
    }
}
