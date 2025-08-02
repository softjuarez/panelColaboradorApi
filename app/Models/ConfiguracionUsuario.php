<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConfiguracionUsuario extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mostrar_bandeja_noticias',
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
