<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// 1. Endpoint que o Python consulta para saber qual USB ler
Route::get('/api/arduino/config-porta', function() {
    // Retorna a porta salva ou 'COM3' como padrão
    return response()->json(['porta' => Cache::get('porta_serial_ativa', 'COM3')]);
});

// 2. Atualização do seu endpoint existente que alimenta o painel administrativo
Route::get('/api/arduino/latest', function(Request $request) {
    // Pega a porta enviada pelo JavaScript da página (?port=COM3)
    $porta = $request->query('port', 'COM3');
    
    // Salva no Cache do Servidor (Render) para o Python local descobrir
    Cache::put('porta_serial_ativa', $porta, 3600); // Salva por 1 hora

    // Busca no banco apenas o último registro vindo especificamente dessa porta USB
    $dados = DB::table('leituras') // Certifique-se de que seu banco tem a coluna 'porta_serial'
                ->where('porta_serial', $porta)
                ->orderBy('id', 'desc')
                ->first();

    return response()->json([
        'data' => $dados
    ]);
})->name('arduino.latest');