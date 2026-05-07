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
    <section id="dashboard">
        <div class="intro-text">
            <h2>Painel de Controle Arduino</h2>
            <p>Acompanhe a saúde da sua compostagem e a economia gerada em tempo real.</p>
        </div>

        <div class="metrics-panel">
            <div class="metrics-grid">
                <div class="card card-animate">
                    <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="fw-medium text-muted mb-0">Vendas</p>
                            <h2 class="mt-4 ff-secondary fw-semibold">
                                <span class="counter-value" data-target="1200">1.2</span>k
                            </h2>
                            <p class="mb-0 text-muted">
                                <span class="badge bg-light text-success mb-0">
                                    <i class="ri-arrow-up-line align-middle"></i> 8.3 %
                                </span>
                                vs. mês anterior
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
                            <p class="fw-medium text-muted mb-0">Processo</p>
                            <h2 class="mt-4 ff-secondary fw-semibold">
                                <span class="counter-value" data-target="14">14</span>
                            </h2>
                            <p class="mb-0 text-muted">
                                <span class="badge bg-light text-danger mb-0">
                                    <i class="ri-arrow-down-line align-middle"></i> 7.1 %
                                </span>
                                em relação ao mês anterior
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
                            <p class="fw-medium text-muted mb-0">Financeiro</p>
                            <h2 class="mt-4 ff-secondary fw-semibold">
                                <span class="counter-value" data-target="340">340</span>k
                            </h2>
                            <p class="mb-0 text-muted">
                                <span class="badge bg-light text-success mb-0">
                                    <i class="ri-arrow-up-line align-middle"></i> 22.4 %
                                </span>
                                vs. previous month
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