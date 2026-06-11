<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoAcesso extends Model
{
    protected $table = 'tipos_acesso';

    protected $fillable = [
        'nome',
        'descricao',
    ];

    public function clientes()
    {
        return $this->hasMany(Clientes::class, 'tipo_acesso_id');
    }
}
