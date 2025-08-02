<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nodo extends Model
{
    use HasFactory;

    const TIPO_RESUMIDO = 'R';
    const TIPO_DETALLADO = 'D';

    public function hijos()
    {
        return $this->belongsToMany(Nodo::class, 'conexiones_nodos', 'nodo_padre_id', 'nodo_hijo_id')
            ->withTimestamps();
    }

    public function padres()
    {
        return $this->belongsToMany(Nodo::class, 'conexiones_nodos', 'nodo_hijo_id', 'nodo_padre_id')
            ->withTimestamps();
    }

    public function esDescendienteDe($nodoPadreId): bool
    {
        if ($this->padres->contains('id', $nodoPadreId)) {
            return true;
        }

        foreach ($this->padres as $padre) {
            if ($padre->esDescendienteDe($nodoPadreId)) {
                return true;
            }
        }

        return false;
    }
}
