<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BitacoraRequisicion extends Model
{
    use HasFactory;

    protected $table = 'bitacora_requisicion';

    protected $fillable = [
        'requisicion_h',
        'entidad_id',
        'fecha',
        'usuario',
        'accion',
        'modelo',
        'descripcion'
    ];

    public function Usuario()
    {
        return $this->belongsTo(User::class, 'usuario');
    }
}