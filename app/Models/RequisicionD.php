<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RequisicionD extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv-secondary';
    
    public $timestamps = false;
    
    public $incrementing = false;
    
    protected $table = 'REQ_D';

    protected $primaryKey = 'NUMERO';

    protected $casts = [
        'CTROCSTO' => 'string',
    ];

    public function requisicion() :BelongsTo
    {
        return $this->belongsTo(RequisicionH::class, 'REQ_H', 'NUMERO');
    }

    public function detalles() :HasMany
    {
        return $this->hasMany(RequisicionC::class, 'REQ_D', 'NUMERO');
    }
}
