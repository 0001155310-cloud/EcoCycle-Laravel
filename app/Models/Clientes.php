<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    protected $fillable = [
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