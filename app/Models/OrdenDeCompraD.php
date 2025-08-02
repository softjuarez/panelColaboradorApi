<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenDeCompraD extends Model
{
    use HasFactory;
    
    protected $connection = 'sqlsrv-secondary';

    protected $table = 'ORDCOM_D';

    public $timestamps = false;

    protected $primaryKey = 'NUMERO';
}
