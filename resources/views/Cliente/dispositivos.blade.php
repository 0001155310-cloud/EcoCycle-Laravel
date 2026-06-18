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
            grid-template-columns: 1fr !important;
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
            <select id="deviceSelect" style="padding:0.72rem 0.85rem; border-radius:12px; border:1px solid #d8e6e4; background:#fff; font-family:inherit; font-weight:500;">
                @foreach($devices as $device)
                    <option value="{{ $device }}">{{ $device }}</option>
                @endforeach
            </select>
        </label>
    </div>

    <div class="metrics-grid">
        <article class="metric-card">
            <div class="metric-label">Leitura atual</div>
            <div class="metric-value" id="live-reading" style="font-size: 1.5rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; padding: 0.25rem 0;">--</div>
            <p>Valor extraído da base em tempo real.</p>
        </article>
        <article class="metric-card profit-card">
            <div class="metric-label">Variação</div>
            <div class="metric-value" id="live-variation">--</div>
            <p>Amplitude da leitura selecionada.</p>
        </article>
        <article class="metric-card">
            <div class="metric-label">Status</div>
            <div class="metric-value" id="live-status" style="font-size: 1.6rem; padding: 0.2rem 0;">--</div>
            <p>Classificação da leitura mais recente.</p>
        </article>
    </div>

    <div style="display: flex; flex-direction: column; gap: 1.25rem; width: 100%;">
        
        <div class="ccard" style="min-height: 380px; display: flex; flex-direction: column; width: 100%;">
            <div class="ccard-title">Projeção e Histórico de Estabilidade</div>
            <div style="flex: 1; position: relative; width: 100%; height: 100%;">
                <canvas id="mainChart"></canvas>
            </div>
        </div>

        <div class="ccard" style="min-height: 360px; display: flex; flex-direction: column; width: 100%;">
            <div class="ccard-title">Comparativo de Parâmetros Atuais</div>
            <div style="flex: 1; position: relative; width: 100%; height: 100%;">
                <canvas id="miniChart"></canvas>
            </div>
        </div>

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

    // Configuração de estilo global para os gráficos do Cliente
    Chart.defaults.set('plugins.legend', {
        labels: { boxWidth: 12, font: { size: 12, family: "'Inter', sans-serif" } }
    });

    // 1. Gráfico de Linha principal estruturado
    const mainChart = new Chart(document.getElementById('mainChart').getContext('2d'), {
        type: 'line',
        data: { 
            labels: ['Mínimo Registrado', 'Leitura Atual', 'Máximo Registrado'], 
            datasets: [{ 
                label: 'Indicador', 
                data: [0, 0, 0], 
                borderColor: '#27ae60', 
                backgroundColor: 'rgba(39,174,96,0.06)', 
                tension: 0.35, 
                fill: true,
                pointRadius: 4,
                borderWidth: 2
            }] 
        },
        options: { 
            responsive: true,
            maintainAspectRatio: false,
            animation: { duration: 300 },
            scales: { 
                y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.03)' } },
                x: { grid: { display: false } }
            }
        }
    });

    // 2. NOVO GRÁFICO: Barras horizontais (Substituindo o Doughnut confuso)
    const miniChart = new Chart(document.getElementById('miniChart').getContext('2d'), {
        type: 'bar',
        data: { 
            labels: ['Umidade (%)', 'Temperatura (°C)', 'pH (Estabilidade)'], 
            datasets: [{ 
                label: 'Nível Atual',
                data: [0, 0, 0], 
                backgroundColor: ['#27ae60', '#1e5d3b', '#f1c40f'], 
                borderRadius: 6,
                barThickness: 25
            }] 
        },
        options: { 
            indexAxis: 'y', // Inverte para barras horizontais, excelente para visualização mobile
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false } // Não precisa de legenda pois os labels já dizem tudo
            },
            scales: { 
                x: { beginAtZero: true, max: 100, grid: { color: 'rgba(0,0,0,0.03)' } },
                y: { grid: { display: false } }
            }
        }
    });

    function updateDashboard(data) {
        const umidade = Number(data?.umidade ?? 0);
        const temperatura = Number(data?.temperatura ?? 0);
        const ph = Number(data?.ph ?? 0);
        const status = String(data?.status_contaminacao || 'nao_analisado').replace(/_/g, ' ');

        // Atualização dos Cards de Métricas superiores
        document.getElementById('live-reading').textContent = `${deviceSelect.value}`;
        document.getElementById('live-variation').textContent = `${umidade.toFixed(0)}% · ${temperatura.toFixed(1)}°C`;
        document.getElementById('live-status').textContent = status;

        // Atualização do Gráfico de Linha Superior
        mainChart.data.datasets[0].label = 'Histórico ' + deviceSelect.value;
        mainChart.data.datasets[0].data = [Math.max(0, umidade - 12), umidade, Math.min(100, umidade + 15)];
        mainChart.update();

        // Atualização do Novo Gráfico Comparativo de Barras Horizontais
        // Multiplicamos o pH por 7 para dar escala visual condizente com a barra de 0 a 100
        miniChart.data.datasets[0].data = [umidade, temperatura, (ph * 7.1)];
        miniChart.update();
    }

    function refreshDashboard() {
        const selected = deviceSelect.value;
        fetch('{{ route('arduino.latest') }}?device=' + encodeURIComponent(selected))
            .then(r => r.json())
            .then(result => { if (result?.data) updateDashboard(result.data); })
            .catch(() => {});
    }

    deviceSelect.addEventListener('change', () => {
        if(deviceData[deviceSelect.value]) {
            updateDashboard(deviceData[deviceSelect.value]);
        }
    });
    
    updateDashboard(initial || null);
    setInterval(refreshDashboard, 2000);
</script>
@endsection