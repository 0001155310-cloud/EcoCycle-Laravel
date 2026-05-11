<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuarios extends Authenticatable
{
    use Notifiable;

    protected $table = 'clientes';

    protected $fillable = [
        'nome',
        'email',
        'password',
        'tel',
        'endereco',
        'estado',
        'cpf',
    ];

    protected $hidden = [
        'password',
    ];
}