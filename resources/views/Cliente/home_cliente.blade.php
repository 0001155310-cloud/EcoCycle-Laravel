@extends('Cliente.layout_cliente')
@section('title', 'Monitoramento Real-Time - EcoCycle')

@section('content')
<section id="dashboard" class="dashboard-hero">
    <div class="dash-top">
        <div>
            <h2>Painel do Cliente</h2>
            <p>Acompanhe a saúde da sua compostagem e o desempenho dos sensores em tempo real.</p>
        </div>
        <span class="live-pill"><span class="live-dot"></span>Atualização automática a cada segundo</span>
    </div>

    <div class="metrics-grid">
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

    <div class="projects-container" id="graficos">
        <article class="project-item full-width-card">
            <div class="chart-container full-chart-card">
                <span class="tag">Umidade em tempo real</span>
                <h3>Variação da umidade do solo (atualização a cada segundo)</h3>
                <p id="deviceWarning" class="device-warning">Nenhum dispositivo Arduino encontrado no banco. Conecte um sensor para ver a leitura em tempo real.</p>
                <canvas id="liveHumidityChart"></canvas>
            </div>
        </article>
        <article class="project-item">
            <div class="chart-container full-chart-card">
                <span class="tag">Indicadores</span>
                <h3>pH, Gás e Peso</h3>
                <div class="indicator-grid">
                    <div class="indicator-card"><span class="indicator-label">pH</span><strong id="info-ph">--</strong><small>Neutralidade do composto</small><div class="indicator-bar"><i id="bar-ph"></i></div></div>
                    <div class="indicator-card"><span class="indicator-label">Gás</span><strong id="info-gas">--</strong><small>Concentração detectada</small><div class="indicator-bar"><i id="bar-gas"></i></div></div>
                    <div class="indicator-card"><span class="indicator-label">Peso</span><strong id="info-peso">--</strong><small>Material em processo</small><div class="indicator-bar"><i id="bar-peso"></i></div></div>
                </div>
            </div>
        </article>
        <article class="project-item">
            <div class="chart-container">
                <span class="tag">Resumo</span>
                <h3>Distribuição da Qualidade do Sistema</h3>
                <canvas id="qualityChart"></canvas>
            </div>
        </article>
        <article class="project-item">
            <div class="chart-container">
                <span class="tag">Eficiência</span>
                <h3>Risco, Eficiência e Estabilidade</h3>
                <canvas id="radarChart"></canvas>
            </div>
        </article>
    </div>
</section>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const initial = @json($latest ?? null);
    const liveHumidityChart = new Chart(document.getElementById('liveHumidityChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: ['00s', '01s', '02s', '03s', '04s'],
            datasets: [{
                label: 'Umidade (%)',
                data: [initial?.umidade ?? 0, initial?.umidade ?? 0, initial?.umidade ?? 0, initial?.umidade ?? 0, initial?.umidade ?? 0],
                borderColor: '#296d7e',
                backgroundColor: 'rgba(24, 206, 100, 0.14)',
                tension: 0.35,
                fill: true,
                pointRadius: 2
            }]
        },
        options: { responsive: true, animation: { duration: 300 }, scales: { y: { beginAtZero: false, suggestedMin: 0, suggestedMax: 100 } } }
    });

    const qualityChart = new Chart(document.getElementById('qualityChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Ideal', 'Atenção', 'Risco', 'Sem análise'],
            datasets: [{
                data: [0, 0, 0, 100],
                backgroundColor: ['#27ae60', '#1e5d3b', '#f1c40f', '#ccc'],
                borderWidth: 0.5,
                borderColor: '#fff'
            }]
        },
        options: { responsive: true, cutout: '67%' }
    });

    const radarChart = new Chart(document.getElementById('radarChart').getContext('2d'), {
        type: 'radar',
        data: {
            labels: ['Umidade', 'Temperatura', 'Estabilidade', 'Eficiência', 'Qualidade'],
            datasets: [{
                label: 'Performance',
                data: [0, 0, 0, 0, 0],
                backgroundColor: 'rgba(39, 174, 96, 0.16)',
                borderColor: '#1e5d3b',
                pointBackgroundColor: '#27ae60'
            }]
        },
        options: { responsive: true, scales: { r: { suggestedMin: 0, suggestedMax: 100 } } }
    });

    const deviceWarning = document.getElementById('deviceWarning');

    function updateDashboard(data) {
        const umidade = Number(data?.umidade ?? 0);
        const temperatura = Number(data?.temperatura ?? 0);
        const peso = Number(data?.peso ?? 0);
        const ph = Number(data?.ph ?? 0);
        const gas = Number(data?.gas ?? 0);

        if (!data || Object.keys(data).length === 0) {
            deviceWarning.style.display = 'block';
            document.getElementById('val-umidade').textContent = '0%';
            document.getElementById('val-temperatura').textContent = '0°C';
            document.getElementById('val-peso').textContent = '0 kg';
            document.getElementById('status-text').textContent = 'Dispositivo não encontrado';
            return;
        }

        deviceWarning.style.display = 'none';

        document.getElementById('val-umidade').textContent = `${umidade.toFixed(0)}%`;
        document.getElementById('val-temperatura').textContent = `${temperatura.toFixed(1)}°C`;
        document.getElementById('val-peso').textContent = `${peso.toFixed(1)} kg`;
        document.getElementById('status-text').textContent = (data?.status_contaminacao || 'nao_analisado').replace(/_/g, ' ');

        document.getElementById('info-ph').textContent = ph.toFixed(1);
        document.getElementById('info-gas').textContent = `${gas.toFixed(0)} ppm`;
        document.getElementById('info-peso').textContent = `${peso.toFixed(1)} kg`;
        document.getElementById('bar-ph').style.width = `${Math.min(100, Math.max(8, ph * 10))}%`;
        document.getElementById('bar-gas').style.width = `${Math.min(100, gas / 2.5)}%`;
        document.getElementById('bar-peso').style.width = `${Math.min(100, peso * 5)}%`;

        const liveValues = liveHumidityChart.data.datasets[0].data;
        liveValues.shift();
        liveValues.push(Number.isFinite(umidade) ? umidade : 0);
        liveHumidityChart.data.labels = liveHumidityChart.data.labels.map((_, index) => `${index}s`);
        liveHumidityChart.update();

        qualityChart.data.datasets[0].data = [Math.max(10, 100 - umidade / 2), Math.max(5, umidade / 3), Math.max(2, 10 + (gas / 60))];
        qualityChart.update();
    }

    function refreshData() {
        fetch('{{ route('arduino.latest') }}')
            .then(r => r.json())
            .then(result => {
                if (result?.data) updateDashboard(result.data);
            })
            .catch(() => {});
    }

    updateDashboard(initial || {});
    setInterval(refreshData, 1000);
</script>
@endsection