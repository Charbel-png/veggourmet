<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $table = 'inventario';
    protected $primaryKey = 'id_producto'; // misma PK y FK
    public $incrementing = false;          // porque también es FK
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = ['id_producto', 'stock', 'stock_minimo'];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }
}