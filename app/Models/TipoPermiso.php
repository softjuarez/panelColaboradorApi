<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoPermiso extends Model
{
    use HasFactory;

    protected $table = 'tipo_permisos';


    protected $fillable = [
        'nombre'
    ];

    public function solicitudes(): HasMany
    {
        return $this->hasMany(SolicitudPermisos::class, 'tipo_permiso_id');
    }
}
