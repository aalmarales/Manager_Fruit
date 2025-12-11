<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyLog extends Model
{
    protected $fillable = [
        'fecha',
        'product_id',
        'stock_inicial',
        'compras_dia',
        'ventas_dia',
        'mermas_dia',
        'stock_final'
    ];

    function product():BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
