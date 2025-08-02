<?php

namespace App\Http\Controllers;

use App\Models\RequisicionH;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CentroDeCosto;
use App\Models\Ficha;
use App\Models\Gestor;
use App\Models\User;

class AutorizaCompraRequisicionHController extends Controller
{
    public function index($search = "")
    {
        $requisiciones_asignar_gestor = RequisicionH::where('SOLICITANTE', 'LIKE', '%'.$search.'%')
                                                    ->where('ESTATUS', 'E')
                                                    ->paginate(15, ['*'], 'asignar_gestor_page');


        $userIds = User::where('name', 'LIKE', '%' . $search . '%')
                        ->whereHas('gestionActiva')
                        ->with('gestionActiva')
                        ->get()
                        ->pluck('gestionActiva.id')
                        ->toArray();

        $requisiciones_gestion_compra = RequisicionH::where(function($query) use ($search, $userIds) {
                    $query->where('SOLICITANTE', 'LIKE', '%' . $search . '%')
                        ->orWhereIn('GESTOR_ID', $userIds);
                })
                ->where('ESTATUS', 'F')
                ->paginate(15, ['*'], 'gestion_compra_page');

        $requisiciones_validacion_compra = RequisicionH::where('SOLICITANTE', 'LIKE', '%'.$search.'%')
            ->where('ESTATUS', 'G')
            ->paginate(15, ['*'], 'validacion_compra_page');



        return view('autorizaciones_compra.index')->with(['requisiciones_asignar_gestor' => $requisiciones_asignar_gestor, 'requisiciones_gestion_compra' => $requisiciones_gestion_compra, 'requisiciones_validacion_compra' => $requisiciones_validacion_compra, 'search' => $search]);
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
        $gestores = Gestor::where('estatus', 'A')->get();

        return view('autorizaciones_compra.edit')->with(['requisicion' => $requisicion, 'empresas' => $empresas, 'monedas' => $monedas, 'proveedores' => $proveedores, 'centros_costo' => $centros_costo, 'conceptos' => $conceptos, 'renglones' => $renglones, 'cuentas' => $cuentas, 'sedes' => $sedes, 'fichas' => $fichas, 'gestores' => $gestores]);
    }

    public function update(Request $request, RequisicionH $requisicion)
    {
        $request->validate([
            'gestor' => ['required'],
            'colaborador' => ['nullable', 'required_if:tipo_compra,A'],
        ]);

        $requisicion->GESTOR_ID = $request->gestor;

        if ($requisicion->ESTATUS == 'A') {
            $requisicion->USUARIO_DESTINO = $request->colaborador != '' ? implode(',', $request->colaborador) : '';
        }
        $requisicion->save();

        return redirect()->route('autoriza-compra.edit', $requisicion)->with(['status' => 'success', 'message' => 'Requisicion updated successfully!']);
    }

    public function autorizar(Request $request, RequisicionH $requisicion)
    {
        $request->validate([
            'motivo_autoriza' => 'required|string|max:255',
        ]);

        if (!$requisicion->GESTOR_ID) {
            return redirect()->route('autoriza-compra.edit', $requisicion)->with(['status' => 'error', 'message' => 'Debes asignar un gestor a esta requisicion!']);
        }

        if ($requisicion->ESTATUS == 'E') {
            $requisicion->ESTATUS = 'F';
        } elseif ($requisicion->ESTATUS == 'G') {
            $requisicion->ESTATUS = 'H';
        }

        $requisicion->RAZON_RECHAZO = '';
        $requisicion->RAZON_AUTORIZA = $request->motivo_autoriza;
        $requisicion->save();

        return redirect()->route('autoriza-compra.index')->with(['status' => 'success', 'message' => 'Requisición autorizada correctamente.']);
    }

    public function rechazar(Request $request, RequisicionH $requisicion)
    {
        $request->validate([
            'motivo_rechazo' => 'required|string|max:255',
        ]);

        if ($requisicion->ESTATUS == 'E') {
            $requisicion->ESTATUS = 'D';
        } else if ($requisicion->ESTATUS == 'G') {
            $requisicion->ESTATUS = 'F';
        }

        $requisicion->RAZON_RECHAZO = $request->motivo_rechazo;
        $requisicion->save();

        return redirect()->route('autoriza-compra.index')->with(['status' => 'success', 'message' => 'Requisición rechazada correctamente.']);
    }

    public function enviarAComite(RequisicionH $requisicion)
    {
        $requisicion->ESTATUS = 'H';
        $requisicion->save();

        return redirect()->route('autoriza-compra.index')->with(['status' => 'success', 'message' => 'Requisición autorizada correctamente.']);
    }

    public function obtenerTotal(RequisicionH $requisicion)
    {
        return response()->json([
            'total' => $requisicion->obtenerTotalPorEstado(),
            'totalP' => $requisicion->obtenerTotalP()
        ]);
    }

    public function obtenerListado($search = "")
    {
        $requisiciones_asignar_gestor =
                RequisicionH::where('SOLICITANTE', 'LIKE', '%'.$search.'%')
                        ->where('ESTATUS', 'E')
                        ->get()
                        ->map(function ($item) {
                            $item->estado = $item->obtenerEstado();
                            $item->link = route('autoriza-compra.edit', $item->NUMERO);
                            $item->gestor_nombre = $item->gestor->usuario->name ?? 'Sin gestor asignado';
                            return $item;
                        });


        $userIds = User::where('name', 'LIKE', '%' . $search . '%')
                        ->whereHas('gestionActiva')
                        ->with('gestionActiva')
                        ->get()
                        ->pluck('gestionActiva.id')
                        ->toArray();

        $requisiciones_gestion_compra =
                RequisicionH::where(function($query) use ($search, $userIds) {
                    $query->where('SOLICITANTE', 'LIKE', '%' . $search . '%')
                        ->orWhereIn('GESTOR_ID', $userIds);
                })
                ->where('ESTATUS', 'F')
                ->get()
                ->map(function ($item) {
                    $item->estado = $item->obtenerEstado();
                    $item->link = route('autoriza-compra.edit', $item->NUMERO);
                    $item->gestor_nombre = $item->gestor->usuario->name ?? 'Sin gestor asignado';
                    return $item;
                });

        $requisiciones_validacion_compra =
            RequisicionH::where('SOLICITANTE', 'LIKE', '%'.$search.'%')
                ->where('ESTATUS', 'G')
                ->get()
                ->map(function ($item) {
                    $item->estado = $item->obtenerEstado();
                    $item->link = route('autoriza-compra.edit', $item->NUMERO);
                    $item->gestor_nombre = $item->gestor->usuario->name ?? 'Sin gestor asignado';

                    return $item;
                });


        return response()->json(['estatus' => true, 'message' => '', 'requisiciones_asignar_gestor' => $requisiciones_asignar_gestor, 'requisiciones_gestion_compra' => $requisiciones_gestion_compra, 'requisiciones_validacion_compra' => $requisiciones_validacion_compra, 'errors' => []], 200);

    }
}
