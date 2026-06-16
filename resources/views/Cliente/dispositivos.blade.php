@extends('Cliente.layout_cliente')

@section('title', 'Dados dos dispositivos - EcoCycle')

@section('styles')
<style>
    .chart-container {
        position: relative;
    }
    
    .chart-container canvas {
        max-width: 100%;
    }
    
    @media (max-width: 768px) {
        .chart-container {
            padding: 1rem !important;
        }
        .projects-container {
            gap: 1rem !important;
        }
        .metric-card .metric-value {
            font-size: 1.8rem !important;
        }
    }
</style>
@endsection

@section('content')
<section class="dashboard-hero">
    <div class="dash-top">
        <div>
            <h2>Dados dos dispositivos</h2>
            <p>Selecione o aparelho conectado e acompanhe a leitura real do banco de dados.</p>
        </div>
        <label style="display:grid; gap:0.35rem; min-width:280px;">
            <span style="font-size:0.8rem; color:var(--muted); font-weight:700; text-transform:uppercase; letter-spacing:0.08em;">Dispositivo conectado</span>
            <select id="deviceSelect" style="padding:0.72rem 0.85rem; border-radius:12px; border:1px solid #d8e6e4; background:#fff;">
                @foreach($devices as $device)
                    <option value="{{ $device }}">{{ $device }}</option>
                @endforeach
            </select>
        </label>
    </div>

    <div class="metrics-grid">
        <article class="metric-card">
            <div class="metric-label">Leitura atual</div>
            <div class="metric-value" id="live-reading">--</div>
            <p>Valor extraído da base em tempo real.</p>
        </article>
        <article class="metric-card profit-card">
            <div class="metric-label">Variação</div>
            <div class="metric-value" id="live-variation">--</div>
            <p>Amplitude da leitura selecionada.</p>
        </article>
        <article class="metric-card">
            <div class="metric-label">Status</div>
            <div class="metric-value" id="live-status">--</div>
            <p>Classificação da leitura mais recente.</p>
        </article>
    </div>

    <div class="projects-container">
        <article class="project-item">
            <div class="chart-container">
                <span class="tag">Resumo</span>
                <h3>Gráfico principal</h3>
                <canvas id="mainChart"></canvas>
            </div>
        </article>
        <article class="project-item">
            <div class="chart-container">
                <span class="tag">Comparativo</span>
                <h3>Distribuição do indicador</h3>
                <canvas id="miniChart"></canvas>
            </div>
        </article>
    </div>
</section>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const devices = @json($devices ?? []);
    const deviceData = @json($deviceData ?? []);
    const deviceSelect = document.getElementById('deviceSelect');
    const initial = deviceData[deviceSelect.value] ?? null;
    const mainChart = new Chart(document.getElementById('mainChart').getContext('2d'), {
        type: 'line',
        data: { 
            labels: ['Atual', 'Prévia', 'Meta'], 
            datasets: [{ 
                label: 'Indicador', 
                data: [0, 0, 0], 
                borderColor: '#27ae60', 
                backgroundColor: 'rgba(39,174,96,0.12)', 
                tension: 0.35, 
                fill: true,
                pointRadius: window.innerWidth < 768 ? 1 : 2
            }] 
        },
        options: { 
            responsive: true,
            maintainAspectRatio: true,
            animation: { duration: 300 },
            plugins: {
                legend: {
                    labels: { font: { size: window.innerWidth < 768 ? 11 : 12 } }
                }
            },
            scales: { 
                x: { ticks: { font: { size: window.innerWidth < 768 ? 10 : 11 } } },
                y: { ticks: { font: { size: window.innerWidth < 768 ? 10 : 11 } } }
            }
        }
    });
    const miniChart = new Chart(document.getElementById('miniChart').getContext('2d'), {
        type: 'doughnut',
        data: { 
            labels: ['Ideal', 'Atenção', 'Risco'], 
            datasets: [{ 
                data: [50, 30, 20], 
                backgroundColor: ['#27ae60', '#ffd000', '#f10f0f'], 
                borderWidth: 0 
            }] 
        },
        options: { 
            responsive: true,
            maintainAspectRatio: true,
            cutout: '68%',
            plugins: {
                legend: {
                    labels: { font: { size: window.innerWidth < 768 ? 11 : 12 } },
                    position: window.innerWidth < 768 ? 'bottom' : 'right'
                }
            }
        }
    });

    function updateDashboard(data) {
        const umidade = Number(data?.umidade ?? 0);
        const temperatura = Number(data?.temperatura ?? 0);
        const ph = Number(data?.ph ?? 0);
        const gas = Number(data?.gas ?? 0);
        const status = String(data?.status_contaminacao || 'nao_analisado').replace(/_/g, ' ');

        document.getElementById('live-reading').textContent = `${deviceSelect.value}`;
        document.getElementById('live-variation').textContent = `${umidade.toFixed(0)}% · ${temperatura.toFixed(1)}°C`;
        document.getElementById('live-status').textContent = status;

        mainChart.data.datasets[0].label = deviceSelect.value;
        mainChart.data.datasets[0].data = [Math.max(0, umidade - 5), umidade, Math.min(100, umidade + 8)];
        mainChart.update();

        miniChart.data.datasets[0].data = [Math.max(10, 100 - umidade / 2), Math.max(5, umidade / 4), Math.max(2, 10 + gas / 30)];
        miniChart.update();
    }

    function refreshDashboard() {
        const selected = deviceSelect.value;
        fetch('{{ route('arduino.latest') }}?device=' + encodeURIComponent(selected))
            .then(r => r.json())
            .then(result => { if (result?.data) updateDashboard(result.data); })
            .catch(() => {});
    }

    deviceSelect.addEventListener('change', () => updateDashboard(deviceData[deviceSelect.value] || null));
    updateDashboard(initial || null);
    setInterval(refreshDashboard, 2000);
</script>
@endsection
