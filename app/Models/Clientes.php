<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Clientes extends Authenticatable
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
        'tipo_acesso_id',
    ];

    protected $hidden = [
        'password',
    ];

    public function tipoAcesso()
    {
        return $this->belongsTo(TipoAcesso::class, 'tipo_acesso_id');
    }
}