<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    protected $table = 'inventario';
    protected $primaryKey = 'id_producto';   // <--- CLAVE REAL
    public $incrementing = false;            // porque no es autoincrement
    protected $keyType = 'int';

    protected $fillable = [
        'id_producto',
        'stock',
        'stock_minimo',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }

    // Para que el route model binding use id_producto
    public function getRouteKeyName()
    {
        return 'id_producto';
    }
}
