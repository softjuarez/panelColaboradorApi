<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudVacaciones extends Model
{
    use HasFactory;

    protected $table = 'VACACION';

    public $timestamps = false;

    protected $primaryKey = 'DFRECNUM';

    public function ficha()
    {
        return $this->belongsTo(Ficha::class, 'FICHA', 'NUMERO');
    }

    public function obtenerEstado()
    {
        $estados = [
            'A' => 'Solicitada',
            'F' => 'Revision',
            'C' => 'Procesada',
            'R' => 'Rechazada',
        ];

        return $estados[$this->ESTATUS] ?? 'Estado Desconocido';
    }

    public function obtenerColorEstado()
    {
        $colores = [
            'A' => 'yellow',
            'F' => 'blue',
            'C' => 'green',
            'R' => 'red',
        ];

        return $colores[$this->ESTATUS] ?? '';
    }

}
