<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Acente extends Model
{
    use SoftDeletes;

    protected $table = 'acenteler';

    protected $fillable = [
        'kod',
        'acente_adi',
        'acente_aciklama',
        'sorumlu_adi',
        'sorumlu_telefon',
        'slug',
        'durum',
        'created_by'
    ];

    protected $casts = [
        'durum' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];
}
