<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $table = 'inventario';      // nombre exacto de la tabla
    protected $primaryKey = 'id_inventario';
    public $timestamps = false;

    protected $fillable = [
        'id_inventario',   // FK a productos.id_producto
        'stock',
        'stock_minimo',
    ];

    public function producto()
    {
        // id_inventario → productos.id_producto
        return $this->belongsTo(Producto::class, 'id_inventario', 'id_producto');
    }
}
