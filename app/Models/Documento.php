<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Documento extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';

    protected $table = 'documentos';

    public static function getTableName() {
        $instance = new static;
        return implode('.', array_filter([
            $instance->getConnection()->getDatabaseName(),
            'dbo',
            $instance->getTable()
        ]));
    }

    public function detalles()
    {
        return $this->hasMany(DocumentoDetalle::class, 'documento_id');
    }

    public function historiales()
    {
        return $this->hasMany(BitacoraDocumentos::class, 'documento_id');
    }

    public function orden(): BelongsTo
    {
        return $this->belongsTo(OrdenDeCompraH::class, 'ordcom_h', 'NUMERO');
    }


    public function isEditable()
    {
        if ($this->xml != '') {
            return false;
        }
        return true;
    }

    public function estado()
    {
        if ($this->estatus == 1){
            return 'Borrador';
        } else if ($this->estatus == 2) {
            return 'Revision';
        } else if ($this->estatus == 3) {
            return 'Autorizado';
        } else if ($this->estatus == 4) {
            return 'Rechazado';
        } else if ($this->estatus == 5) {
            return 'Pagado';
        } else if ($this->estatus == 6) {
            return 'Tesoreria';
        }
    }
}
