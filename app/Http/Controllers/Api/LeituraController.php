<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LeituraArduino;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
     * Retorna os dados consolidados (médias) de todas as máquinas logadas e ativas.
     */
    public function latest(): JsonResponse
    {
        // Define o intervalo de atividade (máquinas que enviaram dados nos últimos 10 minutos)
        $limiteAtivo = Carbon::now()->subMinutes(10);

        // Agrega os dados reais do banco sem usar dados fictícios
        $agregado = LeituraArduino::select(
                DB::raw('AVG(umidade) as umidade_media'),
                DB::raw('AVG(temperatura) as temperatura_media'),
                DB::raw('AVG(ph) as ph_medio'),
                DB::raw('AVG(gas) as gas_medio'),
                DB::raw('SUM(peso) as peso_total'),
                DB::raw('COUNT(DISTINCT dispositivo_id) as total_maquinas')
            )
            ->where('created_at', '>=', $limiteAtivo)
            ->first();

        // Fallback preventivo caso nenhuma máquina esteja transmitindo no momento
        if (!$agregado || $agregado->total_maquinas == 0) {
            return response()->json([
                'ok' => true,
                'data' => [
                    'id' => time(),
                    'umidade_media' => 0,
                    'temperatura_media' => 0,
                    'ph_medio' => 0,
                    'gas_medio' => 0,
                    'peso_total' => 0,
                    'total_maquinas' => 0
                ]
            ]);
        }

        return response()->json([
            'ok' => true,
            'data' => [
                'id' => time(), // Timestamp simulando ID dinâmico para forçar a atualização dos gráficos
                'umidade_media' => (float) $agregado->umidade_media,
                'temperatura_media' => (float) $agregado->temperatura_media,
                'ph_medio' => (float) $agregado->ph_medio,
                'gas_medio' => (float) $agregado->gas_medio,
                'peso_total' => (float) $agregado->peso_total,
                'total_maquinas' => (int) $agregado->total_maquinas,
            ],
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);
    }
}