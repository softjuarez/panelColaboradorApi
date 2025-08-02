<?php

namespace App\Http\Controllers;

use App\Models\Ficha;
use App\Models\RequisicionH;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AutorizaRequisicionPorLimiteController extends Controller
{
    public function index($search = "")
    {
        $configuracion = DB::table('configuraciones')->first();

        // Consulta base para las requisiciones
        $requisiciones = RequisicionH::where('SOLICITANTE', 'LIKE', '%' . $search . '%')
            ->where('ESTATUS', 'C')
            ->get();


        // Filtrar y clasificar las requisiciones según el límite del usuario
        $requisicionesFiltradas = $requisiciones->filter(function ($requisicion) use ($configuracion) {
            $total = $requisicion->obtenerTotal(); // Usar el método obtenerTotal()
    
            // Determinar si la requisición es de monto mayor o menor
            if ($total > $configuracion->limite && auth()->user()->id == $configuracion->validador_monto_mayor) {
                $requisicion->monto_tipo = 'monto mayor';
                return true;
            } elseif ($total <= $configuracion->limite && auth()->user()->id == $configuracion->validador_monto_menor) {
                $requisicion->monto_tipo = 'monto menor';
                return true;
            }
    
            return false;
        });

        // Paginar manualmente las requisiciones filtradas
        $page = request()->get('page', 1); // Obtener la página actual
        $perPage = 15; // Número de elementos por página
        $paginatedItems = $requisicionesFiltradas->slice(($page - 1) * $perPage, $perPage); // Paginar manualmente

        // Crear un objeto LengthAwarePaginator
        $requisicionesPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $paginatedItems,
            $requisicionesFiltradas->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
      

        return view('autorizaciones_por_limite_requisiciones.index')->with(['requisiciones' => $requisicionesPaginated, 'search' => $search]);
    }

    public function edit(RequisicionH $requisicion)
    {        
        return view('autorizaciones_por_limite_requisiciones.edit')->with(['requisicion' => $requisicion]);
    }

    public function autorizar(Request $request, RequisicionH $requisicion)
    {
        $request->validate([
            'motivo_autoriza' => 'required|string|max:255',
        ]);

        $requisicion->ESTATUS = 'D';
        $requisicion->RAZON_AUTORIZA_POR_LIMITE = $request->motivo_autoriza;

        $requisicion->save();

        return redirect()->route('autoriza-por-limite-requisicion.index')->with(['status' => 'success', 'message' => 'Requisición autorizada correctamente.']);
    }

    public function rechazar(Request $request, RequisicionH $requisicion)
    {
        $request->validate([
            'motivo_rechazo' => 'required|string|max:255',
        ]);

        $requisicion->ESTATUS = 'A';
        $requisicion->RAZON_RECHAZO = $request->motivo_rechazo;
        $requisicion->save();

        return redirect()->route('autoriza-por-limite-requisicion.index')->with(['status' => 'success', 'message' => 'Requisición rechazada correctamente.']);
    }

    private function obtenerFichasMontoMayor()
    {
        return Ficha::join('ficha_usuario', 'FICHA.NUMERO', '=', 'ficha_usuario.ficha_id')
        ->whereIn('ficha_usuario.usuario_id', auth()->user()->autorizaLimiteMayor()->pluck('id'))
        ->pluck('NUMERO');
    }

    private function obtenerFichasMontoMenor()
    {
        return Ficha::join('ficha_usuario', 'FICHA.NUMERO', '=', 'ficha_usuario.ficha_id')
        ->whereIn('ficha_usuario.usuario_id', auth()->user()->autorizaLimiteMenor()->pluck('id'))
        ->pluck('NUMERO');
    }
}
