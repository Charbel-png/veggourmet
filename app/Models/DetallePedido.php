<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    protected $table = 'pedidos_detalle';
    public $timestamps = false;

    // En la BD la PK real es compuesta, pero para Eloquent
    // usamos una sola (no la vamos a editar nunca por ID).
    protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = [
        'id_pedido',
        'id_producto',
        'cantidad',
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido', 'id_pedido');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }
}
