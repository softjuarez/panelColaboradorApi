<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bitacora extends Model
{
    use HasFactory;

    protected $table = 'bitacora';

    protected $fillable = [
        'ficha_id',
        'user_id',
        'descripcion',
        'accion',
        'modulo',
        'datos_adicionales',
        'ip',
        'user_agent'
    ];

    public function Ficha(): BelongsTo
    {
        return $this->belongsTo(Ficha::class, 'ficha_id', 'NUMERO');
    }

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
