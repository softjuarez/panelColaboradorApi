<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivoPermiso extends Model
{
    use HasFactory;

    protected $table = 'archivo_permiso';

    protected $fillable = ['nombre', 'url', 'permiso_id'];
}
