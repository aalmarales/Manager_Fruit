<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nombre',
        'precio_compra',
        'precio_venta',
        'dias_caducidad',
        'provider_id',
        'category_id'
    ];

    function provider():BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    function category():BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    function daily_logs():HasMany
    {
        return $this->hasMany(DailyLog::class);
    }


}
