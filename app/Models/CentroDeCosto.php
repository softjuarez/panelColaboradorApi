<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CentroDeCosto extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv-secondary';
    
    public $timestamps = false;
    
    public $incrementing = false;

    protected $table = 'CTROCSTO';

    protected $primaryKey = 'NUMERO';
}
