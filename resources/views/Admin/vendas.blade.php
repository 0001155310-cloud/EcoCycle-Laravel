@extends('Admin.layout_admin')

@section('title', 'Monitoramento de vendas - EcoCycle')

@section('content')
<section class="dashboard-hero">
    <div class="dash-top">
        <div>
            <h2>Monitoramento de vendas</h2>
            <p>Resumo rápido da performance comercial e acompanhamento das vendas.</p>
        </div>
        <span class="live-pill">Vendas</span>
    </div>

    <div class="metrics-grid">
        <article class="metric-card"><div class="metric-label">Leituras no banco</div><div class="metric-value">{{ $leituras }}</div><p>Registros capturados do sensor.</p></article>
        <article class="metric-card profit-card"><div class="metric-label">Clientes cadastrados</div><div class="metric-value">{{ $clientes }}</div><p>Perfis ativos no sistema.</p></article>
        <article class="metric-card"><div class="metric-label">Status atual</div><div class="metric-value">{{ strtoupper($latest->status_contaminacao ?? 'NAO_ANALISADO') }}</div><p>Última leitura registrada.</p></article>
    </div>

    <div class="projects-container">
        <article class="project-item"><div class="chart-container"><span class="tag">Indicador</span><h3>Umidade x temperatura</h3><canvas id="salesChart"></canvas></div></article>
        <article class="project-item"><div class="chart-container"><span class="tag">Resumo</span><h3>Distribuição de leitura</h3><canvas id="salesPie"></canvas></div></article>
    </div>

    <div class="tcard">
        <div class="tcard-head"><h3>Últimas vendas</h3></div>
        <div class="t-scroll">
            <table>
                <thead><tr><th>Pedido</th><th>Cliente</th><th>Status</th><th>Valor</th></tr></thead>
                <tbody>
                    <tr><td>VD-001</td><td>Cliente Exemplo</td><td><span class="bs bs-aprovado">Concluída</span></td><td>R$ 320</td></tr>
                    <tr><td>VD-002</td><td>Cliente Exemplo 2</td><td><span class="bs bs-inspecao">Pendente</span></td><td>R$ 180</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const latest = @json($latest ?? null);
    const salesChart = new Chart(document.getElementById('salesChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: ['Umidade', 'Temperatura'],
            datasets: [{ label: 'Leitura atual', data: [Number(latest?.umidade ?? 0), Number(latest?.temperatura ?? 0)], borderColor: '#27ae60', backgroundColor: 'rgba(39,174,96,0.12)', fill: true, tension: 0.35 }]
        },
        options: { responsive: true }
    });
    new Chart(document.getElementById('salesPie').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Ideal', 'Atenção', 'Risco'],
            datasets: [{ data: [
                Math.max(10, 100 - (Number(latest?.umidade ?? 0) / 2)),
                Math.max(5, (Number(latest?.umidade ?? 0) / 3)),
                Math.max(2, 10 + ((Number(latest?.gas ?? 0) / 60)))
            ], backgroundColor: ['#27ae60', '#1e5d3b', '#f1c40f'] }]
        },
        options: { responsive: true, cutout: '65%' }
    });
</script>
@endsection
