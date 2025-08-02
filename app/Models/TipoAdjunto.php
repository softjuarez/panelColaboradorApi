<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoAdjunto extends Model
{
    use HasFactory;

    protected $table = 'tipo_adjuntos';

    protected $fillable = [
        'nombre'
    ];

    public function documentos(): HasMany
    {
        return $this->hasMany(Adjunto::class, 'tipo_id');
    }
}
