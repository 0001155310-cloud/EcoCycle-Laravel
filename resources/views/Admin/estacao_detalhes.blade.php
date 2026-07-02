@extends('Admin.layout_admin')
@section('title', 'Informações Detalhadas da Estação - EcoCycle')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<section style="padding: 1.5rem; background-color: #f8fafc; min-height: 100vh; font-family: system-ui, -apple-system, sans-serif;">
    
    @if(session('success'))
        <div style="padding: 1rem; background-color: #dcfce7; border: 1px solid #bbf7d0; color: #15803d; border-radius: 12px; margin-bottom: 1.5rem; font-weight: 600; font-size: 0.95rem;">
            {{ session('success') }}
        </div>
    @endif

    <div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="color: #1e293b; font-weight: 700; margin-bottom: 0.25rem;">Especificações Técnicas e Relatórios</h2>
            <p style="color: #64748b; font-size: 0.95rem;">Análise de infraestrutura, calibragem e logs operacionais da estação.</p>
        </div>
        <a href="{{ route('admin.home') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; background: #ffffff; border: 1px solid #e2e8f0; color: #475569; font-weight: 600; font-size: 0.85rem; padding: 8px 16px; border-radius: 8px; text-decoration: none; box-shadow: 0 1px 2px rgba(0,0,0,0.05); transition: background 0.2s;">
            Voltar ao Painel
        </a>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <div style="background: #ffffff; padding: 1.25rem; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <span style="color: #64748b; font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">Média de Peças / Min</span>
            <h4 style="font-size: 1.75rem; font-weight: 800; color: #1e293b; margin: 0.25rem 0 0 0;">{{ $estacao->pecas_por_minuto ?? '42' }} <span style="font-size: 0.9rem; color: #94a3b8; font-weight: 500;">und</span></h4>
        </div>
        <div style="background: #ffffff; padding: 1.25rem; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <span style="color: #64748b; font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">Eficiência Geral OEE</span>
            <h4 style="font-size: 1.75rem; font-weight: 800; color: #10b981; margin: 0.25rem 0 0 0;">{{ $estacao->eficiencia ?? '94.2' }}%</h4>
        </div>
        <div style="background: #ffffff; padding: 1.25rem; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <span style="color: #64748b; font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">Consumo Atual do Motor</span>
            <h4 style="font-size: 1.75rem; font-weight: 800; color: #3b82f6; margin: 0.25rem 0 0 0;">{{ $estacao->consumo_watts ?? '280' }} <span style="font-size: 0.9rem; color: #94a3b8; font-weight: 500;">Watts</span></h4>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;" id="main-layout">
        
        <div style="display: flex; flex-direction: column; gap: 2rem;">
            
            <div style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 1.5rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem;">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div style="background: #e0f2fe; padding: 8px; border-radius: 8px; color: #0284c7;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                        </div>
                        <h3 style="font-size: 1.25rem; font-weight: 700; color: #1e293b; margin: 0;">Histórico Operacional das Últimas Horas</h3>
                    </div>
                    <span style="font-size: 0.75rem; background: #f1f5f9; color: #475569; padding: 4px 8px; border-radius: 6px; font-weight: 600;">Atualiza a cada 5s</span>
                </div>
                <div style="width: 100%; height: 300px; position: relative;">
                    <canvas id="telemetriaChart"></canvas>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem;">
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1rem; display: flex; align-items: center; gap: 0.75rem;">
                    <div style="background: #f0fdf4; color: #16a34a; padding: 8px; border-radius: 8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    </div>
                    <div>
                        <span style="display: block; font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase;">Tempo Ativo (Uptime)</span>
                        <strong style="font-size: 1.1rem; color: #1e293b;">{{ $estacao->uptime ?? '14d 6h 32m' }}</strong>
                    </div>
                </div>

                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1rem; display: flex; align-items: center; gap: 0.75rem;">
                    <div style="background: #eff6ff; color: #2563eb; padding: 8px; border-radius: 8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12.55a11 11 0 0 1 14.08 0"></path><path d="M1.42 9a16 16 0 0 1 21.16 0"></path><path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path><line x1="12" y1="20" x2="12.01" y2="20"></line></svg>
                    </div>
                    <div>
                        <span style="display: block; font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase;">Sinal RSSI (Hardware)</span>
                        <strong style="font-size: 1.1rem; color: #2563eb;">{{ $estacao->sinal_rssi ?? '-62 dBm' }} <span style="font-size: 0.75rem; color: #16a34a;">(Excelente)</span></strong>
                    </div>
                </div>

                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1rem; display: flex; align-items: center; gap: 0.75rem;">
                    <div style="background: #faf5ff; color: #7c3aed; padding: 8px; border-radius: 8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22" x2="12" y2="12"></line></svg>
                    </div>
                    <div>
                        <span style="display: block; font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase;">Volume Total Reciclado</span>
                        <strong style="font-size: 1.1rem; color: #1e293b;">{{ $estacao->volume_total ?? '1.240' }} <span style="font-size: 0.8rem; color: #64748b; font-weight: 500;">kg</span></strong>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.estacao.update-limites', $estacao->id ?? 1) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 1.5rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.25rem;">
                        <div style="background: #fef3c7; padding: 8px; border-radius: 8px; color: #d97706;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>
                        </div>
                        <h3 style="font-size: 1.25rem; font-weight: 700; color: #1e293b; margin: 0;">Seção 2: Parametrização e Limites de Calibragem</h3>
                    </div>
                    
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
                            <thead>
                                <tr style="border-bottom: 2px solid #e2e8f0; color: #475569;">
                                    <th style="padding: 0.75rem 0;">Grandeza</th>
                                    <th style="padding: 0.75rem 0;">Atual</th>
                                    <th style="padding: 0.75rem 0; width: 140px;">Limite Máximo</th>
                                    <th style="padding: 0.75rem 0; text-align: right;">Status</th>
                                </tr>
                            </thead>
                            <tbody style="color: #334155;">
                                <tr>
                                    <td style="padding: 0.75rem 0; font-weight: 600;">Umidade</td>
                                    <td style="padding: 0.75rem 0;"><span style="background: #e6f4ea; color: #137333; padding: 2px 8px; border-radius: 4px;">{{ $estacao->umidade_atual ?? '65' }}%</span></td>
                                    <td style="padding: 0.75rem 0;"><input type="number" name="limite_umidade" value="{{ $estacao->limite_umidade ?? '85' }}" style="width: 60px; padding: 4px; border: 1px solid #cbd5e1; border-radius: 6px; text-align: center;"> %</td>
                                    <td style="padding: 0.75rem 0; text-align: right; color: #16a34a; font-weight: 700;">✓ Estável</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0.75rem 0; font-weight: 600;">Temperatura</td>
                                    <td style="padding: 0.75rem 0;"><span style="background: #fef7e0; color: #b06000; padding: 2px 8px; border-radius: 4px;">{{ $estacao->temperatura_atual ?? '42' }}°C</span></td>
                                    <td style="padding: 0.75rem 0;"><input type="number" name="limite_temperatura" value="{{ $estacao->limite_temperatura ?? '70' }}" style="width: 60px; padding: 4px; border: 1px solid #cbd5e1; border-radius: 6px; text-align: center;"> °C</td>
                                    <td style="padding: 0.75rem 0; text-align: right; color: #16a34a; font-weight: 700;">✓ Estável</td>
                                </tr>
                                @php
                                    $isCritico = ($estacao->gases_atual ?? 520) > ($estacao->limite_gases ?? 450);
                                @endphp
                                <tr style="background-color: {{ $isCritico ? '#fff7ed' : 'transparent' }};">
                                    <td style="padding: 0.75rem 0; font-weight: 600;">Gases Voláteis</td>
                                    <td style="padding: 0.75rem 0;"><span style="background: #fce8e6; color: #c5221f; padding: 2px 8px; border-radius: 4px;">{{ $estacao->gases_atual ?? 520 }} PPM</span></td>
                                    <td style="padding: 0.75rem 0;"><input type="number" name="limite_gases" value="{{ $estacao->limite_gases ?? 450 }}" style="width: 60px; padding: 4px; border: 1px solid #ea580c; border-radius: 6px; text-align: center;"> PPM</td>
                                    <td style="padding: 0.75rem 0; text-align: right; color: #ea580c; font-weight: 700;">{{ $isCritico ? '⚠️ Alerta Enviado' : '✓ Estável' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div style="margin-top: 1rem; display: flex; justify-content: flex-end;">
                        <button type="submit" style="background: #1e293b; color: white; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 600; cursor: pointer;">Salvar Limites</button>
                    </div>
                </div>
            </form>
        </div>

        <div style="display: flex; flex-direction: column; gap: 2rem;">
            
            <div style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 1.5rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                <span style="font-size: 0.75rem; color: #64748b; font-weight: 700; text-transform: uppercase; display: block; margin-bottom: 1rem; text-align: center;">Distribuição de Impurezas</span>
                <div style="display: flex; justify-content: center; margin-bottom: 1rem;">
                    <div style="position: relative; width: 130px; height: 130px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: conic-gradient(#ef4444 0% 3%, #f59e0b 3% 11%, #e2e8f0 11% 100%);">
                        <div style="position: absolute; width: 105px; height: 105px; background: #ffffff; border-radius: 50%; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                            <span style="font-size: 1.75rem; font-weight: 900; color: #ef4444; line-height: 1;">{{ $estacao->contaminacao_atual ?? '3' }}%</span>
                            <span style="font-size: 0.6rem; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Metais</span>
                        </div>
                    </div>
                </div>
                <div style="font-size: 0.75rem; display: flex; flex-direction: column; gap: 4px;">
                    <div style="display: flex; align-items: center; gap: 6px;"><span style="width: 8px; height: 8px; background: #ef4444; border-radius: 50%;"></span> Metais Críticos (3%)</div>
                    <div style="display: flex; align-items: center; gap: 6px;"><span style="width: 8px; height: 8px; background: #f59e0b; border-radius: 50%;"></span> Obstruções Leves (8%)</div>
                </div>
            </div>

            <div style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 1.5rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                <h4 style="font-size: 1rem; font-weight: 700; margin: 0 0 1rem 0; color: #1e293b;">Manutenção Preventiva</h4>
                <div style="margin-bottom: 1rem;">
                    <span style="display: block; font-size: 0.7rem; font-weight: 700; color: #64748b; margin-bottom: 4px;">EMISSOR IR</span>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <div style="flex: 1; height: 6px; background: #e2e8f0; border-radius: 3px;"><div style="width: 92%; height: 100%; background: #3b82f6; border-radius: 3px;"></div></div>
                        <span style="font-size: 0.75rem; font-weight: 700;">92%</span>
                    </div>
                </div>
                <div>
                    <span style="display: block; font-size: 0.7rem; font-weight: 700; color: #64748b; margin-bottom: 4px;">LIMPEZA DA CALHA</span>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <div style="flex: 1; height: 6px; background: #e2e8f0; border-radius: 3px;"><div style="width: 15%; height: 100%; background: #ef4444; border-radius: 3px;"></div></div>
                        <span style="font-size: 0.75rem; font-weight: 700;">15h</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
    const ctx = document.getElementById('telemetriaChart').getContext('2d');
    const telemetriaChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00'],
            datasets: [
                {
                    label: 'Temperatura (°C)',
                    data: [38, 39, 41, 40, 42, 41, @json($estacao->temperatura_atual ?? 42)],
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                },
                {
                    label: 'Gases (PPM / 10)',
                    data: [45, 48, 50, 49, 53, 51, @json(($estacao->gases_atual ?? 520) / 10)],
                    borderColor: '#ef4444',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top', labels: { font: { family: 'system-ui', weight: '600' } } }
            },
            scales: {
                y: { beginAtZero: false, grid: { color: '#f1f5f9' } },
                x: { grid: { display: false } }
            }
        }
    });
</script>

<style>
    @media (max-width: 1024px) {
        div[id="main-layout"] { grid-template-columns: 1fr !important; }
    }
</style>
@endsection