<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedidos';
    protected $primaryKey = 'id_pedido';
    public $timestamps = false;

    protected $fillable = [
        'cliente_id',
        'vendedor_id',
        'fecha',
        'estado_id',
        'direccion_envio_id',
        'total',
    ];

    public function cliente()
    {
        // clientes.id_cliente
        return $this->belongsTo(Cliente::class, 'cliente_id', 'id_cliente');
    }

    public function detalles()
    {
        // pedidos_detalle.id_pedido
        return $this->hasMany(DetallePedido::class, 'id_pedido', 'id_pedido');
    }

    public function estado()
    {
        // estados_pedido.estado_id
        return $this->belongsTo(EstadoPedido::class, 'estado_id', 'estado_id');
    }
}
