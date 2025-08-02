<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivoSolicitud extends Model
{
    use HasFactory;

    protected $table = 'archivo_solicitud';

    protected $fillable = ['nombre', 'url', 'solicitud_id'];

}
