<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Receta extends Pivot
{
    protected $table = 'recetas';
    public $timestamps = false;
    public $incrementing = false; // no hay id autoincremental

    protected $fillable = [
        'id_producto',
        'id_ingrediente',
        'cantidad',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }

    public function ingrediente()
    {
        return $this->belongsTo(Ingrediente::class, 'id_ingrediente', 'id_ingrediente');
    }
}