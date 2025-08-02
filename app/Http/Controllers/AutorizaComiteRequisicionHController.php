<?php

namespace App\Http\Controllers;

use App\Models\Ficha;
use App\Models\RequisicionH;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CentroDeCosto;

class AutorizaComiteRequisicionHController extends Controller
{
    public function index($search = "")
    {
        $requisiciones = RequisicionH::where('SOLICITANTE', 'LIKE', '%'.$search.'%')
                            ->where('ESTATUS', 'H')
                            ->paginate(15);

        return view('autorizaciones_comite.index')->with(['requisiciones' => $requisiciones, 'search' => $search]);
    }

    public function edit(RequisicionH $requisicion)
    {
        $empresas = DB::connection('sqlsrv-secondary')->table('EMPRESA')->get();
        $monedas = DB::connection('sqlsrv-secondary')->table('MONEDA')->get();
        $proveedores = DB::connection('sqlsrv-secondary')->table('PRVEEDOR')->get();
        $conceptos = DB::connection('sqlsrv-secondary')->table('CONCPPTO')->get();
        $renglones = DB::connection('sqlsrv-secondary')->table('GPO_PPTO')->get();
        $cuentas = DB::connection('sqlsrv-secondary')->table('CUENTA')->where('SUMARIA_O_MOVTO', 'M')->selectRaw("DFRECNUM, CONCAT(rtrim(CLAVE), ' - ',  rtrim(NOMBRE)) NOMBRE")->get();
        $centros_costo = CentroDeCosto::selectRaw("NUMERO, CONCAT(rtrim(CLAVE), ' - ',  rtrim(DESCRIPCION)) DESCRIPCION")->get();
        $sedes = DB::connection('sqlsrv')->table('sucursal')->selectRaw("RECNUM, CONCAT(rtrim(CODIGO), ' - ',  rtrim(NOMBRE)) as NOMBRE")->get();
        $fichas = Ficha::where('ESTATUS', 'A')->selectRaw("NUMERO, CONCAT(rtrim(NOMBRE_1), ' ',  rtrim(APELLIDO_1)) as NOMBRE")->orderBy('NOMBRE', 'ASC')->get();

        return view('autorizaciones_comite.edit')->with(['requisicion' => $requisicion, 'empresas' => $empresas, 'monedas' => $monedas, 'proveedores' => $proveedores, 'centros_costo' => $centros_costo, 'conceptos' => $conceptos, 'renglones' => $renglones, 'cuentas' => $cuentas, 'sedes' => $sedes, 'fichas' => $fichas]);
    }

    public function update(Request $request, RequisicionH $requisicion)
    {
        $request->validate([
            'colaborador' => ['nullable', 'required_if:tipo_compra,A'],
        ]);

        $requisicion->USUARIO_DESTINO = $request->colaborador != '' ? implode(',', $request->colaborador) : '';
        $requisicion->save();

        return redirect()->route('autoriza-comite.edit', $requisicion)->with(['status' => 'success', 'message' => 'Requisicion updated successfully!']);
    }

    public function autorizar(Request $request, RequisicionH $requisicion)
    {
        $request->validate([
            'motivo_autoriza' => 'required|string|max:255',
        ]);

        $tieneDetallesNoAutorizados = RequisicionH::where('NUMERO', $requisicion->NUMERO)
            ->whereHas('detalles', function ($query) {
                $query->whereDoesntHave('detalles', function ($subQuery) {
                    $subQuery->where('AUTORIZA1', 'S');
                });
            })->exists();

        if ($tieneDetallesNoAutorizados) {
            return redirect()->route('autoriza-comite.edit', $requisicion)->with(['status' => 'error', 'message' => 'En cada detalle debe tener una cotizacion sugerida!']);
        }

        $requisicion->ESTATUS = 'I';
        $requisicion->RAZON_RECHAZO = '';
        $requisicion->RAZON_AUTORIZA = $request->motivo_autoriza;
        $requisicion->save();

        return redirect()->route('autoriza-comite.index')->with(['status' => 'success', 'message' => 'Requisición autorizada correctamente.']);
    }

    public function rechazar(Request $request, RequisicionH $requisicion)
    {
        $request->validate([
            'motivo_rechazo' => 'required|string|max:255',
        ]);

        $requisicion->ESTATUS = 'G';
        $requisicion->RAZON_RECHAZO = $request->motivo_rechazo;
        $requisicion->save();

        return redirect()->route('autoriza-comite.index')->with(['status' => 'success', 'message' => 'Requisición rechazada correctamente.']);
    }

    public function obtenerTotal(RequisicionH $requisicion)
    {
        return response()->json([
            'total' => $requisicion->obtenerTotalPorEstado(),
            'totalP' => $requisicion->obtenerTotalP()
        ]);
    }
}
