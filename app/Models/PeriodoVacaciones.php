<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PeriodoVacaciones extends Model
{
    use HasFactory;

    protected $table = 'PER_VAC';

    public $timestamps = false;

    protected $primaryKey = 'RECNUM';

    protected $fillable = [
        'PERIODO',
        'FICHA',
        'FECHA',
        'ANIOS',
        'DIA_GOZAR',
        'FECHA_FIN',
    ];

    public function esPeriodoActual()
    {
        $now = Carbon::now();
        $fechaInicio = Carbon::parse($this->FECHA);
        $fechaFin = Carbon::parse($this->FECHA_FIN);

        return $now->between($fechaInicio, $fechaFin);
    }

    public function esAplicableResguardoSemanaSanta()
    {
        $year = now()->year;
        $easterSunday = easter_date($year);
        $holyFriday = strtotime('-2 days', $easterSunday);

        return now()->timestamp <= $holyFriday;
    }

    public function esAplicableResguardoFinDeAnio()
    {
        $today = Carbon::now();
        $lastDayOfYear = Carbon::create($today->year, 12, 31);

        return $today->lte($lastDayOfYear);
    }
}
