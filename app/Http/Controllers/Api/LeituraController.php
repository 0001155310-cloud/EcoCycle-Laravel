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
     * ESCOPO ADMIN: Retorna os dados consolidados (médias) dos últimos 15 minutos.
     */
    public function latest(): JsonResponse
    {
        $limiteAtivo = Carbon::now()->subMinutes(15);

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

        if (!$agregado || $agregado->total_maquinas == 0) {
            return response()->json([
                'ok' => true,
                'data' => [
                    'id' => null,
                    'umidade' => 0,
                    'temperatura' => 0,
                    'ph' => 0,
                    'gas' => 0,
                    'peso' => 0,
                    'total_maquinas' => 0,
                    'status_contaminacao' => 'Desconectado'
                ]
            ]);
        }

        $status = 'ideal';
        if ($agregado->gas_medio > 600) {
            $status = 'risco';
        } elseif ($agregado->gas_medio > 300) {
            $status = 'atencao';
        }

        return response()->json([
            'ok' => true,
            'data' => [
                'id' => time(), 
                'umidade' => (float) $agregado->umidade_media,
                'temperatura' => (float) $agregado->temperatura_media,
                'ph' => (float) ($agregado->ph_medio ?? 7.0), 
                'gas' => (float) $agregado->gas_medio,
                'peso' => (float) $agregado->peso_total,
                'total_maquinas' => (int) $agregado->total_maquinas,
                'status_contaminacao' => $status,
            ],
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);
    }

    /**
     * ESCOPO CLIENTE: Retorna o último registro bruto exato (Ao Vivo).
     */
    public function live(): JsonResponse
    {
        $ultimaLeitura = LeituraArduino::orderBy('created_at', 'desc')->first();

        // Se não houver dados ou o dispositivo parar de enviar por mais de 60 segundos
        if (!$ultimaLeitura || $ultimaLeitura->created_at->diffInSeconds(now()) > 60) {
            return response()->json([
                'ok' => true,
                'data' => [
                    'id' => null,
                    'umidade' => 0,
                    'temperatura' => 0,
                    'ph' => 0,
                    'gas' => 0,
                    'peso' => 0,
                    'status_contaminacao' => 'Desconectado'
                ]
            ]);
        }

        $status = 'Ideal';
        if ($ultimaLeitura->gas > 600) {
            $status = 'Risco';
        } elseif ($ultimaLeitura->gas > 300) {
            $status = 'Atenção';
        }

        return response()->json([
            'ok' => true,
            'data' => [
                'id' => $ultimaLeitura->id,
                'umidade' => (float) $ultimaLeitura->umidade,
                'temperatura' => (float) $ultimaLeitura->temperatura,
                'ph' => (float) ($ultimaLeitura->ph ?? 7.0),
                'gas' => (float) $ultimaLeitura->gas,
                'peso' => (float) ($ultimaLeitura->peso ?? 0.0),
                'status_contaminacao' => $status
            ],
            'updated_at' => $ultimaLeitura->created_at->toDateTimeString(),
        ]);
    }
}