<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'faq';

    // Primary key dari tabel
    protected $primaryKey = 'id_faq';

    // Nonaktifkan timestamps (created_at, updated_at)
    public $timestamps = false;

    // Kolom yang bisa diisi
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
