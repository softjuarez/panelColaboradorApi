<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Solicitud extends Model
{
    use HasFactory;

    protected $table = 'solicitud';

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
    
    public function tipo_solicitud()
    {
        return $this->belongsTo(TipoSolicitud::class, 'tipo');
    }

    public function documentos()
    {
        return $this->morphMany(Adjunto::class, 'adjuntable');
    }

    public function adjuntos() :HasMany
    {
        return $this->hasMany(ArchivoSolicitud::class, 'solicitud_id');
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
            'C' => 'green',
        ];

        return $colores[$this->estatus] ?? '';
    }
}
