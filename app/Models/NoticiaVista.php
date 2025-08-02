<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoticiaVista extends Model
{
    use HasFactory;

    protected $fillable = [
        'noticia_id',
        'user_id',
        'fecha_visto'
    ];
}
