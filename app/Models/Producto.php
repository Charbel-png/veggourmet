<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id_producto';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'id_categoria',
        'descripcion',
        'precio_venta',
        'imagen',
        'estado',
        // lo que tengas en tu tabla productos…
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id_categoria');
    }

    public function inventario()
    {
        // Un producto tiene UN registro de inventario
        return $this->hasOne(Inventario::class, 'id_producto', 'id_producto');
    }
}
