<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';          // nombre de la tabla
    protected $primaryKey = 'id_producto';   // PK de la tabla
    public $timestamps = false;              // tu tabla no usa created_at/updated_at

    protected $fillable = [
        'id_categoria',
        'nombre',
        'descripcion',
        'precio',
        'estado',
    ];
}
