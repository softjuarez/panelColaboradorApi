<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivoRequisicion extends Model
{
    use HasFactory;

    protected $table = 'archivos_requisicion';

    protected $fillable = ['nombre', 'url', 'requisicion_h', 'etapa', 'user_id'];

    public function requisicion()
    {
        return $this->belongsTo(RequisicionH::class, 'requisicion_h', 'NUMERO');
    }
}
