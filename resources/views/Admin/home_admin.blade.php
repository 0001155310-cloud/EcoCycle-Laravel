@extends('Admin.layout_admin')
@section('title', 'Monitoramento Real-Time - EcoCycle')

@section('styles')
<style>
    /* Grid de Métricas Rápidas */
    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
        margin-bottom: 3rem;
    }

    .metric-card {
        background: var(--white);
        padding: 2.5rem 2rem;
        border-radius: 20px;
        box-shadow: var(--shadow);
        text-align: center;
        border-bottom: 5px solid var(--accent-color);
        transition: var(--transition);
    }

    .metric-card:hover { transform: translateY(-5px); }

    .metric-value {
        font-size: 3rem;
        font-weight: 800;
        color: var(--primary-color);
        margin: 1rem 0;
    }

    .metric-label {
        font-weight: 700;
        text-transform: uppercase;
        color: var(--text-muted);
        letter-spacing: 1px;
    }

    /* Estilo para o Card de Lucro (Destaque) */
    .profit-card {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        color: white;
        border-bottom: 5px solid #f1c40f; /* Cor de "ouro" para lucro */
    }

    .profit-card .metric-value, .profit-card .metric-label { color: white; }

    /* Ajuste para os gráficos ocuparem o container de projetos */
    .chart-container {
        padding: 2rem;
        width: 100%;
        background: var(--white);
        border-radius: 24px;
    }
</style>
@endsection

@section('content')
<section id="dashboard">
    <div class="intro-text">
        <h2>Painel de Controle Arduino</h2>
        <p>Acompanhe a saúde da sua compostagem e a economia gerada em tempo real.</p>
    </div>

    <div class="metrics-grid">
        <div class="metric-card">
            <span class="tag">Vendas</span>
            <div class="metric-label">Produtos Vendidos</div>
            <div class="metric-value" id="val-vendas">1200</div>
            <p>Status: <strong style="color: var(--secondary-color);">Bastante</strong></p>
        </div>

        <div class="metric-card">
            <span class="tag">Processo</span>
            <div class="metric-label">Empresários Demitidos</div>
            <div class="metric-value">14</div>
            <p>Previsão para amanhã: 9 desempregados</p>
        </div>

        <div class="metric-card profit-card">
            <span class="tag" style="background: rgba(255,255,255,0.2); color: white;">Financeiro</span>
            <div class="metric-label">Possível Lucro</div>
            <div class="metric-value">R$ MUITO DINHEIRO</div>
            <p>Economia em fertilizantes orgânicos</p>
        </div>
    </div>

    <div class="projects-container">
        <div class="project-item">
            <div class="chart-container">
                <span class="tag">Histórico Semanal</span>
                <h3>Níveis de Umidade</h3>
                <canvas id="humidityChart"></canvas>
            </div>
        </div>

        <div class="project-item">
            <div class="chart-container">
                <span class="tag">Projeção</span>
                <h3>Valor de Mercado do Adubo Produzido</h3>
                <canvas id="profitChart"></canvas>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gráfico de Umidade (Linha)
    const ctxHum = document.getElementById('humidityChart').getContext('2d');
    new Chart(ctxHum, {
        type: 'line',
        data: {
            labels: ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab', 'Dom'],
            datasets: [{
                label: 'Umidade %',
                data: [60, 58, 65, 70, 68, 62, 65],
                borderColor: '#27ae60',
                tension: 0.3,
                fill: true,
                backgroundColor: 'rgba(39, 174, 96, 0.1)'
            }]
        },
        options: { responsive: true }
    });

    // Gráfico de Lucro (Barra)
    const ctxProfit = document.getElementById('profitChart').getContext('2d');
    new Chart(ctxProfit, {
        type: 'bar',
        data: {
            labels: ['Semana 1', 'Semana 2', 'Semana 3', 'Semana 4'],
            datasets: [{
                label: 'Lucro Estimado (R$)',
                data: [80, 150, 240, 342],
                backgroundColor: '#1e5d3b'
            }]
        },
        options: { responsive: true }
    });
</script>
@endsection