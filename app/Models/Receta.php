<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    protected $table = 'recetas';
    public $timestamps = false;

    protected $fillable = [
        'id_producto',
        'id_ingrediente',
        'cantidad',
    ];

    // No hay id autoincremental
    protected $primaryKey = null;
    public $incrementing = false;

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }

    public function ingrediente()
    {
        return $this->belongsTo(Ingrediente::class, 'id_ingrediente', 'id_ingrediente');
    }
}
