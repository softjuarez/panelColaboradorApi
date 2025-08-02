<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConexionNodo extends Model
{
    use HasFactory;

    protected $table = 'conexiones_nodos';

     protected $fillable = [
        'organigrama_id',
        'nodo_padre_id',
        'nodo_hijo_id',
    ];
}
