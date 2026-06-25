@extends('Admin.layout_admin')
@section('title', 'Monitoramento Global - EcoCycle')

@section('content')
<section id="dashboard" class="dashboard-hero" style="padding: 1.5rem; background-color: #f8fafc;">
    <div class="dash-top" style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="color: #1e293b; font-weight: 700; margin-bottom: 0.25rem;">Painel de Controle Admin</h2>
            <p style="color: #64748b; font-size: 0.95rem;">Visão consolidada e agregada de todos os módulos de compostagem ativos no sistema.</p>
        </div>
        <span class="live-pill" style="background: #e2e8f0; color: #334155; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.85rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem;">
            <span class="live-dot" style="width: 8px; height: 8px; background: #22c55e; border-radius: 50%; display: inline-block; animation: pulse 1.5s infinite;"></span>
            Média Global (Tempo Real)
        </span>
    </div>

    <div class="metrics" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        
        <div class="mcard" style="background: #ffffff; border-radius: 16px; box-shadow: 0 10px 25px -5px rgba(51, 65, 85, 0.05); overflow: hidden; border: 1px solid #e2e8f0; transition: transform 0.2s;">
            <div style="background: linear-gradient(90deg, #f1f5f9, #ffffff); padding: 1rem 1.5rem; border-bottom: 1px solid #f1f5f9;">
                <div class="mcard-label" style="color: #475569; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">Umidade Média Global</div>
            </div>
            <div style="padding: 1.5rem;">
                <div class="mcard-value" style="font-size: 2.5rem; font-weight: 800; color: #0f172a; margin-bottom: 0.5rem;"><span id="admin-umidade">--</span>%</div>
                <div class="mcard-sub" style="font-size: 0.85rem; color: #64748b; display: flex; align-items: center; gap: 0.5rem;">
                    <span class="badge" style="background: #e0f2fe; color: #0369a1; padding: 3px 8px; border-radius: 6px; font-weight: 700; font-size: 0.75rem;">MÉDIA</span>
                    Todos os sensores ativos
                </div>
            </div>
        </div>

        <div class="mcard" style="background: #ffffff; border-radius: 16px; box-shadow: 0 10px 25px -5px rgba(51, 65, 85, 0.05); overflow: hidden; border: 1px solid #e2e8f0; transition: transform 0.2s;">
            <div style="background: linear-gradient(90deg, #fff7ed, #ffffff); padding: 1rem 1.5rem; border-bottom: 1px solid #fff7ed;">
                <div class="mcard-label" style="color: #ea580c; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">Temperatura Média</div>
            </div>
            <div style="padding: 1.5rem;">
                <div class="mcard-value" style="font-size: 2.5rem; font-weight: 800; color: #431407; margin-bottom: 0.5rem;"><span id="admin-temperatura">--</span>°C</div>
                <div class="mcard-sub" style="font-size: 0.85rem; color: #64748b; display: flex; align-items: center; gap: 0.5rem;">
                    <span class="badge" style="background: #ffedd5; color: #ea580c; padding: 3px 8px; border-radius: 6px; font-weight: 700; font-size: 0.75rem;">MÓDULOS</span>
                    Média térmica dos canteiros
                </div>
            </div>
        </div>

        <div class="mcard" style="background: #ffffff; border-radius: 16px; box-shadow: 0 10px 25px -5px rgba(51, 65, 85, 0.05); overflow: hidden; border: 1px solid #e2e8f0; transition: transform 0.2s;">
            <div style="background: linear-gradient(90deg, #f0fdf4, #ffffff); padding: 1rem 1.5rem; border-bottom: 1px solid #f0fdf4;">
                <div class="mcard-label" style="color: #16a34a; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">Infraestrutura Ativa</div>
            </div>
            <div style="padding: 1.5rem;">
                <div class="mcard-value" style="font-size: 2.5rem; font-weight: 800; color: #16a34a; margin-bottom: 0.5rem;"><span id="admin-status">--</span> <span style="font-size: 1.25rem; font-weight: 500; color: #64748b;">online</span></div>
                <div class="mcard-sub" style="font-size: 0.85rem; color: #64748b; display: flex; align-items: center; gap: 0.5rem;">
                    <span class="badge" style="background: #dcfce7; color: #15803d; padding: 3px 8px; border-radius: 6px; font-weight: 700; font-size: 0.75rem;">REDE</span>
                    Módulos integrados na malha
                </div>
            </div>
        </div>
    </div>

    <div style="display: flex; flex-direction: column; gap: 1.5rem; width: 100%;">
        
        <div class="ccard" style="min-height: 380px; display: flex; flex-direction: column; width: 100%; background: #ffffff; padding: 1.5rem; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.02); border: 1px solid #e2e8f0;">
            <div class="ccard-title" style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 1rem;">Histórico de Umidade Média Global</div>
            <div style="flex: 1; position: relative; width: 100%;">
                <canvas id="humidityChart"></canvas>
            </div>
        </div>

        <div class="charts" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.5rem; width: 100%;">
            
            <div class="ccard" style="min-height: 340px; display: flex; flex-direction: column; background: #ffffff; padding: 1.5rem; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.02); border: 1px solid #e2e8f0;">
                <div class="ccard-title" style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 1rem;">Médias de pH, Gás e Peso Total</div>
                <div style="flex: 1; position: relative; width: 100%;">
                    <canvas id="profitChart"></canvas>
                </div>
            </div>

            <div class="ccard" style="min-height: 340px; display: flex; flex-direction: column; background: #ffffff; padding: 1.5rem; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.02); border: 1px solid #e2e8f0;">
                <div class="ccard-title" style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 1rem;">Histórico de Temperatura Geral</div>
                <div style="flex: 1; position: relative; width: 100%;">
                    <canvas id="temperatureChart"></canvas>
                </div>
            </div>

            <div class="ccard" style="min-height: 340px; display: flex; flex-direction: column; background: #ffffff; padding: 1.5rem; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.02); border: 1px solid #e2e8f0;">
                <div class="ccard-title" style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 1rem;">Latência da API / Resposta da Ponte (ms)</div>
                <div style="flex: 1; position: relative; width: 100%;">
                    <canvas id="networkChart"></canvas>
                </div>
            </div>

        </div>
    </div>
</section>

<style>
    @keyframes pulse {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(34, 197, 94, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const initial = @json($latest ?? null);
    const MAX_PONTOS_GRAFICO = 20; 
    let ultimoIdInserido = null;

    Chart.defaults.set('plugins.legend', {
        labels: { boxWidth: 10, font: { size: 12, family: "'Inter', sans-serif", weight: '600' } }
    });

    function dataInicialValida(dado) {
        if (!dado || !dado.id) return false;
        return true;
    }

    const temDadoRecente = dataInicialValida(initial);
    const horaInicial = new Date().toLocaleTimeString('pt-BR', { hour12: false });

    // 1. Linha - Umidade Média Global
    const humidityChart = new Chart(document.getElementById('humidityChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: temDadoRecente ? [horaInicial] : [],
            datasets: [{
                label: 'Média de Umidade (%)',
                data: temDadoRecente ? [Number(initial.umidade ?? 0)] : [],
                borderColor: '#0284c7',
                backgroundColor: 'rgba(2, 132, 199, 0.04)',
                tension: 0.35,
                fill: true,
                pointRadius: 3,
                borderWidth: 2
            }]
        },
        options: { responsive: true, maintainAspectRatio: false, scales: { y: { min: 0, max: 100 } } }
    });

    // 2. Barras Consolidadas
    const profitChart = new Chart(document.getElementById('profitChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: ['pH Médio', 'Gás Médio (ppm)', 'Peso Total (kg)'],
            datasets: [{
                label: 'Métricas Atuais',
                data: [initial?.ph ?? 0, initial?.gas ?? 0, initial?.peso ?? 0],
                backgroundColor: ['#475569', '#ea580c', '#16a34a'],
                borderRadius: 8,
                barThickness: 32
            }]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
    });

    // 3. Linha - Temperatura Média
    const temperatureChart = new Chart(document.getElementById('temperatureChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: temDadoRecente ? [horaInicial] : [],
            datasets: [{
                label: 'Média de Temperatura (°C)',
                data: temDadoRecente ? [Number(initial.temperatura ?? 0)] : [],
                borderColor: '#ea580c',
                backgroundColor: 'rgba(234, 88, 12, 0.04)',
                tension: 0.35,
                fill: true,
                pointRadius: 3,
                borderWidth: 2
            }]
        },
        options: { responsive: true, maintainAspectRatio: false, scales: { y: { min: 0, max: 80 } } }
    });

    // 4. Linha - Infraestrutura / Latência
    const networkChart = new Chart(document.getElementById('networkChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: temDadoRecente ? [horaInicial] : [],
            datasets: [{
                label: 'Resposta do Endpoint (ms)',
                data: temDadoRecente ? [20] : [],
                borderColor: '#64748b',
                backgroundColor: 'rgba(100, 116, 139, 0.04)',
                tension: 0.2,
                fill: true,
                pointRadius: 2,
                borderWidth: 1.5
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    function updateAdminDashboard(data, latency = 20) {
        if (!data || !data.id) {
            document.getElementById('admin-umidade').textContent = '0';
            document.getElementById('admin-temperatura').textContent = '0.0';
            document.getElementById('admin-status').textContent = '0';
            return;
        }

        // CORREÇÃO: Mapeando as chaves exatas geradas pelo LeituraController::latest()
        const umidade = Number(data?.umidade ?? 0);
        const temperatura = Number(data?.temperatura ?? 0);
        const ph = Number(data?.ph ?? 0);
        const gas = Number(data?.gas ?? 0);
        const peso = Number(data?.peso ?? 0);
        const totalMaquinas = data?.total_maquinas ?? 0;

        document.getElementById('admin-umidade').textContent = umidade.toFixed(0);
        document.getElementById('admin-temperatura').textContent = temperatura.toFixed(1);
        document.getElementById('admin-status').textContent = totalMaquinas;

        profitChart.data.datasets[0].data = [ph, gas, peso];
        profitChart.update();

        if (data.id !== ultimoIdInserido) {
            ultimoIdInserido = data.id;

            const agora = new Date();
            const horaFormatada = agora.toLocaleTimeString('pt-BR', { hour12: false });

            humidityChart.data.labels.push(horaFormatada);
            humidityChart.data.datasets[0].data.push(umidade);

            temperatureChart.data.labels.push(horaFormatada);
            temperatureChart.data.datasets[0].data.push(temperatura);

            networkChart.data.labels.push(horaFormatada);
            networkChart.data.datasets[0].data.push(latency);

            if (humidityChart.data.labels.length > MAX_PONTOS_GRAFICO) {
                humidityChart.data.labels.shift();
                humidityChart.data.datasets[0].data.shift();

                temperatureChart.data.labels.shift();
                temperatureChart.data.datasets[0].data.shift();

                networkChart.data.labels.shift();
                networkChart.data.datasets[0].data.shift();
            }

            humidityChart.update();
            temperatureChart.update();
            networkChart.update();
        }
    }

    function refreshAdminData() {
        const startTime = performance.now();

        fetch('/api/arduino/latest')
            .then(r => r.json())
            .then(result => { 
                const endTime = performance.now();
                const executionTime = Math.round(endTime - startTime);
                
                if (result && result.data) {
                    updateAdminDashboard(result.data, executionTime); 
                }
            })
            .catch(() => {});
    }

    // Inicialização segura
    if (temDadoRecente) {
        updateAdminDashboard(initial);
    } else {
        refreshAdminData();
    }
    
    setInterval(refreshAdminData, 1000);
</script>
@endsection