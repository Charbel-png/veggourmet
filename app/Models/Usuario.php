<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios'; // ajusta si tu tabla se llama diferente
    protected $primaryKey = 'id_usuario'; // o 'id', como lo tengas
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'tipo', // 'admin', 'operador', 'cliente'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
