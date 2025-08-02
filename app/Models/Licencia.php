<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Licencia extends Model
{
    use HasFactory;

    protected $table = 'licencias';

    public function ficha()
    {
        return $this->setConnection('sqlsrv')->belongsTo(Ficha::class, 'ficha_crea', 'NUMERO');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_crea');
    }

    public function atendio()
    {
        return $this->belongsTo(User::class, 'usuario_atendio');
    }

    public function tipo_licencia()
    {
        return $this->belongsTo(TipoLicencia::class, 'tipo');
    }

    public function obtenerEstado()
    {
        if (!empty($this->razon_rechazo)) {
            return 'Rechazada';
        }

        $estados = [
            'A' => 'Abierta',
            'B' => 'Solicitada',
            'C' => 'Procesada',
            'D' => 'Aceptada',
        ];

        return $estados[$this->estatus] ?? 'Estado Desconocido';
    }

     public function obtenerColorEstado()
    {
        if (!empty($this->razon_rechazo)) {
            return 'red';
        }

        $colores = [
            'A' => 'yellow',
            'B' => 'blue',
            'C' => 'purple',
            'D' => 'green',
        ];

        return $colores[$this->estatus] ?? '';
    }


}
