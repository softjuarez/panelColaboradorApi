<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckEditRequisicionPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->hasPermission('edit-requisicion') == false && $request->user()->hasPermission('edit-autoriza-jefe' ) == false && $request->user()->hasPermission('edit-autoriza-ppto' ) == false && $request->user()->hasPermission('edit-autoriza-tesoreria' ) == false && $request->user()->hasPermission('edit-autoriza-compra' ) == false && $request->user()->hasPermission('edit-autoriza-gestor' ) == false && $request->user()->hasPermission('edit-autoriza-comite' ) == false) {
            abort(403, 'No tienes permiso para realizar esta acción.');
        }

        return $next($request);
    }
}
