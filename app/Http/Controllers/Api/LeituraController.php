<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LeituraArduino;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LeituraController extends Controller
{
    /**
     * Recebe os dados do Arduino/ESP32 e salva no banco de dados.
     */
    public function store(Request $request): JsonResponse
    {
        $dadosValidados = $request->validate([
            'dispositivo_id' => 'string',
            'temperatura'    => 'numeric|nullable',
            'umidade'        => 'numeric|nullable',
            'peso'           => 'numeric|nullable',
            'ph'             => 'numeric|nullable',
            'gas'            => 'numeric|nullable',
            'origem_cliente' => 'string|nullable',
        ]);

        $leitura = LeituraArduino::create($dadosValidados);

        return response()->json([
            'mensagem' => 'Leitura salva com sucesso!',
            'id'       => $leitura->id
        ], 201);
    }

    /**
     * Retorna a última leitura do banco para o JavaScript da página Home.
     */
    public function latest(): JsonResponse
    {
        $ultimaLeitura = LeituraArduino::latest()->first();

        return response()->json([
            'data' => $ultimaLeitura
        ]);
    }
}