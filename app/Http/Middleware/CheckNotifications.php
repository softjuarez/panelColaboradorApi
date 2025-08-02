<?php

namespace App\Http\Middleware;

use App\Models\Noticia;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class CheckNotifications
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Session::get('show_notifications_on_redirect') && Auth::check()) {
            Session::forget('show_notifications_on_redirect');
            
            $notifications = Noticia::selectRaw("id, contenido, titulo, FORMAT(created_at, 'dd/MM/yyyy') created, creador")->with('Creador')
            ->where('fecha_vencimiento', '>=', now())
            ->whereRaw("(select count(*) from noticia_vistas where noticia_id = noticias.id and user_id = ". auth()->user()->id .") = 0")
            ->get();
                
            if ($notifications->isNotEmpty()) {
                view()->share('showNotificationsModal', true);
                view()->share('notificationsToShow', $notifications);
            }
        }
        
        return $next($request);
    }
}
