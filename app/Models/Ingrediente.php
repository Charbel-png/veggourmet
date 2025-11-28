<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;
use App\Models\Receta;

class Ingrediente extends Model
{
    protected $table = 'ingredientes';
    protected $primaryKey = 'id_ingrediente';
    public $timestamps = false;

    protected $fillable = ['nombre', 'id_unidad', 'activo'];

    public function unidad()
    {
        return $this->belongsTo(UnidadMedida::class, 'id_unidad', 'id_unidad');
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'recetas', 'id_ingrediente', 'id_producto')
                    ->withPivot('cantidad');
    }
}