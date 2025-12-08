<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id_producto';
    public $timestamps = false;

    protected $fillable = [
        'id_categoria',
        'nombre',
        'descripcion',
        'imagen',
        'precio_venta',   // si ya agregaste esta columna
        'estado',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id_categoria');
    }

    public function inventario()
    {
        // 1 producto tiene 1 registro en inventario
        return $this->hasOne(Inventario::class, 'id_inventario', 'id_producto');
    }
}
