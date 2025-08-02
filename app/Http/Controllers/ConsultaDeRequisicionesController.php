<?php

namespace App\Http\Controllers;

use App\Models\RequisicionH;
use Illuminate\Http\Request;
use App\Models\CentroDeCosto;
use App\Models\Ficha;
use App\Models\Gestor;
use Illuminate\Support\Facades\DB;

class ConsultaDeRequisicionesController extends Controller
{
    public function launcher()
    {
        $fichas = Ficha::where('ESTATUS', 'A')->get();
        $centros_costo = CentroDeCosto::all();

        return view('lanzadores.consulta_requisiciones')->with(['fichas' => $fichas, 'centros_costo' => $centros_costo]);
    }

    public function index($fecha_inicio, $fecha_fin, $ficha=0, $centros_costo=0, $requisicion=0, $estado)
    {
        $requisiciones = RequisicionH::whereRaw("FORMAT(FECHA, 'yyyy-MM-dd') between '$fecha_inicio' and '$fecha_fin'")
                                        ->whereRaw("SOLICITANTE_NUM = IIF($ficha = 0, SOLICITANTE_NUM, $ficha)")
                                        ->whereRaw("CTROCSTO = IIF($centros_costo = 0, CTROCSTO, $centros_costo)")
                                        ->whereRaw("NUMERO = IIF($requisicion = 0, NUMERO, $requisicion)")
                                        ->whereRaw("ESTATUS = IIF('$estado' = '0', ESTATUS, '$estado')")
                                        ->paginate(15);

        return view('reportes.requisiciones_vista')->with(['requisiciones' => $requisiciones, 'fi_param' => $fecha_inicio, 'ff_param' => $fecha_fin, 'ficha_param' => $ficha, 'cc_param' => $centros_costo, 'req_param' => $requisicion, 'estado_param' => $estado]);
    }

    public function show(RequisicionH $requisicion, $fi_param, $ff_param, $ficha_param, $cc_param, $req_param, $estado_param)
    {
        $empresas = DB::connection('sqlsrv-secondary')->table('EMPRESA')->get();
        $monedas = DB::connection('sqlsrv-secondary')->table('MONEDA')->get();
        $proveedores = DB::connection('sqlsrv-secondary')->table('PRVEEDOR')->get();
        $conceptos = DB::connection('sqlsrv-secondary')->table('CONCPPTO')->get();
        $renglones = DB::connection('sqlsrv-secondary')->table('GPO_PPTO')->get();
        $cuentas = DB::connection('sqlsrv-secondary')->table('CUENTA')->where('SUMARIA_O_MOVTO', 'M')->get();
        $centros_costo = CentroDeCosto::all();
        $sedes = DB::connection('sqlsrv')->table('sucursal')->get();
        $fichas = Ficha::where('ESTATUS', 'A')->get();
        $gestores = Gestor::where('estatus', 'A')->get();


        return view('reportes.requisiciones_show')->with(['requisicion' => $requisicion, 'empresas' => $empresas, 'monedas' => $monedas, 'proveedores' => $proveedores, 'centros_costo' => $centros_costo, 'conceptos' => $conceptos, 'renglones' => $renglones, 'cuentas' => $cuentas, 'sedes' => $sedes, 'fichas' => $fichas, 'gestores' => $gestores, 'fi_param' => $fi_param, 'ff_param' => $ff_param, 'ficha_param' => $ficha_param, 'cc_param' => $cc_param, 'req_param' => $req_param, 'estado_param' => $estado_param]);
    }
}
