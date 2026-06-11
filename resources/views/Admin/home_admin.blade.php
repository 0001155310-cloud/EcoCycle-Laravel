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

        .card.card-animate {
            background: var(--white);
            padding: 1.5rem;
            border-radius: 24px;
            border: 1px solid rgba(46, 204, 113, 0.16);
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        .card.card-animate:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.09);
        }

        .card-body {
            padding: 0;
        }

        .card-body .fw-medium {
            font-weight: 700;
            letter-spacing: 0.5px;
            color: var(--text-muted);
        }

        .card-body .ff-secondary {
            font-family: 'Inter', sans-serif;
        }

        .card-body h2 {
            font-size: 2.4rem;
            margin: 0.8rem 0;
            color: var(--primary-color);
        }

        .card-body p {
            margin: 0;
            color: var(--text-muted);
        }

        .avatar-sm {
            width: 3.5rem;
            height: 3.5rem;
        }

        .avatar-title {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            color: var(--white);
            box-shadow: inset 0 0 0 2px rgba(255,255,255,0.18);
        }

        .avatar-title.bg-primary {
            background: radial-gradient(circle at top left, rgba(30, 93, 59, 0.8), rgba(46, 204, 113, 0.3));
        }

        .avatar-title.bg-warning {
            background: radial-gradient(circle at top left, rgba(46, 204, 113, 0.85), rgba(46, 204, 113, 0.35));
        }

        .avatar-title.bg-success {
            background: radial-gradient(circle at top left, rgba(39, 174, 96, 0.85), rgba(39, 174, 96, 0.35));
        }

        .avatar-title svg {
            stroke: currentColor;
            width: 1.4rem;
            height: 1.4rem;
        }

        .badge {
            font-size: 0.8rem;
            padding: 0.35rem 0.7rem;
            border-radius: 999px;
        }

        .metrics-panel {
            background: #ffffff;
            padding: 2rem;
            border-radius: 28px;
            box-shadow: var(--shadow);
            margin-bottom: 3rem;
            border: 1px solid rgba(46, 204, 113, 0.12);
        }

        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            margin-bottom: 0;
        }

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
<section id="dashboard" class="dashboard-hero">
    <div class="dash-top">
        <div>
            <h2>Painel de Controle Arduino</h2>
            <p>Acompanhe a saúde da sua compostagem e os indicadores do processo em tempo real.</p>
        </div>
        <span class="live-pill"><span class="live-dot"></span>Conexão com a base dos arduinos</span>
    </div>

        <div class="metrics-panel">
            <div class="metrics-grid">
                <div class="card card-animate">
                    <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="fw-medium text-muted mb-0">Umidade</p>
                            <h2 class="mt-4 ff-secondary fw-semibold">
                                <span class="counter-value" id="admin-umidade">--</span>%
                            </h2>
                            <p class="mb-0 text-muted">
                                <span class="badge bg-light text-success mb-0">Tempo real</span>
                                desde o sensor Arduino
                            </p>
                        </div>
                        <div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-primary rounded-circle fs-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="fw-medium text-muted mb-0">Temperatura</p>
                            <h2 class="mt-4 ff-secondary fw-semibold">
                                <span class="counter-value" id="admin-temperatura">--</span>°C
                            </h2>
                            <p class="mb-0 text-muted">
                                <span class="badge bg-light text-warning mb-0">Monitorado</span>
                                pelo sistema de leitura
                            </p>
                        </div>
                        <div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-warning rounded-circle fs-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-down">
                                        <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline>
                                        <polyline points="17 18 23 18 23 12"></polyline>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="fw-medium text-muted mb-0">Status</p>
                            <h2 class="mt-4 ff-secondary fw-semibold" id="admin-status">--</h2>
                            <p class="mb-0 text-muted">
                                <span class="badge bg-light text-success mb-0">Atualizado</span>
                                conforme a leitura mais recente
                            </p>
                        </div>
                        <div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-success rounded-circle fs-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign">
                                        <circle cx="12" cy="12" r="8"></circle>
                                        <line x1="12" y1="6" x2="12" y2="18"></line>
                                        <path d="M16 8a4 4 0 0 0-4-4 4 4 0 0 0-4 4 4 4 0 0 0 4 4h4"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <div class="projects-container">
            <div class="project-item">
                <div class="chart-container">
                    <span class="tag">Leitura Arduino</span>
                    <h3>Umidade e temperatura</h3>
                    <canvas id="humidityChart"></canvas>
                </div>
            </div>

            <div class="project-item">
                <div class="chart-container">
                    <span class="tag">Indicadores</span>
                    <h3>pH, gás e peso do material</h3>
                    <canvas id="profitChart"></canvas>
                </div>
            </div>
            <div class="project-item">
                <div class="chart-container">
                    <span class="tag">Resumo</span>
                    <h3>Qualidade do sistema</h3>
                    <canvas id="qualityChart"></canvas>
                </div>
            </div>
            <div class="project-item">
                <div class="chart-container">
                    <span class="tag">Risco</span>
                    <h3>Eficiência e estabilidade do processo</h3>
                    <canvas id="radarChart"></canvas>
                </div>
            </div>
        </div>
    </section>
    @endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const initial = @json($latest ?? null);
    const ctxHum = document.getElementById('humidityChart').getContext('2d');
    const humidityChart = new Chart(ctxHum, {
        type: 'line',
        data: {
            labels: ['Umidade', 'Temperatura'],
            datasets: [{
                label: 'Leituras',
                data: [initial?.umidade ?? 65, initial?.temperatura ?? 24],
                borderColor: '#27ae60',
                backgroundColor: 'rgba(39, 174, 96, 0.12)',
                tension: 0.35,
                fill: true
            }]
        },
        options: { responsive: true, animation: { duration: 800 } }
    });

    const ctxProfit = document.getElementById('profitChart').getContext('2d');
    const profitChart = new Chart(ctxProfit, {
        type: 'bar',
        data: {
            labels: ['pH', 'Gás', 'Peso'],
            datasets: [{
                label: 'Indicadores',
                data: [initial?.ph ?? 6.8, initial?.gas ?? 120, initial?.peso ?? 18],
                backgroundColor: ['#1e5d3b', '#2ecc71', '#f1c40f']
            }]
        },
        options: { responsive: true, animation: { duration: 800 } }
    });

    const qualityChart = new Chart(document.getElementById('qualityChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Ideal', 'Atenção', 'Risco'],
            datasets: [{
                data: [68, 22, 10],
                backgroundColor: ['#27ae60', '#1e5d3b', '#f1c40f'],
                borderWidth: 0
            }]
        },
        options: { responsive: true, cutout: '65%' }
    });

    const radarChart = new Chart(document.getElementById('radarChart').getContext('2d'), {
        type: 'radar',
        data: {
            labels: ['Umidade', 'Temperatura', 'Estabilidade', 'Eficiência', 'Qualidade'],
            datasets: [{
                label: 'Performance',
                data: [82, 74, 90, 76, 85],
                backgroundColor: 'rgba(39, 174, 96, 0.16)',
                borderColor: '#1e5d3b',
                pointBackgroundColor: '#27ae60'
            }]
        },
        options: { responsive: true, scales: { r: { suggestedMin: 0, suggestedMax: 100 } } }
    });

    function updateAdminCards(data) {
        document.getElementById('admin-umidade').textContent = Number(data?.umidade ?? 0).toFixed(0);
        document.getElementById('admin-temperatura').textContent = Number(data?.temperatura ?? 0).toFixed(1);
        document.getElementById('admin-status').textContent = String(data?.status_contaminacao || 'nao_analisado').replace(/_/g, ' ');
        humidityChart.data.datasets[0].data = [Number(data?.umidade ?? 0), Number(data?.temperatura ?? 0)];
        humidityChart.update();
        profitChart.data.datasets[0].data = [Number(data?.ph ?? 0), Number(data?.gas ?? 0), Number(data?.peso ?? 0)];
        profitChart.update();
        qualityChart.data.datasets[0].data = [Math.max(10, 100 - (Number(data?.umidade ?? 0) / 2)), Math.max(5, (Number(data?.umidade ?? 0) / 3)), Math.max(2, 10 + ((Number(data?.gas ?? 0) / 60)))];
        qualityChart.update();
    }

    function refreshAdminData() {
        fetch('{{ route('arduino.latest') }}')
            .then(r => r.json())
            .then(result => { if (result?.data) updateAdminCards(result.data); })
            .catch(() => {});
    }

    updateAdminCards(initial || {});
    setInterval(refreshAdminData, 5000);
</script>
@endsection