<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequisicionC extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv-secondary';
    
    public $timestamps = false;
    
    public $incrementing = false;
    
    protected $table = 'REQ_C';

    protected $primaryKey = 'RECNUM';

    protected $casts = [
        'REFERENCIA_PR' => 'string',
        // Otros casteos que puedas tener en tu modelo
    ];

    public function encabezado() :BelongsTo
    {
        return $this->belongsTo(RequisicionD::class, 'REQ_D', 'NUMERO');
    }
}
