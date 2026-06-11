<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeituraArduino extends Model
{
    protected $table = 'leituras_arduino';

    protected $fillable = [
        'dispositivo_id',
        'temperatura',
        'umidade',
        'peso',
        'ph',
        'gas',
        'status_contaminacao',
        'plastico_detectado',
        'origem_cliente',
        'observacao',
    ];
}
