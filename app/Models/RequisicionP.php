<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class RequisicionP extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv-secondary';
    
    public $timestamps = false;
    
    public $incrementing = false;
    
    protected $table = 'REQ_P';

    protected $primaryKey = 'RECNUM';

    protected $casts = [
        'CONCPPTO' => 'integer',
    ];

    public function requisicion() :BelongsTo
    {
        return $this->belongsTo(RequisicionH::class, 'REQ_H', 'NUMERO');
    }

    public function concepto()
    {
        $concepto = DB::connection('sqlsrv-secondary')->table('CONCPPTO')->where('NUMERO_INTERNO', $this->CONCPPTO)->first();
        return $concepto->DESCRIPCION;
    }
}
