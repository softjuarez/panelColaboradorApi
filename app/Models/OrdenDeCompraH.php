<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class OrdenDeCompraH extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv-secondary';

    protected $table = 'ORDCOM_H';

    public $timestamps = false;

    protected $primaryKey = 'NUMERO';


    public function getReferenciaAttribute($value)
    {
        return is_numeric($value) ? $value : (int) str_replace('RQ-', '', $value);
    }

    public function requisicion()
    {
        return $this->belongsTo(RequisicionH::class, 'REFERENCIA', 'NUMERO')->withDefault();
    }

    public function detalles():HasMany
    {
        return $this->hasMany(OrdenDeCompraD::class, 'ORDCOM_H', 'NUMERO');
    }

    public function documentos():HasMany
    {
        return $this->hasMany(Documento::class, 'ordcom_h', 'NUMERO');
    }

    public function saldo()
    {
        $valor_detalles = $this->documentos()
            ->select(DB::raw("(select ISNULL(SUM(valor_gran_total), 0) from documentos where ordcom_h = $this->NUMERO and estatus NOT IN (1,4)) as total"))
            ->first();

        return $this->VLR_FOB - ( $valor_detalles->total ?? 0);
    }

    public function aplicado()
    {
        $aplicado = $this->documentos()
            ->selectRaw("(select ISNULL(SUM(valor_gran_total), 0) from documentos where ordcom_h = $this->NUMERO and estatus NOT IN (1,4)) as total")
            ->first();

        return $aplicado->total ?? 0;
    }

    public function nombreMoneda()
    {
        $moneda = DB::connection('sqlsrv-secondary')->table('MONEDA')->where('CLAVE', $this->MONEDA)->first();
        if ($moneda) {
            return $moneda->NOMBRE_CORTO;
        }
        return '';
    }

    public function proveedor()
    {
        $proveedor = DB::connection('sqlsrv-secondary')->table('PRVEEDOR')->where('NUMERO', $this->PRVEEDOR)->first();
        if ($proveedor) {
            return $proveedor->NOMBRE_COMPLETO;
        }
        return '';
    }

}
