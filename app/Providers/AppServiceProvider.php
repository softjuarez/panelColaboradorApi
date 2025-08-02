<?php

namespace App\Providers;

use App\Models\ArchivoRequisicion;
use App\Models\ProveedorUsuario;
use App\Models\RequisicionD;
use App\Models\RequisicionH;
use App\Observers\ArchivoRequisicionObserver;
use App\Observers\RequisicionDObserver;
use App\Observers\RequisicionHObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale('es');
        RequisicionH::observe(RequisicionHObserver::class);
        RequisicionD::observe(RequisicionDObserver::class);
        ArchivoRequisicion::observe(ArchivoRequisicionObserver::class);

        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
    }
}
