<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VacacionH extends Model
{
    use HasFactory;

    protected $table = 'vacaciones_h';

    public function detalles() :HasMany
    {
        return $this->hasMany(VacacionD::class, 'vacaciones_h_id');
    }

    public function autoriza() :BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_autoriza');
    }

    public function verifica() :BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_verifica');
    }

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
