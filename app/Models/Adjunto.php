<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Adjunto extends Model
{
    use HasFactory;

    protected $table = 'adjuntos';

    protected $fillable = ['nombre', 'url', 'ficha_id', 'usuario_id', 'para_todos', 'tipo_id', 'adjuntable_id', 'adjuntable_type'];

    public function tipo() :BelongsTo
    {
        return $this->belongsTo(TipoAdjunto::class, 'tipo_id');
    }
}
