<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoCompra extends Model
{
    protected $table = 'estados_compra';
    protected $primaryKey = 'id_estado';
    public $timestamps = false;

    protected $fillable = ['nombre'];
}