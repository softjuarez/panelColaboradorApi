<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $userId = Auth::id();

        $fichaUsuario = DB::table('ficha_usuario')
            ->where('referencia', 's')
            ->where('usuario_id', $userId)
            ->first();

        
        DB::table('ficha_activa')->updateOrInsert(
            ['usuario_id' => Auth::id()],
            ['ficha_id' => $fichaUsuario->ficha_id ?? 0]
        );
        
        Session::put('show_notifications_on_redirect', true);

        Auth::user()->configuracion()->firstOrCreate(
            [],
            [
                'mostrar_bandeja_noticias' => 'S'
            ]
        );

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
