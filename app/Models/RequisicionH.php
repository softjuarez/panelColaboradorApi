<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class RequisicionH extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv-secondary';

    public $timestamps = false;

    public $incrementing = false;

    protected $table = 'REQ_H';

    protected $primaryKey = 'NUMERO';

    protected $casts = [
        'CTROCSTO' => 'string',
        'USUARIO_DESTINO' => 'string',
        'GESTOR_ID' => 'integer'
    ];

    public function detalles() :HasMany
    {
        return $this->setConnection('sqlsrv-secondary')->hasMany(RequisicionD::class, 'REQ_H', 'NUMERO');
    }

    public function detallesp() :HasMany
    {
        return $this->setConnection('sqlsrv-secondary')->hasMany(RequisicionP::class, 'REQ_H', 'NUMERO');
    }

    public function archivos() :HasMany
    {
        return $this->setConnection('sqlsrv')->hasMany(ArchivoRequisicion::class, 'requisicion_h', 'NUMERO');
    }

    public function ficha()
    {
        return $this->setConnection('sqlsrv')->belongsTo(Ficha::class, 'SOLICITANTE_NUM', 'NUMERO');
    }

    public function gestor()
    {
        return $this->setConnection('sqlsrv')->belongsTo(Gestor::class, 'GESTOR_ID', 'id');
    }

    public function tipoCompra()
    {
        $estados = [
            'B' => 'Bien',
            'S' => 'Servicio',
            'A' => 'Activo',
            'M' => 'Mixto'
        ];

        return $estados[$this->T_RECHAZO] ?? 'Estado Desconocido';
    }

    public function usuarioDestino()
    {
        $nombresCompletos =
        Ficha::whereIn('NUMERO', explode(',', $this->USUARIO_DESTINO))
                ->get()
                ->map(function ($ficha) {
                    return trim($ficha->NOMBRE_1 . ' ' . $ficha->APELLIDO_1);
                })
                ->implode(', ');

        return $nombresCompletos ?? '';
    }

    public function sedesDestino()
    {
        $nombresCompletos =
        DB::table('sucursal')
                ->whereIn('RECNUM', explode(',', $this->SEDES))
                ->get()
                ->map(function ($sede) {
                    return trim($sede->CODIGO . ' - ' . $sede->NOMBRE);
                })
                ->implode(', ');

        return $nombresCompletos;
    }

    public function cuentaContable()
    {
        $nombresCompletos =
        DB::connection('sqlsrv-secondary')
                ->table('CUENTA')
                ->where('DFRECNUM', $this->CUENTA_CONTABLE)
                ->get()
                ->map(function ($cuenta) {
                    return trim($cuenta->CLAVE . ' - ' . $cuenta->NOMBRE);
                })
                ->implode(', ');

        return $nombresCompletos ?? '';
    }

    public function bitacora()
    {
        return $this->setConnection('sqlsrv')->hasMany(BitacoraRequisicion::class, 'requisicion_h', 'NUMERO');
    }

    public function usuarioDestinoActual()
    {
        $configuracion = DB::table('configuraciones')->first();
        return $configuracion->destino_requisicion ?? 'Sin configuracion.';
    }

    public function nombreEmpresa()
    {
        $empresa = DB::connection('sqlsrv-secondary')->table('EMPRESA')->where('NUMERO', $this->EMPRESA)->first();
        if ($empresa) {
            return $empresa->NOMBRE_COMPLETO;
        }
        return '';
    }

    public function nombreMoneda()
    {
        $moneda = DB::connection('sqlsrv-secondary')->table('MONEDA')->where('CLAVE', $this->MONEDA)->first();
        if ($moneda) {
            return $moneda->NOMBRE_CORTO;
        }
        return '';
    }

    public function obtenerSeccion()
    {
        return 'Sin Seccion.';
    }

    public function obtenerCentroCosto()
    {
        $centroCosto = DB::connection('sqlsrv-secondary')->table('CTROCSTO')->where('NUMERO', $this->CTROCSTO)->first();
        if ($centroCosto) {
            return rtrim($centroCosto->DESCRIPCION);
        }
        return 'Sin Centro de Costo.';
    }

    public function obtenerEntidad()
    {
        $entidad = DB::connection('sqlsrv')->table('ENTIDAD')->where('NUMERO', $this->ENTIDAD)->first();
        if ($entidad) {
            return $entidad->NOMBRE;
        }
        return 'Sin Entidad.';
    }

    public function obtenerTotal()
    {
        return $this->detalles->sum(function ($detalle) {
            return $detalle->CANT_REQ * $detalle->PU;
        });
    }

    public function obtenerTotalPorEstado()
    {
        return $this->detalles->sum(function ($detalle) {
            if ($this->ESTATUS == 'A') {
                return $detalle->CANT_REQ * $detalle->PU;
            } else if ($this->ESTATUS == 'B' || $this->ESTATUS == 'C') {
                return $detalle->CANT_AUT1 * $detalle->PU;
            } else if ($this->ESTATUS == 'D') {
                return $detalle->CANT_AUT2 * $detalle->PU;
            } else if ($this->ESTATUS == 'E') {
                return $detalle->CANT_AUT2 * $detalle->PU;
            } else if ($this->ESTATUS == 'F') {
                return $detalle->CANT_AUT3 * $detalle->PU;
            } else if ($this->ESTATUS == 'G') {
                return $detalle->CANT_OC * $detalle->PU;
            } else if ($this->ESTATUS == 'H') {
                return $detalle->CANT_AUT4 * $detalle->PU;
            } else {
                return $detalle->CANTIDAD * $detalle->PU;
            }
        });
    }

    public function obtenerTotalP()
    {
        return $this->detallesp->sum(function ($detalle) {
            return $detalle->VALOR;
        });
    }

    public function obtenerEstado()
    {
        if (!empty($this->RAZON_RECHAZO)) {
            return 'Requisicion Rechazada';
        }

        $estados = [
            'A' => 'Requisicion Sin Solicitar',
            'B' => 'Requisicion Solicitada',
            'C' => 'Requisicion En Presupuesto',
            'D' => 'Requisicion En Tesoreria',
            'E' => 'Requisicion En Compras',
            'F' => 'Requisicion Con Gestor Asignado',
            'G' => 'Requisición Gestionada',
            'H' => 'Requisición Comite',
            'I' =>  'O.C. Generada'
        ];

        return $estados[$this->ESTATUS] ?? 'Estado Desconocido';
    }

    public function obtenerColorEstado()
    {
        if (!empty($this->RAZON_RECHAZO)) {
            return 'red';
        }

        $colores = [
            'A' => 'yellow',
            'B' => 'blue',
            'C' => 'green',
            'D' => 'purple',
            'E' => 'sky-blue',
            'F' => 'pink',
        ];

        return $colores[$this->ESTATUS] ?? '';
    }

    public function autorizacionJefe()
    {
        $historial = $this->bitacora()->where('accion', 'Autorizacion Jefe')->orWhere('accion', 'Autorizar Automáticamente Jefe')->orderBy('created_at', 'desc')->first();
        return $historial ? $historial->Usuario->name : 'Sin autorizar';
    }

    public function autorizacionPresupuesto()
    {
        $historial = $this->bitacora()->where('accion', 'Autorizacion Presupuesto')->orderBy('created_at', 'desc')->first();
        return $historial ? $historial->Usuario->name : 'Sin autorizar';
    }

    public function autorizacionTesoreria()
    {
        $historial = $this->bitacora()->where('accion', 'Autorizacion Tesoreria')->orderBy('created_at', 'desc')->first();
        return $historial ? $historial->Usuario->name : 'Sin autorizar';
    }
}
