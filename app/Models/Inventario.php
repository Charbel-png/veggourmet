<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $table = 'inventario';

    // Ahora la PK es id_producto
    protected $primaryKey = 'id_producto';

    // No es autoincremental (porque coincide con productos.id_producto)
    public $incrementing = false;
    protected $keyType = 'int';

    // La tabla inventario no maneja created_at / updated_at
    public $timestamps = false;

    protected $fillable = [
        'id_producto',
        'stock',
        'stock_minimo',
    ];

    public function producto()
    {
        // inventario.id_producto -> productos.id_producto
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }
}
