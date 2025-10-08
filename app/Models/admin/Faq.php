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
        'pertanyaan',
        'jawaban',
    ];
}
