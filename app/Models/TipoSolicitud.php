<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoSolicitud extends Model
{
    use HasFactory;

    protected $table = 'tipo_solicitud';


    protected $fillable = [
        'nombre'
    ];

    public function solicitudes(): HasMany
    {
        return $this->hasMany(Solicitud::class, 'tipo');
    }
}
