<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gestor extends Model
{
    use HasFactory;

    protected $table = 'gestores';

    public function usuario() :BelongsTo
    { 
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeActive($query)
    {
        return $query->where('estatus', 'A');
    }
}
