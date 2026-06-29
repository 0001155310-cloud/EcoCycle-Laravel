<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = ['user_id', 'acao', 'descricao', 'ip_address'];

    public function user()
    {
        // Relaciona o log com o usuário/cliente que realizou a ação
        return $this->belongsTo(Clientes::class, 'user_id');
    }

    // Método estático auxiliar para gravar o log facilmente em qualquer Controller
    public static function log($acao, $descricao = null)
    {
        self::create([
            'user_id'    => auth()->id(),
            'acao'       => $acao,
            'descricao'  => $descricao,
            'ip_address' => request()->ip(),
        ]);
    }
}