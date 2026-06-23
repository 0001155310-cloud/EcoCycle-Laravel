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
            'dispositivo_id' => 'string|nullable',
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
     * Retorna os dados consolidados (médias) mapeados exatamente para o Frontend.
     */
    public function latest(): JsonResponse
    {
        // Define o intervalo de atividade (máquinas que enviaram dados nos últimos 10 minutos)
        $limiteAtivo = Carbon::now()->subMinutes(10);

        // Agrega os dados reais do banco
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
                    'id' => null, // Deixando nulo para ativar o aviso de "Dispositivo não encontrado" no JS
                    'umidade' => 0,
                    'temperatura' => 0,
                    'ph' => 0,
                    'gas' => 0,
                    'peso' => 0,
                    'total_maquinas' => 0,
                    'status_contaminacao' => 'desconectado'
                ]
            ]);
        }

        // Determina o status com base no novo sensor de Gás ou Umidade
        // Exemplo: se o gás passar de 400 ppm, gera um alerta automático no painel
        $status = 'ideal';
        if ($agregado->gas_medio > 600) {
            $status = 'risco';
        } elseif ($agregado->gas_medio > 300) {
            $status = 'atencao';
        }

        return response()->json([
            'ok' => true,
            'data' => [
                'id' => time(), // Mantido o timestamp dinâmico para forçar o Chart.js a plotar a linha em tempo real
                'umidade' => (float) $agregado->umidade_media,
                'temperatura' => (float) $agregado->temperatura_media,
                'ph' => (float) ($agregado->ph_medio ?? 7.0), // Fallback amigável para o indicador de pH fixo
                'gas' => (float) $agregado->gas_medio,
                'peso' => (float) $agregado->peso_total,
                'total_maquinas' => (int) $agregado->total_maquinas,
                'status_contaminacao' => $status,
            ],
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);
    }
}