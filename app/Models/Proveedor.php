<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv-secondary';

    public $timestamps = false;

    public $incrementing = false;

    protected $table = 'PRVEEDOR';

    protected $primaryKey = 'NUMERO';

    public static function getTableName() {
        $instance = new static;
        return implode('.', array_filter([
            $instance->getConnection()->getDatabaseName(),
            'dbo',
            $instance->getTable()
        ]));
    }
}
