<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'id_cliente';
    public $timestamps = false; // la tabla no tiene created_at/updated_at

    protected $fillable = [
        'nombre',
        'ap_paterno',
        'ap_materno',
        'email',
    ];
    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_cliente', 'id_cliente');
    }
}
