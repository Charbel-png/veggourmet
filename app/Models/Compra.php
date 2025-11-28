<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'compras';
    protected $primaryKey = 'id_compra';
    public $timestamps = false;

    protected $fillable = ['id_proveedor', 'fecha', 'id_estado'];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor', 'id_proveedor');
    }

    public function estado()
    {
        return $this->belongsTo(EstadoCompra::class, 'id_estado', 'id_estado');
    }

    public function detalles()
    {
        return $this->hasMany(CompraDetalle::class, 'id_compra', 'id_compra');
    }
}