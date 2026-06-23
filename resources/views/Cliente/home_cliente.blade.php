@extends('Cliente.layout_cliente')
@section('title', 'Monitoramento Real-Time - EcoCycle')

@section('styles')
<style>
    /* Garante que o cálculo de tamanhos inclua paddings sem estourar limites */
    *, ::after, ::before {
        box-sizing: border-box;
    }

    .chart-wrapper {
        position: relative;
        width: 100%;
        height: 300px; /* Altura padrão bem definida para o Chart.js respirar */
    }
    
    @media (max-width: 768px) {
        .dashboard-hero {
            gap: 0.85rem !important;
        }
        .dash-top {
            margin-bottom: 1rem !important;
        }
        .chart-container {
            padding: 1rem !important;
            margin-bottom: 1.5rem;
        }
        /* Força o empilhamento correto e evita o esmagamento lateral */
        .metrics-grid {
            grid-template-columns: 1fr !important;
            gap: 1rem !important;
            width: 100% !important;
        }
        .metrics-grid > article,
        .charts-responsive-grid > article,
        .project-item {
            min-width: 0 !important;
            width: 100% !important;
        }
        .projects-container {
            gap: 1.2rem !important;
            width: 100% !important;
            padding: 0 !important;
        }
        .charts-responsive-grid {
            grid-template-columns: 1fr !important;
            gap: 1rem !important;
            width: 100% !important;
        }
        .chart-container,
        .ccard {
            width: 100% !important;
            min-width: 0 !important;
            padding: 1rem !important;
        }
        .metric-card .metric-value {
            font-size: 1.8rem !important;
        }
        .indicator-grid {
            grid-template-columns: 1fr !important;
            gap: 0.75rem !important;
        }
        .indicator-card {
            padding: 0.85rem !important;
        }
        .indicator-card strong {
            font-size: 1.35rem !important;
        }
        /* Reduz ligeiramente a altura no mobile para evitar cortes verticais */
        .chart-wrapper {
            height: 200px;
        }
        .full-chart-card {
            min-height: 0 !important;
        }
        .full-chart-card canvas {
            height: 220px !important;
            max-height: 220px !important;
        }
        /* Remove paddings excessivos do card nativo que empurram o gráfico para fora */
        .ccard {
            padding: 1rem !important;
        }
    }
</style>
@endsection

@section('content')
<section id="dashboard" class="dashboard-hero" style="max-width: 100%; width: 100%; padding: 1.5rem; background-color: #f8fafc; overflow-x: hidden; box-sizing: border-box;">
    <div class="dash-top">
        <div>
            <h2>Painel do Cliente</h2>
            <p>Acompanhe a saúde da sua compostagem e o desempenho dos sensores em tempo real.</p>
        </div>
        <span class="live-pill"><span class="live-dot"></span>Atualização automática a cada segundo</span>
    </div>

    <div class="metrics-grid" style="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; width: 100%;">
        <article class="metric-card">
            <div class="metric-label">Umidade do Solo</div>
            <div class="metric-value" id="val-umidade">--</div>
            <p>Status: <strong id="status-text" style="color: var(--secondary-color);">Aguardando leitura</strong></p>
        </article>
        <article class="metric-card">
            <div class="metric-label">Temperatura</div>
            <div class="metric-value" id="val-temperatura">--</div>
            <p>Sensor de processo em tempo real</p>
        </article>
        <article class="metric-card profit-card">
            <div class="metric-label">Peso / Estoque</div>
            <div class="metric-value" id="val-peso">--</div>
            <p>Monitoramento do material orgânico</p>
        </article>
    </div>

    <div class="projects-container" id="graficos" style="display: flex; flex-direction: column; gap: 1.5rem; width: 100%;">
        
        <article class="project-item full-width-card" style="width: 100%;">
            <div class="ccard" style="display: flex; flex-direction: column; padding: 1.5rem; background: #fff; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.02); width: 100%;">
                <span class="tag" style="align-self: flex-start; margin-bottom: 0.5rem;">Umidade em tempo real</span>
                <h3 style="margin-bottom: 0.25rem;">Variação da umidade do solo</h3>
                <p id="deviceWarning" class="device-warning" style="color: #e74c3c; font-size: 0.9rem; margin-bottom: 1rem;">Nenhum dispositivo Arduino encontrado no banco. Conecte um sensor para ver a leitura em tempo real.</p>
                <div class="chart-wrapper">
                    <canvas id="liveHumidityChart"></canvas>
                </div>
            </div>
        </article>

        <div class="charts-responsive-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.5rem; width: 100%;">
            
            <article class="project-item">
                <div class="chart-container full-chart-card" style="min-height: 340px; display: flex; flex-direction: column; justify-content: center; width: 100%;">
                    <span class="tag">Indicadores</span>
                    <h3>pH, Gás e Peso</h3>
                    <div class="indicator-grid" style="margin-top: 1rem;">
                        <div class="indicator-card"><span class="indicator-label">pH</span><strong id="info-ph">--</strong><small>Neutralidade do composto</small><div class="indicator-bar"><i id="bar-ph"></i></div></div>
                        <div class="indicator-card"><span class="indicator-label">Gás</span><strong id="info-gas">--</strong><small>Concentração detectada</small><div class="indicator-bar"><i id="bar-gas"></i></div></div>
                        <div class="indicator-card"><span class="indicator-label">Peso</span><strong id="info-peso">--</strong><small>Material em processo</small><div class="indicator-bar"><i id="bar-peso"></i></div></div>
                    </div>
                </div>
            </article>

            <article class="project-item">
                <div class="ccard" style="display: flex; flex-direction: column; padding: 1.5rem; background: #fff; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.02); width: 100%;">
                    <span class="tag" style="align-self: flex-start; margin-bottom: 0.5rem;">Temperatura Real</span>
                    <h3 style="margin-bottom: 1rem;">Histórico Térmico do Composto (°C)</h3>
                    <div class="chart-wrapper">
                        <canvas id="liveTemperatureChart"></canvas>
                    </div>
                </div>
            </article>

        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // 1. Captura com segurança o dado inicial enviado pelo Laravel
    const initial = @json($latest ?? null);
    const MAX_PONTOS_GRAFICO = 20; 
    let ultimoIdInserido = null;

    Chart.defaults.set('plugins.legend', {
        labels: { font: { family: "'Inter', sans-serif", size: 12 } }
    });

    // Função auxiliar para validar se o dado inicial é recente (evita o pico de 60% para 0)
    function dataInicialValida(dado) {
        if (!dado || !dado.created_at) return false;
        
        // Compara o horário do registro com o horário atual
        const dataRegistro = new Date(dado.created_at);
        const agora = new Date();
        const diferencaEmSegundos = Math.abs(agora - dataRegistro) / 1000;
        
        // Se o dado guardado no banco tem mais de 15 segundos, ignora para não quebrar o gráfico live
        return diferencaEmSegundos < 15;
    }

    const temDadoRecente = dataInicialValida(initial);
    const horaInicial = new Date().toLocaleTimeString('pt-BR', { hour12: false });

    // 2. Inicialização dos gráficos ajustada
    const liveHumidityChart = new Chart(document.getElementById('liveHumidityChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: temDadoRecente ? [horaInicial] : [],
            datasets: [{
                label: 'Umidade (%)',
                data: temDadoRecente ? [Number(initial.umidade)] : [],
                borderColor: '#296d7e',
                backgroundColor: 'rgba(41, 109, 126, 0.08)',
                tension: 0.35,
                fill: true,
                pointRadius: 3
            }]
        },
        options: { 
            responsive: true,
            maintainAspectRatio: false,
            resizeDelay: 100,
            scales: { 
                y: { beginAtZero: true, min: 0, max: 100, grid: { color: 'rgba(0,0,0,0.03)' } },
                x: { grid: { display: false } }
            } 
        }
    });

    const liveTemperatureChart = new Chart(document.getElementById('liveTemperatureChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: temDadoRecente ? [horaInicial] : [],
            datasets: [{
                label: 'Temperatura (°C)',
                data: temDadoRecente ? [Number(initial.temperatura)] : [],
                borderColor: '#e67e22',
                backgroundColor: 'rgba(230, 126, 34, 0.08)',
                tension: 0.35,
                fill: true,
                pointRadius: 3
            }]
        },
        options: { 
            responsive: true,
            maintainAspectRatio: false,
            resizeDelay: 100,
            scales: { 
                y: { beginAtZero: true, min: 0, max: 80, grid: { color: 'rgba(0,0,0,0.03)' } },
                x: { grid: { display: false } }
            } 
        }
    });

    const deviceWarning = document.getElementById('deviceWarning');

    // 3. Atualização lógica do painel de controle
    function updateDashboard(data) {
        if (!data || Object.keys(data).length === 0) {
            deviceWarning.style.display = 'block';
            document.getElementById('val-umidade').textContent = '0%';
            document.getElementById('val-temperatura').textContent = '0°C';
            document.getElementById('val-peso').textContent = '0 kg';
            document.getElementById('status-text').textContent = 'Dispositivo não encontrado';
            return;
        }

        const umidade = Number(data?.umidade ?? 0);
        const temperatura = Number(data?.temperatura ?? 0);
        const peso = Number(data?.peso ?? 0);
        const ph = Number(data?.ph ?? 0);
        const gas = Number(data?.gas ?? 0);

        deviceWarning.style.display = 'none';

        document.getElementById('val-umidade').textContent = `${umidade.toFixed(0)}%`;
        document.getElementById('val-temperatura').textContent = `${temperatura.toFixed(1)}°C`;
        document.getElementById('val-peso').textContent = `${peso.toFixed(1)} kg`;
        document.getElementById('status-text').textContent = (data?.status_contaminacao || 'nao_analisado').replace(/_/g, ' ');

        document.getElementById('info-ph').textContent = ph.toFixed(1);
        document.getElementById('info-gas').textContent = `${gas.toFixed(0)} ppm`;
        document.getElementById('info-peso').textContent = `${peso.toFixed(1)} kg`;
        document.getElementById('bar-ph').style.style.width = `${Math.min(100, Math.max(8, ph * 10))}%`;
        document.getElementById('bar-gas').style.style.width = `${Math.min(100, gas / 2.5)}%`;
        document.getElementById('bar-peso').style.style.width = `${Math.min(100, peso * 5)}%`;

        if (data.id !== ultimoIdInserido) {
            ultimoIdInserido = data.id;

            const agora = new Date();
            const horaFormatada = agora.toLocaleTimeString('pt-BR', { hour12: false });

            liveHumidityChart.data.labels.push(horaFormatada);
            liveHumidityChart.data.datasets[0].data.push(umidade);

            liveTemperatureChart.data.labels.push(horaFormatada);
            liveTemperatureChart.data.datasets[0].data.push(temperatura);

            if (liveHumidityChart.data.labels.length > MAX_PONTOS_GRAFICO) {
                liveHumidityChart.data.labels.shift();
                liveHumidityChart.data.datasets[0].data.shift();
                
                liveTemperatureChart.data.labels.shift();
                liveTemperatureChart.data.datasets[0].data.shift();
            }

            liveHumidityChart.update();
            liveTemperatureChart.update();
        }
    }

    // Usar caminho relativo direto elimina o risco de problemas com HTTPS/HTTP no Render
    function refreshData() {
        fetch('/api/arduino/latest') 
            .then(r => r.json())
            .then(result => {
                if (result?.data) updateDashboard(result.data);
            })
            .catch(() => {});
    }

    // Executa a carga inicial respeitando a regra de tempo
    if (temDadoRecente) {
        updateDashboard(initial);
    } else {
        updateDashboard({});
    }
    
    setInterval(refreshData, 1000);
</script>
@endsection