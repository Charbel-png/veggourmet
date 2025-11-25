<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id_producto';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'id_categoria',
        'nombre',
        'descripcion',
        'estado',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id_categoria');
    }

    public function inventario()
    {
        return $this->hasOne(Inventario::class, 'id_producto', 'id_producto');
    }

    // Relación con ingredientes por medio de la tabla recetas
    public function ingredientes()
    {
        return $this->belongsToMany(Ingrediente::class, 'recetas', 'id_producto', 'id_ingrediente')
                    ->withPivot('cantidad');
    }
}