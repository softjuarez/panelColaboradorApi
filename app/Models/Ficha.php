<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ficha extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';

    protected $table = 'FICHA';

    public $timestamps = false;

    protected $primaryKey = 'NUMERO';

    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'ficha_usuario', 'ficha_id', 'usuario_id');
    }

    public function referencia()
    {
        $usuarioReferencia = $this->usuarios()
        ->wherePivot('referencia', 's')
        ->first();

        return $usuarioReferencia ? $usuarioReferencia->id : 0;
    }

    public function jefeInmediato()
    {
        $referencia = $this->referencia();
        $nombre = 'No tiene usuario referencia';

        if ($referencia) {
            $usuarioReferencia = User::find($referencia);
            foreach($usuarioReferencia->Jefe->fichas as $item) {
                if ($item->pivot->referencia == 's'){
                    $nombre = $item->NOMBRE;
                }
            }
        }

        return $nombre;
    }

    public function nomina($nomina_id)
    {
        $nomina = DB::select("
            SELECT td.nombre,(ap.VALOR + ap.VLR_DEDU_DEVENG) as valor
            FROM nomina_d nd
            INNER JOIN apl_dedu ap ON (ap.nomina_d=nd.NUMERO)
			INNER JOIN DEDUCCN dedu ON (dedu.NUMERO = ap.DEDUCCN)
            INNER JOIN t_deduc td ON (dedu.T_DEDUC = td.codigo)
            WHERE nd.NUMERO = $nomina_id
        ");

        return $nomina;
    }

    public function numeroDeNomina($fecha)
    {
        $nomina = DB::select("
            SELECT dbo.Get_LastDay('$fecha') as fecha
        ");

        if (date('Y-m-d', strtotime($nomina[0]->fecha)) == $fecha) {
            return 1;
        }

        return 2;
    }

    public function adjuntos()
    {
        return $this->morphMany(Adjunto::class, 'adjuntable');
    }

    public function diasDeVacacionesDisponibles()
    {
        $dias = PeriodoVacaciones::where('FICHA', $this->NUMERO)->sum(DB::raw("DIA_GOZAR - DIA_GOZADOS"));
        $configuracion = DB::table('configuraciones')->first();

        if ($this->esAplicableResguardoSemanaSanta()) {
            $dias = $dias - $configuracion->dias_resguardo_semana_santa;
        }

        if ($this->esAplicableResguardoFinDeAnio()) {
            $dias = $dias - $configuracion->dias_resguardo_fin_anio;
        }

        return $dias;
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

    public function Entidad()
    {
        return DB::table("ENTIDAD")->where("NUMERO", $this->ENTIDAD)->first();
    }
}
