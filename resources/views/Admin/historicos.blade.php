@extends('Admin.layout_admin')
@section('title', 'Histórico Global - EcoCycle')

@section('styles')
<style>
    .t-scroll { width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }
    .badge-ph { padding: 4px 8px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; }
    .ph-acido { background: #fee2e2; color: #b91c1c; }
    .ph-neutro { background: #dcfce7; color: #15803d; }
    .ph-alcalino { background: #e0f2fe; color: #0369a1; }
    
    .badge-action { padding: 4px 8px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; }
    .act-login { background: #e0f2fe; color: #0369a1; }
    .act-update { background: #fef9c3; color: #a16207; }
    .act-danger { background: #fee2e2; color: #b91c1c; }
    .act-default { background: #f1f5f9; color: #475569; }

    /* Customização focada nos links gerados dinamicamente pelo Laravel */
    .pagination-wrapper { margin-top: 1.5rem; display: flex; justify-content: center; gap: 4px; font-family: sans-serif; }
    .pagination-wrapper svg { width: 16px; height: 16px; vertical-align: middle; }
    .pagination-wrapper a, .pagination-wrapper span { 
        padding: 6px 12px; 
        border: 1px solid #e2e8f0; 
        border-radius: 6px; 
        color: #16a34a; 
        text-decoration: none; 
        font-size: 0.875rem; 
        font-weight: 600;
        background: #ffffff;
    }
    .pagination-wrapper a:hover { background: #f8fafc; color: #15803d; border-color: #cbd5e1; }
    .pagination-wrapper .active span, .pagination-wrapper [aria-current="page"] span { 
        background: #16a34a !important; 
        color: #ffffff !important; 
        border-color: #16a34a !important; 
    }
    .pagination-wrapper [disabled] span, .pagination-wrapper .disabled span { 
        color: #94a3b8; 
        background: #f1f5f9; 
        cursor: not-allowed; 
    }
    /* Esconde blocos repetidos de texto explicativo se houver */
    .pagination-wrapper nav div:first-child { display: none !important; }
    .pagination-wrapper nav div:last-child { display: flex !important; }
</style>
@endsection

@section('content')
<section id="historico-global" style="padding: 1.5rem; background-color: #f8fafc;">
    <div class="dash-top" style="margin-bottom: 2rem;">
        <h2 style="color: #1e293b; font-weight: 700; margin-bottom: 0.25rem;">Histórico e Auditoria Geral</h2>
        <p style="color: #64748b; font-size: 0.95rem;">Acompanhe tanto a telemetria das máquinas quanto a atividade dos usuários na plataforma.</p>
    </div>

    <div class="tcard" style="background: #ffffff; border-radius: 16px; padding: 1.5rem; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); margin-bottom: 2.5rem;">
        <h3 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 1rem;">Leituras dos Sensores (Arduino)</h3>
        <div class="t-scroll">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 2px solid #f1f5f9; color: #64748b; font-size: 0.85rem; text-transform: uppercase;">
                        <th style="padding: 1rem 0.5rem;">ID</th>
                        <th style="padding: 1rem 0.5rem;">Data / Hora</th>
                        <th style="padding: 1rem 0.5rem;">Umidade</th>
                        <th style="padding: 1rem 0.5rem;">Temperatura</th>
                        <th style="padding: 1rem 0.5rem;">pH</th>
                        <th style="padding: 1rem 0.5rem;">Gás</th>
                        <th style="padding: 1rem 0.5rem;">Peso</th>
                    </tr>
                </thead>
                <tbody style="color: #334155; font-size: 0.95rem;">
                    @forelse($historicos as $leitura)
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 1rem 0.5rem; font-weight: 600; color: #64748b;">#{{ $leitura->id }}</td>
                            <td style="padding: 1rem 0.5rem;">{{ $leitura->created_at ? $leitura->created_at->format('d/m/Y H:i:s') : '---' }}</td>
                            <td style="padding: 1rem 0.5rem; font-weight: 600; color: #0284c7;">{{ number_format($leitura->umidade ?? 0, 0) }}%</td>
                            <td style="padding: 1rem 0.5rem; font-weight: 600; color: #ea580c;">{{ number_format($leitura->temperatura ?? 0, 1) }}°C</td>
                            <td style="padding: 1rem 0.5rem;">
                                @php
                                    $ph = $leitura->ph ?? 7.0;
                                    $classPh = $ph < 6.0 ? 'ph-acido' : ($ph > 8.0 ? 'ph-alcalino' : 'ph-neutro');
                                @endphp
                                <span class="badge-ph {{ $classPh }}">{{ number_format($ph, 1) }}</span>
                            </td>
                            <td style="padding: 1rem 0.5rem;">{{ number_format($leitura->gas ?? 0, 0, ',', '.') }} ppm</td>
                            <td style="padding: 1rem 0.5rem; font-weight: 600; color: #16a34a;">{{ number_format($leitura->peso ?? 0, 2, ',', '.') }} kg</td>
                        </tr>
                    @empty
                        <tr><td colspan="7" style="padding: 2rem; text-align: center; color: #94a3b8;">Nenhuma leitura encontrada.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($historicos->hasPages())
            <div class="pagination-wrapper">{{ $historicos->appends(request()->except('page_arduino'))->links() }}</div>
        @endif
    </div>

    <div class="tcard" style="background: #ffffff; border-radius: 16px; padding: 1.5rem; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
        <h3 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 1rem;">Logs de Atividade dos Usuários</h3>
        <div class="t-scroll">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 2px solid #f1f5f9; color: #64748b; font-size: 0.85rem; text-transform: uppercase;">
                        <th style="padding: 1rem 0.5rem;">Data / Hora</th>
                        <th style="padding: 1rem 0.5rem;">Usuário</th>
                        <th style="padding: 1rem 0.5rem;">Ação</th>
                        <th style="padding: 1rem 0.5rem;">Descrição</th>
                        <th style="padding: 1rem 0.5rem;">Endereço IP</th>
                    </tr>
                </thead>
                <tbody style="color: #334155; font-size: 0.95rem;">
                    @forelse($logs as $log)
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 1rem 0.5rem; color: #64748b;">{{ $log->created_at ? $log->created_at->format('d/m/Y H:i:s') : '---' }}</td>
                            <td style="padding: 1rem 0.5rem; font-weight: 600;">{{ $log->user->nome ?? 'Sistema / Visitante' }}</td>
                            <td style="padding: 1rem 0.5rem;">
                                @php
                                    $act = strtolower($log->acao);
                                    $classAct = str_contains($act, 'login') ? 'act-login' : (str_contains($act, 'deletar') || str_contains($act, 'excluir') ? 'act-danger' : (str_contains($act, 'update') || str_contains($act, 'editar') ? 'act-update' : 'act-default'));
                                @endphp
                                <span class="badge-action {{ $classAct }}">{{ $log->acao }}</span>
                            </td>
                            <td style="padding: 1rem 0.5rem; color: #475569;">{{ $log->descricao }}</td>
                            <td style="padding: 1rem 0.5rem; font-family: monospace; color: #64748b;">{{ $log->ip_address ?? '---' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" style="padding: 2rem; text-align: center; color: #94a3b8;">Nenhuma atividade registrada ainda.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($logs->hasPages())
            <div class="pagination-wrapper">{{ $logs->appends(request()->except('page_logs'))->links() }}</div>
        @endif
    </div>
</section>
@endsection