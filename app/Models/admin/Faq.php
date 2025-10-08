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
        'pertanyaan',
        'jawaban',
    ];
}
