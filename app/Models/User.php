<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Los atributos que se pueden asignar masivamente.
     */
    protected $fillable = 
    [
        'name',
        'email',
        'password',
        'tipo',
        'estado',
    ];

    /**
     * Atributos ocultos para arrays.
     */
    protected $hidden = 
    [
        'password',
        'remember_token',
    ];

    /**
     * Atributos que se deben convertir.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
