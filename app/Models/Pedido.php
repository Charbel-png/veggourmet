<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedidos';
    protected $primaryKey = 'id_pedido';
    public $timestamps = false;

    protected $fillable = [
        'id_cliente',
        'fecha',
        'id_estado',
        'tipo',
        'id_empleado_toma',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente');
    }

    public function estado()
    {
       return $this->belongsTo(EstadoPedido::class, 'id_estado', 'id_estado');
    // o el nombre de tu modelo de estados
    }

    public function detalles()
    {
        return $this->hasMany(PedidoDetalle::class, 'id_pedido', 'id_pedido');
    }
}
