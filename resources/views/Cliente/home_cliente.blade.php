@extends('Cliente.layout_cliente')
@section('title', 'Monitoramento Real-Time - EcoCycle')

@section('styles')
<style>
    *, ::after, ::before {
        box-sizing: border-box;
    }

    .chart-wrapper {
        position: relative;
        width: 100%;
        height: 300px;
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
        .ccard {
            padding: 1rem !important;
        }
    }
</style>
@endsection

@section('content')
<section class="dashboard-hero">
    <div class="dash-top">
        <div>
            <h2>Painel do Cliente</h2>
            <p>Acompanhe a saúde da sua compostagem e o desempenho dos sensores em tempo real.</p>
        </div>
        <div style="display: inline-flex; align-items: center; gap: 0.75rem; background: #ffffff; padding: 0.5rem 1rem; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <span id="status-led" style="width: 8px; height: 8px; background: #dc2626; border-radius: 50%; display: inline-block;"></span>
            <button id="btn-conectar-usb" style="background: #16a34a; border: none; border-radius: 6px; color: #ffffff; font-size: 0.85rem; font-weight: 600; padding: 6px 12px; cursor: pointer; outline: none; transition: background 0.2s;">
                Conectar Dispositivo
            </button>
            <span id="nome-porta" style="font-size: 0.85rem; color: #64748b; font-weight: 500;">(Desconectado)</span>
        </div>
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

    <div class="projects-container" id="graficos" style="display: flex; flex-direction: column; gap: 1.5rem; width: 100%;">
        <article class="project-item full-width-card">
            <div class="chart-container full-chart-card">
                <span class="tag">Umidade em tempo real</span>
                <h3>Variação da umidade do solo</h3>
                <p id="deviceWarning" class="device-warning" style="color: #e74c3c; font-size: 0.9rem; margin-top: 0.5rem; display: none;">Nenhum dispositivo Arduino encontrado no banco. Conecte um sensor para ver a leitura em tempo real.</p>
                <div class="chart-wrapper" style="margin-top: 1.5rem;">
                    <canvas id="liveHumidityChart"></canvas>
                </div>
            </div>
        </article>

        <div class="charts-responsive-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.5rem; width: 100%; align-items: stretch;">
            <article class="project-item" style="display: flex;">
                <div class="chart-container full-chart-card" style="display: flex; flex-direction: column; width: 100%; justify-content: space-between; padding: 1.5rem;">
                    <div>
                        <span class="tag">Indicadores</span>
                        <h3 style="margin-bottom: 1rem;">pH, Gás e Peso</h3>
                    </div>
                    <div class="indicator-grid" style="display: flex; flex-direction: column; gap: 0.75rem; flex: 1; justify-content: center;">
                        <div class="indicator-card"><span class="indicator-label">pH</span><strong id="info-ph">--</strong><small>Neutralidade do composto</small><div class="indicator-bar"><i id="bar-ph"></i></div></div>
                        <div class="indicator-card"><span class="indicator-label">Gás</span><strong id="info-gas">--</strong><small>Concentração detectada</small><div class="indicator-bar"><i id="bar-gas"></i></div></div>
                        <div class="indicator-card"><span class="indicator-label">Peso</span><strong id="info-peso">--</strong><small>Material em processo</small><div class="indicator-bar"><i id="bar-peso"></i></div></div>
                    </div>
                </div>
            </article>

            <article class="project-item" style="display: flex;">
                <div class="chart-container full-chart-card" style="display: flex; flex-direction: column; width: 100%; padding: 1.5rem;">
                    <span class="tag">Temperatura Real</span>
                    <h3 style="margin-bottom: 1rem;">Histórico Térmico do Composto (°C)</h3>
                    <div class="chart-wrapper" style="flex: 1; min-height: 250px;">
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
    const initial = @json($live ?? $latest ?? null);
    const MAX_PONTOS_GRAFICO = 20; 
    let ultimoIdInserido = null;
    let ultimaPortaAtiva = null; // Guarda o estado da porta ativa para detectar mudanças
    let portaSerialNavegador = null;
    let leitorSerial = null;

    Chart.defaults.set('plugins.legend', {
        labels: { font: { family: "'Inter', sans-serif", size: 12 } }
    });

    const liveHumidityChart = new Chart(document.getElementById('liveHumidityChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Umidade (%)',
                data: [],
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
            labels: [],
            datasets: [{
                label: 'Temperatura (°C)',
                data: [],
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

    function updateDashboard(data) {
        if (!data || !data.id) {
            deviceWarning.style.display = 'block';
            document.getElementById('val-umidade').textContent = '0%';
            document.getElementById('val-temperatura').textContent = '0°C';
            document.getElementById('val-peso').textContent = '0 kg';
            document.getElementById('status-text').textContent = 'Dispositivo não encontrado';
            document.getElementById('bar-ph').style.width = '0%';
            document.getElementById('bar-gas').style.width = '0%';
            document.getElementById('bar-peso').style.width = '0%';
            return;
        }

        const umidade = Number(data.umidade ?? 0);
        const temperatura = Number(data.temperatura ?? 0);
        const peso = Number(data.peso ?? 0);
        const ph = Number(data.ph ?? 0);
        const gas = Number(data.gas ?? 0);

        deviceWarning.style.display = 'none';

        document.getElementById('val-umidade').textContent = `${umidade.toFixed(0)}%`;
        document.getElementById('val-temperatura').textContent = `${temperatura.toFixed(1)}°C`;
        document.getElementById('val-peso').textContent = `${peso.toFixed(1)} kg`;
        document.getElementById('status-text').textContent = (data.status_contaminacao || 'nao_analisado');

        document.getElementById('info-ph').textContent = ph.toFixed(1);
        document.getElementById('info-gas').textContent = `${gas.toFixed(0)} ppm`;
        document.getElementById('info-peso').textContent = `${peso.toFixed(1)} kg`;

        document.getElementById('bar-ph').style.width = `${Math.min(100, Math.max(8, ph * 10))}%`;
        document.getElementById('bar-gas').style.width = `${Math.min(100, gas / 2.5)}%`;
        document.getElementById('bar-peso').style.width = `${Math.min(100, peso * 5)}%`;

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

    function atualizarInterfaceComArduino({ umidade, temperatura, peso, ph, gas, statusContaminacao, horaAtual }) {
        deviceWarning.style.display = 'none';

        document.getElementById('val-umidade').textContent = `${umidade.toFixed(0)}%`;
        document.getElementById('val-temperatura').textContent = `${temperatura.toFixed(1)}°C`;
        document.getElementById('val-peso').textContent = `${peso.toFixed(1)} kg`;
        document.getElementById('status-text').textContent = statusContaminacao;

        document.getElementById('info-ph').textContent = ph.toFixed(1);
        document.getElementById('info-gas').textContent = `${gas.toFixed(0)} ppm`;
        document.getElementById('info-peso').textContent = `${peso.toFixed(1)} kg`;

        document.getElementById('bar-ph').style.width = `${Math.min(100, Math.max(8, ph * 10))}%`;
        document.getElementById('bar-gas').style.width = `${Math.min(100, gas / 2.5)}%`;
        document.getElementById('bar-peso').style.width = `${Math.min(100, peso * 5)}%`;

        liveHumidityChart.data.labels.push(horaAtual);
        liveHumidityChart.data.datasets[0].data.push(umidade);

        liveTemperatureChart.data.labels.push(horaAtual);
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

    function processarDadosArduinoLocais(linhaBruta) {
        if (!linhaBruta || linhaBruta.includes('Iniciando')) return;

        const dados = linhaBruta.split(',');
        if (dados.length < 3) return;

        const umidade = parseFloat(dados[0]);
        const temperatura = parseFloat(dados[1]);
        const gas = parseFloat(dados[2]);
        const ph = dados[3] ? parseFloat(dados[3]) : 7.0;
        const peso = dados[4] ? parseFloat(dados[4]) : 0.0;
        const plasticoDetectado = dados[5] ? parseInt(dados[5].trim()) === 1 : false;

        let statusContaminacao = 'Aprovado';
        if (plasticoDetectado) {
            statusContaminacao = 'Rejeitado';
        } else if (umidade < 30 || umidade > 85 || temperatura > 70 || gas > 600 || ph < 4 || ph > 9) {
            statusContaminacao = 'Inspecionar';
        }

        atualizarInterfaceComArduino({
            umidade,
            temperatura,
            peso,
            ph,
            gas,
            statusContaminacao,
            horaAtual: new Date().toLocaleTimeString('pt-BR', { hour12: false })
        });
    }

    function redefinirInterfaceDesconectado() {
        document.getElementById('status-led').style.background = '#dc2626';
        document.getElementById('status-led').style.animation = 'none';
        document.getElementById('nome-porta').textContent = '(Desconectado)';
        document.getElementById('btn-conectar-usb').style.background = '#16a34a';
        document.getElementById('btn-conectar-usb').textContent = 'Conectar Dispositivo';
        document.getElementById('btn-conectar-usb').disabled = false;
        portaSerialNavegador = null;
        leitorSerial = null;
    }

    async function gerenciarFluxoLeitura(porta) {
        try {
            await porta.open({ baudRate: 9600 });
            portaSerialNavegador = porta;

            document.getElementById('status-led').style.background = '#16a34a';
            document.getElementById('status-led').style.animation = 'pulse 1.5s infinite';
            document.getElementById('nome-porta').textContent = '(Conectado via USB)';
            const botao = document.getElementById('btn-conectar-usb');
            botao.textContent = 'Dispositivo Conectado';
            botao.style.background = '#64748b';
            botao.disabled = true;

            while (porta.readable) {
                const textDecoder = new TextDecoderStream();
                const readableStreamClosed = porta.readable.pipeTo(textDecoder.writable);
                const reader = textDecoder.readable.getReader();
                leitorSerial = reader;

                let buffer = '';
                try {
                    while (true) {
                        const { value, done } = await reader.read();
                        if (done) break;

                        buffer += value;
                        if (buffer.includes('\n')) {
                            const linhas = buffer.split('\n');
                            const linhaCompleta = linhas[0].trim();
                            processarDadosArduinoLocais(linhaCompleta);
                            buffer = linhas.slice(1).join('\n');
                        }
                    }
                } catch (error) {
                    console.error('Erro na leitura serial contínua:', error);
                } finally {
                    reader.releaseLock();
                }
            }
        } catch (err) {
            console.error('Falha ao abrir ou ler porta USB:', err);
            redefinirInterfaceDesconectado();
        }
    }

    async function conectarArduinoPeloNavegador() {
        if (!('serial' in navigator)) {
            alert('Seu navegador não suporta conexão USB direta. Use o Google Chrome ou Microsoft Edge.');
            return;
        }

        try {
            const porta = await navigator.serial.requestPort();
            await gerenciarFluxoLeitura(porta);
        } catch (err) {
            console.error('Solicitação manual rejeitada:', err);
        }
    }

    async function checarEAutoConectar() {
        if ('serial' in navigator && !portaSerialNavegador) {
            try {
                const portasAutorizadas = await navigator.serial.getPorts();
                if (portasAutorizadas.length > 0) {
                    await gerenciarFluxoLeitura(portasAutorizadas[0]);
                }
            } catch (e) {
                console.error('Falha na varredura automática:', e);
            }
        }
    }

    // Limpa visualmente o gráfico se a porta mudar lá no Admin
    function limparGraficosPorMudancaDePorta() {
        liveHumidityChart.data.labels = [];
        liveHumidityChart.data.datasets[0].data = [];
        liveTemperatureChart.data.labels = [];
        liveTemperatureChart.data.datasets[0].data = [];
        liveHumidityChart.update();
        liveTemperatureChart.update();
        ultimoIdInserido = null;
    }

    function refreshData() {
        if (portaSerialNavegador) {
            return;
        }

        // 1. Descobre de forma transparente qual porta o administrador ativou
        fetch('/api/arduino/config-porta')
            .then(res => res.json())
            .then(config => {
                const portaAtiva = config.porta || 'COM3';

                // Se o administrador mudou a porta no painel dele, limpa as linhas para o cliente também
                if (ultimaPortaAtiva !== null && ultimaPortaAtiva !== portaAtiva) {
                    limparGraficosPorMudancaDePorta();
                }
                ultimaPortaAtiva = portaAtiva;

                // 2. Busca o dado mais recente filtrando especificamente por aquela porta ativa
                return fetch(`/api/arduino/latest?port=${encodeURIComponent(portaAtiva)}`);
            })
            .then(r => r.json())
            .then(result => {
                if (result && result.data && result.data.id !== null) {
                    updateDashboard(result.data);
                } else {
                    updateDashboard(null); 
                }
            })
            .catch(() => {
                updateDashboard(null);
            });
    }

    document.getElementById('btn-conectar-usb').addEventListener('click', conectarArduinoPeloNavegador);
    window.addEventListener('DOMContentLoaded', checarEAutoConectar);
    window.addEventListener('focus', checarEAutoConectar);

    if ('serial' in navigator) {
        navigator.serial.addEventListener('disconnect', () => {
            redefinirInterfaceDesconectado();
        });
    }

    // Inicialização segura
    refreshData();
    setInterval(refreshData, 1000);
</script>
@endsection