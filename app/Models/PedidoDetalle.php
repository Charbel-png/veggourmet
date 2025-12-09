<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PedidoDetalle extends Model
{
    protected $table = 'pedidos_detalle';
    public $timestamps = false;

    // La tabla no tiene PK autoincremental
    protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = [
        'id_pedido',
        'id_producto',
        'cantidad',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido', 'id_pedido');
    }
}
