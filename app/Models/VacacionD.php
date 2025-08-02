<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacacionD extends Model
{
    use HasFactory;

    protected $table = 'vacaciones_d';

    public function obtenerEstado()
    {
        $estados = [
            'A' => 'Solicitada',
            'F' => 'Revision',
            'C' => 'Procesada',
            'R' => 'Rechazada',
        ];

        return $estados[$this->estatus] ?? 'Estado Desconocido';
    }

    public function obtenerColorEstado()
    {
        $colores = [
            'A' => 'yellow',
            'F' => 'blue',
            'C' => 'green',
            'R' => 'red',
        ];

        return $colores[$this->estatus] ?? '';
    }
}
