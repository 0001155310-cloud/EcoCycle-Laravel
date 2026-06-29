@extends('Admin.layout_admin')

@section('title', 'Monitoramento de Vendas - EcoCycle')

@section('styles')
<style>
    .chart-container {
        position: relative;
        width: 100%;
        height: 300px;
        box-sizing: border-box;
    }
    .t-scroll {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .bs {
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 700;
        display: inline-block;
    }
    .bs-aprovado { background: #dcfce7; color: #15803d; }
    .bs-inspecao { background: #fef9c3; color: #a16207; }
    .bs-cancelado { background: #fee2e2; color: #b91c1c; }
    @media (max-width: 768px) {
        .chart-container {
            height: 240px;
            padding: 0.5rem !important;
        }
        .metrics-grid {
            grid-template-columns: 1fr !important;
            gap: 1rem !important;
        }
        .projects-container {
            grid-template-columns: 1fr !important;
            gap: 1.5rem !important;
        }
        .metric-card .metric-value {
            font-size: 1.8rem !important;
        }
    }
</style>
@endsection

@section('content')
<section class="dashboard-hero" style="padding: 1.5rem; background-color: #f8fafc; width: 100%; box-sizing: border-box;">
    <div class="dash-top" style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="color: #1e293b; font-weight: 700; margin-bottom: 0.25rem;">Monitoramento de Vendas</h2>
            <p style="color: #64748b; font-size: 0.95rem;">Resumo rápido da performance comercial e acompanhamento das vendas.</p>
        </div>
        <span class="live-pill" style="background: #e2e8f0; color: #334155; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">Métricas de Negócio</span>
    </div>

    <div class="metrics-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; width: 100%;">
        <article class="metric-card" style="background: #ffffff; border-radius: 16px; padding: 1.5rem; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
            <div class="metric-label" style="color: #475569; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">Faturamento Total</div>
            <div class="metric-value" style="font-size: 2.2rem; font-weight: 800; color: #0f172a; margin: 0.5rem 0;">R$ {{ number_format($faturamentoTotal ?? 0, 2, ',', '.') }}</div>
            <p style="color: #64748b; font-size: 0.85rem;">Soma de todos os pedidos concluídos.</p>
        </article>

        <article class="metric-card profit-card" style="background: #ffffff; border-radius: 16px; padding: 1.5rem; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
            <div class="metric-label" style="color: #16a34a; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">Clientes Cadastrados</div>
            <div class="metric-value" style="font-size: 2.2rem; font-weight: 800; color: #16a34a; margin: 0.5rem 0;">{{ $clientes ?? 0 }}</div>
            <p style="color: #64748b; font-size: 0.85rem;">Perfis de consumidores ativos no sistema.</p>
        </article>

        <article class="metric-card" style="background: #ffffff; border-radius: 16px; padding: 1.5rem; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
            <div class="metric-label" style="color: #475569; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">Leituras Realizadas</div>
            <div class="metric-value" style="font-size: 2.2rem; font-weight: 800; color: #0f172a; margin: 0.5rem 0;">{{ $leituras ?? 0 }}</div>
            <p style="color: #64748b; font-size: 0.85rem;">Registros de telemetria armazenados.</p>
        </article>
    </div>

    <div class="projects-container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(450px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; width: 100%;">
        <article class="project-item" style="background: #ffffff; padding: 1.5rem; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
            <div class="chart-container">
                <span class="tag" style="color: #0284c7; font-weight: 600;">Monitoramento</span>
                <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem; color: #1e293b;">Últimas Leituras de Sensores</h3>
                <canvas id="salesChart"></canvas>
            </div>
        </article>

        <article class="project-item" style="background: #ffffff; padding: 1.5rem; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
            <div class="chart-container">
                <span class="tag" style="color: #16a34a; font-weight: 600;">Financeiro</span>
                <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem; color: #1e293b;">Valores Ganhos por Mês (Faturamento)</h3>
                <canvas id="earningsBarChart"></canvas>
            </div>
        </article>
    </div>

    <div class="tcard" style="background: #ffffff; border-radius: 16px; padding: 1.5rem; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); width: 100%; box-sizing: border-box;">
        <div class="tcard-head" style="margin-bottom: 1rem;"><h3 style="font-size: 1.1rem; font-weight: 700; color: #1e293b;">Histórico Recente de Vendas</h3></div>
        <div class="t-scroll">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 2px solid #f1f5f9; color: #64748b; font-size: 0.85rem; text-transform: uppercase;">
                        <th style="padding: 0.75rem 0.5rem;">Pedido</th>
                        <th style="padding: 0.75rem 0.5rem;">Cliente</th>
                        <th style="padding: 0.75rem 0.5rem;">Status</th>
                        <th style="padding: 0.75rem 0.5rem;">Valor</th>
                    </tr>
                </thead>
                <tbody style="color: #334155; font-size: 0.95rem;">
                    @forelse($ultimasVendas ?? [] as $venda)
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 0.75rem 0.5rem; font-weight: 600;">#{{ $venda->codigo ?? $venda->id }}</td>
                            <td style="padding: 0.75rem 0.5rem;">{{ $venda->cliente->name ?? 'Cliente Cadastrado' }}</td>
                            <td style="padding: 0.75rem 0.5rem;">
                                <span class="bs {{ $venda->status === 'concluida' ? 'bs-aprovado' : ($venda->status === 'pendente' ? 'bs-inspecao' : 'bs-cancelado') }}">
                                    {{ ucfirst($venda->status ?? 'Concluída') }}
                                </span>
                            </td>
                            <td style="padding: 0.75rem 0.5rem; font-weight: 600;">R$ {{ number_format($venda->valor ?? 0, 2, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="padding: 2rem; text-align: center; color: #94a3b8;">Nenhuma venda localizada no sistema.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const latest = {!! json_encode($latest ?? null) !!};
    const faturamentoMensal = {!! json_encode($faturamentoMensal ?? [0, 0, 0, 0, 0, 0]) !!}; 
    const mesesLabels = {!! json_encode($mesesLabels ?? ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun']) !!};

    const salesChart = new Chart(document.getElementById('salesChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: ['Mínimo', 'Atual', 'Máximo (Ref)'],
            datasets: [
                { 
                    label: 'Umidade (%)', 
                    data: [0, Number(latest?.umidade ?? 0), 100], 
                    borderColor: '#0284c7', 
                    backgroundColor: 'rgba(2, 132, 199, 0.05)', 
                    fill: true, 
                    tension: 0.35
                },
                { 
                    label: 'Temperatura (°C)', 
                    data: [0, Number(latest?.temperatura ?? 0), 80], 
                    borderColor: '#ea580c', 
                    backgroundColor: 'rgba(234, 82, 12, 0.05)', 
                    fill: true, 
                    tension: 0.35
                }
            ]
        },
        options: { 
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.03)' } },
                x: { grid: { display: false } }
            }
        }
    });

    const earningsBarChart = new Chart(document.getElementById('earningsBarChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: mesesLabels,
            datasets: [{
                label: 'Faturamento Mensal (R$)',
                data: faturamentoMensal,
                backgroundColor: '#16a34a',
                borderRadius: 6,
                barThickness: 20
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.03)' },
                    ticks: { callback: value => 'R$ ' + value }
                },
                x: { grid: { display: false } }
            }
        }
    });

    document.addEventListener('DOMContentLoaded', () => {
        const burgerBtn = document.querySelector('.navbar-toggler, .hamburger, [data-toggle="sidebar"], .menu-btn');
        if (burgerBtn) {
            burgerBtn.addEventListener('click', () => {
                setTimeout(() => {
                    salesChart.resize();
                    earningsBarChart.resize();
                }, 250);
            });
        }
    });
</script>
@endsection