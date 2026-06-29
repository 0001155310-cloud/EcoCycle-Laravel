@extends('Admin.layout_admin')
@section('title', 'Monitoramento da Estação - EcoCycle')

@section('content')
<section id="dashboard" class="dashboard-hero" style="padding: 1.5rem; background-color: #f8fafc;">
    <div class="dash-top" style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="color: #1e293b; font-weight: 700; margin-bottom: 0.25rem;">Painel de Controle Admin</h2>
            <p style="color: #64748b; font-size: 0.95rem;">Monitoramento direto e qualificação de resíduos na entrada do processo.</p>
        </div>
        
        <div style="display: inline-flex; align-items: center; gap: 0.75rem; background: #ffffff; padding: 0.5rem 1rem; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <span class="live-dot" style="width: 8px; height: 8px; background: #16a34a; border-radius: 50%; display: inline-block; animation: pulse 1.5s infinite;"></span>
            <label for="usb-port-selector" style="font-size: 0.85rem; font-weight: 700; color: #334155; font-family: 'Inter', sans-serif;">Porta Serial:</label>
            <select id="usb-port-selector" style="background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 6px; color: #1e293b; font-size: 0.85rem; font-weight: 600; padding: 4px 8px; cursor: pointer; outline: none;">
                <option value="COM3">COM3 (Windows)</option>
                <option value="COM4">COM4 (Windows)</option>
                <option value="/dev/ttyUSB0">/dev/ttyUSB0 (Linux)</option>
                <option value="/dev/ttyACM0">/dev/ttyACM0 (Linux)</option>
            </select>
        </div>
    </div>

    <div class="metrics" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <div class="mcard" style="background: #ffffff; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #e2e8f0;">
            <div style="background: linear-gradient(90deg, #e0f2fe, #ffffff); padding: 1rem 1.5rem; border-bottom: 1px solid #bae6fd;">
                <div class="mcard-label" style="color: #0369a1; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">Umidade do Lote Atual</div>
            </div>
            <div style="padding: 1.5rem;">
                <div class="mcard-value" style="font-size: 2.5rem; font-weight: 800; color: #0f172a; margin-bottom: 0.5rem;"><span id="admin-umidade">--</span>%</div>
                <div class="mcard-sub" style="font-size: 0.85rem; color: #64748b; display: flex; align-items: center; gap: 0.5rem;">
                    <span class="badge" style="background: #e0f2fe; color: #0369a1; padding: 3px 8px; border-radius: 6px; font-weight: 700; font-size: 0.75rem;">DIRETO</span>
                    Leitura em tempo real do sensor
                </div>
            </div>
        </div>

        <div class="mcard" style="background: #ffffff; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #e2e8f0;">
            <div style="background: linear-gradient(90deg, #ffedd5, #ffffff); padding: 1rem 1.5rem; border-bottom: 1px solid #fed7aa;">
                <div class="mcard-label" style="color: #ea580c; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">Temperatura da Massa</div>
            </div>
            <div style="padding: 1.5rem;">
                <div class="mcard-value" style="font-size: 2.5rem; font-weight: 800; color: #431407; margin-bottom: 0.5rem;"><span id="admin-temperatura">--</span>°C</div>
                <div class="mcard-sub" style="font-size: 0.85rem; color: #64748b; display: flex; align-items: center; gap: 0.5rem;">
                    <span class="badge" style="background: #ffedd5; color: #ea580c; padding: 3px 8px; border-radius: 6px; font-weight: 700; font-size: 0.75rem;">SENSOR</span>
                    Temperatura pontual detectada
                </div>
            </div>
        </div>

        <div class="mcard" style="background: #ffffff; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #e2e8f0;">
            <div style="background: linear-gradient(90deg, #dcfce7, #ffffff); padding: 1rem 1.5rem; border-bottom: 1px solid #bbf7d0;">
                <div class="mcard-label" style="color: #16a34a; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">Módulos Conectados</div>
            </div>
            <div style="padding: 1.5rem;">
                <div class="mcard-value" style="font-size: 2.5rem; font-weight: 800; color: #16a34a; margin-bottom: 0.5rem;"><span id="admin-status">0</span> <span style="font-size: 1.25rem; font-weight: 500; color: #64748b;">online</span></div>
                <div class="mcard-sub" style="font-size: 0.85rem; color: #64748b; display: flex; align-items: center; gap: 0.5rem;">
                    <span class="badge" style="background: #dcfce7; color: #15803d; padding: 3px 8px; border-radius: 6px; font-weight: 700; font-size: 0.75rem;">REDE</span>
                    Estações integradas ao barramento
                </div>
            </div>
        </div>
    </div>

    <div style="display: flex; flex-direction: column; gap: 1.5rem; width: 100%;">
        <div class="ccard" style="min-height: 380px; display: flex; flex-direction: column; width: 100%; background: #ffffff; padding: 1.5rem; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
            <div class="ccard-title" style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 1rem;">Histórico de Variação de Umidade</div>
            <div style="flex: 1; position: relative; width: 100%;">
                <canvas id="humidityChart"></canvas>
            </div>
        </div>

        <div class="charts" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.5rem; width: 100%;">
            <div class="ccard" style="min-height: 340px; display: flex; flex-direction: column; background: #ffffff; padding: 1.5rem; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
                <div class="ccard-title" style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 1rem;">Níveis de pH, Gases e Carga Total</div>
                <div style="flex: 1; position: relative; width: 100%;">
                    <canvas id="profitChart"></canvas>
                </div>
            </div>

            <div class="ccard" style="min-height: 340px; display: flex; flex-direction: column; background: #ffffff; padding: 1.5rem; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
                <div class="ccard-title" style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 1rem;">Histórico Dinâmico de Temperatura</div>
                <div style="flex: 1; position: relative; width: 100%;">
                    <canvas id="temperatureChart"></canvas>
                </div>
            </div>

            <div class="ccard" style="min-height: 340px; display: flex; flex-direction: column; background: #ffffff; padding: 1.5rem; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
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
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(22, 163, 74, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(22, 163, 74, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(22, 163, 74, 0); }
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let ultimoIdInserido = null;

    // ======================================================================
    // INICIALIZAÇÃO DOS GRÁFICOS (CHART.JS)
    // ======================================================================
    const ctxHumidity = document.getElementById('humidityChart').getContext('2d');
    const humidityChart = new Chart(ctxHumidity, {
        type: 'line',
        data: { labels: [], datasets: [{ label: 'Umidade (%)', data: [], borderColor: '#0284c7', backgroundColor: 'rgba(2, 132, 199, 0.1)', tension: 0.3, fill: true }] },
        options: { responsive: true, maintainAspectRatio: false, scales: { y: { min: 0, max: 100 } } }
    });

    const ctxTemperature = document.getElementById('temperatureChart').getContext('2d');
    const temperatureChart = new Chart(ctxTemperature, {
        type: 'line',
        data: { labels: [], datasets: [{ label: 'Temperatura (°C)', data: [], borderColor: '#ea580c', backgroundColor: 'rgba(234, 88, 12, 0.1)', tension: 0.3, fill: true }] },
        options: { responsive: true, maintainAspectRatio: false }
    });

    const ctxNetwork = document.getElementById('networkChart').getContext('2d');
    const networkChart = new Chart(ctxNetwork, {
        type: 'line',
        data: { labels: [], datasets: [{ label: 'Latência (ms)', data: [], borderColor: '#64748b', backgroundColor: 'rgba(100, 116, 139, 0.1)', tension: 0.1 }] },
        options: { responsive: true, maintainAspectRatio: false }
    });

    const ctxProfit = document.getElementById('profitChart').getContext('2d');
    const profitChart = new Chart(ctxProfit, {
        type: 'bar',
        data: { labels: ['pH', 'Gás (PPM)', 'Peso (Kg)'], datasets: [{ label: 'Leitura Atual', data: [0, 0, 0], backgroundColor: ['#3b82f6', '#f59e0b', '#10b981'] }] },
        options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true } } }
    });

    // ======================================================================
    // ATUALIZAÇÃO DO DASHBOARD COM DADOS DA API
    // ======================================================================
    function updateAdminDashboard(data, latency) {
        // Atualiza os Cards Numéricos
        document.getElementById('admin-umidade').textContent = data.umidade ?? '--';
        document.getElementById('admin-temperatura').textContent = data.temperatura ?? '--';
        document.getElementById('admin-status').textContent = '1';

        // Evita duplicar o mesmo ponto se o Arduino ainda não mandou nada novo
        if (ultimoIdInserido === data.id) return;
        ultimoIdInserido = data.id;

        const horaAtual = new Date().toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit', second: '2-digit' });

        // Adiciona dados ao Gráfico de Umidade
        humidityChart.data.labels.push(horaAtual);
        humidityChart.data.datasets[0].data.push(data.umidade);

        // Adiciona dados ao Gráfico de Temperatura
        temperatureChart.data.labels.push(horaAtual);
        temperatureChart.data.datasets[0].data.push(data.temperatura);

        // Adiciona dados ao Gráfico de Latência
        networkChart.data.labels.push(horaAtual);
        networkChart.data.datasets[0].data.push(latency);

        // Atualiza o Gráfico de Barras Múltiplo (pH, Gás, Peso)
        profitChart.data.datasets[0].data = [data.ph ?? 7.0, data.gas ?? 0, data.peso ?? 0];

        // Limita o histórico visual dos gráficos de linha em até 12 pontos para não travar a tela
        if (humidityChart.data.labels.length > 12) {
            humidityChart.data.labels.shift();
            humidityChart.data.datasets[0].data.shift();
            temperatureChart.data.labels.shift();
            temperatureChart.data.datasets[0].data.shift();
            networkChart.data.labels.shift();
            networkChart.data.datasets[0].data.shift();
        }

        // Renderiza as mudanças na tela
        humidityChart.update();
        temperatureChart.update();
        networkChart.update();
        profitChart.update();
    }

    // ======================================================================
    // CONTROLE DE MUDANÇA DE PORTA USB
    // ======================================================================
    document.getElementById('usb-port-selector').addEventListener('change', function() {
        // Limpa o histórico visual para receber a nova filtragem limpa
        humidityChart.data.labels = []; humidityChart.data.datasets[0].data = [];
        temperatureChart.data.labels = []; temperatureChart.data.datasets[0].data = [];
        networkChart.data.labels = []; networkChart.data.datasets[0].data = [];
        profitChart.data.datasets[0].data = [0, 0, 0];
        
        humidityChart.update(); temperatureChart.update(); networkChart.update(); profitChart.update();
        
        ultimoIdInserido = null; // Libera trava de ID
        refreshAdminData();
    });

    function refreshAdminData() {
        const portSelector = document.getElementById('usb-port-selector');
        const selectedPort = portSelector ? portSelector.value : 'COM3';
        const startTime = performance.now();

        fetch(`/api/arduino/latest?port=${encodeURIComponent(selectedPort)}`)
            .then(r => r.json())
            .then(result => { 
                const endTime = performance.now();
                const executionTime = Math.round(endTime - startTime);
                
                if (result && result.data) {
                    updateAdminDashboard(result.data, executionTime); 
                } else {
                    document.getElementById('admin-umidade').textContent = '--';
                    document.getElementById('admin-temperatura').textContent = '--';
                    document.getElementById('admin-status').textContent = '0';
                }
            })
            .catch(() => {});
    }

    refreshAdminData();
    setInterval(refreshAdminData, 1000);
</script>
@endsection