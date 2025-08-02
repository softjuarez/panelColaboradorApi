<?php

namespace App\Http\Controllers;

use App\Models\CentroDeCosto;
use App\Models\Ficha;
use App\Models\RequisicionH;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PDF;

class RequisicionHController extends Controller
{
    public function index($estado = 0, $search = '')
    {
        $requisiciones = RequisicionH::where('SOLICITANTE', 'LIKE', '%'.$search.'%')->whereRaw("ESTATUS = IIF('$estado' = '0', ESTATUS, '$estado')");

        if (!auth()->user()->hasPermission('show-multiple_ficha')) {
            $requisiciones->where('SOLICITANTE_NUM', auth()->user()->fichaActiva());
        }

        return view('requisiciones.index')->with(['requisiciones' => $requisiciones->orderBy('NUMERO', 'desc')->paginate(15), 'search' => $search, 'estado' => $estado]);
    }

    public function new()
    {
        $empresas = DB::connection('sqlsrv-secondary')->table('EMPRESA')->get();
        $monedas = DB::connection('sqlsrv-secondary')->table('MONEDA')->selectRaw('rtrim(CLAVE) CLAVE, rtrim(NOMBRE_CORTO) NOMBRE_CORTO')->get();
        $sedes = DB::connection('sqlsrv')->table('sucursal')->selectRaw("RECNUM, CONCAT(rtrim(CODIGO), ' - ',  rtrim(NOMBRE)) as NOMBRE")->get();
        $renglones = DB::connection('sqlsrv-secondary')->table('GPO_PPTO')->get();
        $cuentas = DB::connection('sqlsrv-secondary')->table('CUENTA')->where('SUMARIA_O_MOVTO', 'M')->selectRaw("DFRECNUM, CONCAT(rtrim(CLAVE), ' - ',  rtrim(NOMBRE)) NOMBRE")->get();
        $centros_costo = CentroDeCosto::selectRaw("NUMERO, CONCAT(rtrim(CLAVE), ' - ',  rtrim(DESCRIPCION)) DESCRIPCION")->get();
        $fichas = Ficha::where('ESTATUS', 'A')->selectRaw("NUMERO, CONCAT(rtrim(NOMBRE_1), ' ',  rtrim(APELLIDO_1)) as NOMBRE")->orderBy('NOMBRE', 'ASC')->get();

        return view('requisiciones.new')->with(['empresas' => $empresas, 'monedas' => $monedas, 'fichas' => $fichas, 'sedes' => $sedes, 'renglones' => $renglones, 'cuentas' => $cuentas, 'centros_costo' => $centros_costo]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'empresa' => 'required|integer',
            'fecha' => 'required|date',
            'moneda' => ['required'],
            'comentarios' => 'required|string',
            'tipo_cambio' => ['required', 'numeric', 'min:1'],
            'lugar_entrega' => ['nullable', 'string'],
            'tipo_compra' => ['required', 'string'],
            'colaborador' => ['nullable', 'required_if:tipo_compra,A'],
            'sedes' => 'required',
            'centro_costo' => 'required',
            'renglon_presupuesto' => 'required',
            'cuenta_contable' => 'nullable',
        ]);

        if (auth()->user()->fichaActiva() == 0) {
            return redirect()->back()
                ->withErrors(['ficha_activa' => 'Debe tener una ficha seleccionada.'])
                ->withInput();
        }

        $numero = DB::connection('sqlsrv-secondary')->table('NPROXPV')->select(DB::raw("(REQ_H + 1) siguiente"))->first();
        DB::connection('sqlsrv-secondary')->table('NPROXPV')->increment('REQ_H');
        $ficha = Ficha::find(auth()->user()->fichaActiva());

        $requisicion = new RequisicionH();
        $requisicion->NUMERO = $numero->siguiente;
        $requisicion->FECHA = date('Y-m-d');
        $requisicion->SOLICITANTE_NUM = auth()->user()->fichaActiva();
        $requisicion->SOLICITANTE = Str::limit(auth()->user()->nombreDeFichaActiva(), 100, '');
        $requisicion->COMENTARIOS = $request->comentarios;
        $requisicion->EMPRESA = $request->empresa;
        $requisicion->MONEDA = $request->moneda;
        $requisicion->TIPO_CAMBIO = $request->tipo_cambio;
        $requisicion->ESTATUS = 'A';
        $requisicion->RENGLONES = 0;
        $requisicion->FECHA_ENTREGA = $request->fecha;
        $requisicion->USUARIO = auth()->id();
        $requisicion->USUARIO_NOMBRE = Str::limit(auth()->user()->name, 50, '');
        $requisicion->FECHA_CIERRE = date('Y-m-d');
        $requisicion->HORA_CIERRE = date('H:i');
        $requisicion->ENTIDAD = $ficha->ENTIDAD;
        $requisicion->SECCION = $ficha->SECCION ?? '';
        $requisicion->COMENTARIO2 = $request->lugar_entrega ?? '';
        $requisicion->T_RECHAZO = $request->tipo_compra;
        $requisicion->USUARIO_DESTINO = $request->colaborador != '' ? implode(',', $request->colaborador) : '';
        $requisicion->CTROCSTO = $request->centro_costo;
        $requisicion->SEDES = implode(',', $request->sedes);
        $requisicion->RENGLON_PRESUPUESTO = $request->renglon_presupuesto;
        $requisicion->CUENTA_CONTABLE = $request->cuenta_contable;

        $requisicion->save();

        return redirect()->route('requisiciones.edit', $requisicion)->with(['status' => 'success', 'message' => 'Requisicion created successfully!']);
    }

    public function edit(RequisicionH $requisicion)
    {
        $empresas = DB::connection('sqlsrv-secondary')->table('EMPRESA')->get();
        $monedas = DB::connection('sqlsrv-secondary')->table('MONEDA')->selectRaw('rtrim(CLAVE) CLAVE, rtrim(NOMBRE_CORTO) NOMBRE_CORTO')->get();
        $sedes = DB::connection('sqlsrv')->table('sucursal')->selectRaw("RECNUM, CONCAT(rtrim(CODIGO), ' - ',  rtrim(NOMBRE)) as NOMBRE")->get();
        $proveedores = DB::connection('sqlsrv-secondary')->table('PRVEEDOR')->get();
        $conceptos = DB::connection('sqlsrv-secondary')->table('CONCPPTO')->get();
        $renglones = DB::connection('sqlsrv-secondary')->table('GPO_PPTO')->get();
        $cuentas = DB::connection('sqlsrv-secondary')->table('CUENTA')->where('SUMARIA_O_MOVTO', 'M')->selectRaw("DFRECNUM, CONCAT(rtrim(CLAVE), ' - ',  rtrim(NOMBRE)) NOMBRE")->get();
        $centros_costo = CentroDeCosto::selectRaw("NUMERO, CONCAT(rtrim(CLAVE), ' - ',  rtrim(DESCRIPCION)) DESCRIPCION")->get();
        $fichas = Ficha::where('ESTATUS', 'A')->selectRaw("NUMERO, CONCAT(rtrim(NOMBRE_1), ' ',  rtrim(APELLIDO_1)) as NOMBRE")->orderBy('NOMBRE', 'ASC')->get();


        return view('requisiciones.edit')->with(['requisicion' => $requisicion, 'empresas' => $empresas, 'monedas' => $monedas, 'proveedores' => $proveedores, 'centros_costo' => $centros_costo, 'conceptos' => $conceptos, 'renglones' => $renglones, 'cuentas' => $cuentas, 'sedes' => $sedes, 'fichas' => $fichas]);
    }

    public function update(Request $request, RequisicionH $requisicion)
    {
        $request->validate([
            'renglon_presupuesto' => 'required',
            'centro_costo' => 'required',
            'cuenta_contable' => 'nullable',
            'sedes' => 'required',
            'colaborador' => ['nullable', 'required_if:tipo_compra,A'],
        ]);

        $requisicion->RENGLON_PRESUPUESTO = $request->renglon_presupuesto;
        $requisicion->CTROCSTO = $request->centro_costo;
        $requisicion->CUENTA_CONTABLE = $request->cuenta_contable;
        $requisicion->SEDES = implode(',', $request->sedes);
        $requisicion->USUARIO_DESTINO = $request->colaborador != '' ? implode(',', $request->colaborador) : '';
        $requisicion->save();

        return redirect()->route('requisiciones.edit', $requisicion)->with(['status' => 'success', 'message' => 'Requisicion updated successfully!']);
    }

    public function cerrar(RequisicionH $requisicion)
    {
        $tieneDetallesNoAutorizados = RequisicionH::where('NUMERO', $requisicion->NUMERO)
            ->whereHas('detalles', function ($query) {
                $query->whereDoesntHave('detalles', function ($subQuery) {
                    $subQuery->where('AUTORIZA1', 'S');
                });
            })->exists();

        if ($tieneDetallesNoAutorizados) {
            return redirect()->route('requisiciones.edit', $requisicion)->with(['status' => 'error', 'message' => 'En cada detalle debe tener una cotizacion sugerida!']);
        }

        $requisicion->RAZON_RECHAZO = '';
        $requisicion->ESTATUS = 'B';

        $usuario = User::find($requisicion->ficha->referencia());
        if ($usuario->jefe_id == $usuario->id) {
            $requisicion->ESTATUS = 'C';
        }

        $requisicion->setConnection('sqlsrv-secondary')->save();

        return redirect()->route('requisiciones.edit', $requisicion)->with(['status' => 'success', 'message' => 'Requisicion closed successfully!']);
    }

    public function obtenerTotal(RequisicionH $requisicion)
    {
        return response()->json([
            'total' => $requisicion->obtenerTotalPorEstado(),
            'totalP' => $requisicion->obtenerTotalP()
        ]);
    }

    public function reporte(RequisicionH $requisicion)
    {
        view()->share(['requisicion' => $requisicion]);

        $pdf = PDF::loadView('reportes.requisicion')->setPaper('a4', 'portrait');
        return $pdf->stream('requisiciones.pdf');
    }
}
