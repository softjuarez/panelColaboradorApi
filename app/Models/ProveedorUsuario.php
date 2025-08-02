<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProveedorUsuario extends Pivot
{
    use HasFactory;

    protected $connection = 'sqlsrv';

    protected $table = 'proveedor_usuario';

    public $incrementing = false;

    public $timestamps = false;

    protected $foreignKey = 'usuario_id';
    protected $relatedKey = 'proveedor_id';

    public static function getTableName() {
        $instance = new static;
        return implode('.', array_filter([
            $instance->getConnection()->getDatabaseName(),
            'dbo',
            $instance->getTable()
        ]));
    }

    public function getForeignKey()
    {
        return 'usuario_id';
    }

    public function getRelatedKey()
    {
        return 'proveedor_id';
    }

    public function getParentKey()
    {
        return 'id';
    }

    public function getRelatedParentKey()
    {
        return 'NUMERO';
    }
}
