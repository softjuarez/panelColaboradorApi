<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoDetalle extends Model
{
    use HasFactory;

    protected $table = 'documento_detalles';

    public function documento()
    {
        return $this->belongsTo(Documento::class);
    }
}
