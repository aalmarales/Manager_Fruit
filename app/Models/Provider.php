<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Provider extends Model
{
    protected $fillable=[
        'nombre',
        'telefono',
        'direccion',
        'especialidad',
        'activo'
    ];

    function products():HasMany
    {
        return $this->hasMany(Product::class);
    }
}
