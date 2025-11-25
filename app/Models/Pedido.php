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
    }

    public function empleadoToma()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado_toma', 'id_empleado');
    }

    // Productos del pedido con cantidad (tabla pedidos_detalle como pivot)
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'pedidos_detalle', 'id_pedido', 'id_producto')
                    ->withPivot('cantidad');
    }
}