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
    <span id="status-led" class="live-dot" style="width: 8px; height: 8px; background: #dc2626; border-radius: 50%; display: inline-block;"></span>
    <button id="btn-conectar-usb" style="background: #16a34a; border: none; border-radius: 6px; color: #ffffff; font-size: 0.85rem; font-weight: 600; padding: 6px 12px; cursor: pointer; outline: none; transition: background 0.2s;">
        Conectar Arduino via Navegador
    </button>
    <span id="nome-porta" style="font-size: 0.85rem; color: #64748b; font-weight: 500;">(Desconectado)</span>
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
    let portaSerialNavegador = null;
    let leitorSerial = null;

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
        data: { labels: [], datasets: [{ label: 'Latência Envio API (ms)', data: [], borderColor: '#64748b', backgroundColor: 'rgba(100, 116, 139, 0.1)', tension: 0.1 }] },
        options: { responsive: true, maintainAspectRatio: false }
    });

    const ctxProfit = document.getElementById('profitChart').getContext('2d');
    const profitChart = new Chart(ctxProfit, {
        type: 'bar',
        data: { labels: ['pH', 'Gás (PPM)', 'Peso (Kg)'], datasets: [{ label: 'Leitura Atual', data: [0, 0, 0], backgroundColor: ['#3b82f6', '#f59e0b', '#10b981'] }] },
        options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true } } }
    });

    // ======================================================================
    // PROCESSAR E EXIBIR DADOS DIRETOS DO ARDUINO
    // ======================================================================
    function processarDadosArduinoLocais(linhaBruta) {
        if (!linhaBruta || linhaBruta.includes("Iniciando")) return;

        // Formato esperado do Arduino: umidade,temperatura,gas
        const dados = linhaBruta.split(',');
        if (dados.length < 3) return;

        const umidade = parseFloat(dados[0]);
        const temperatura = parseFloat(dados[1]);
        const gas = parseFloat(dados[2]);
        const ph = 7.0; // Padrão se não houver sensor físico
        const peso = 0.0;

        // 1. Atualiza os Cards Numéricos na Tela do Admin Instantaneamente
        document.getElementById('admin-umidade').textContent = umidade.toFixed(0);
        document.getElementById('admin-temperatura').textContent = temperatura.toFixed(1);

        const horaAtual = new Date().toLocaleTimeString('pt-BR', { hour12: false });

        // 2. Empurra os dados para os Gráficos
        humidityChart.data.labels.push(horaAtual);
        humidityChart.data.datasets[0].data.push(umidade);

        temperatureChart.data.labels.push(horaAtual);
        temperatureChart.data.datasets[0].data.push(temperatura);

        profitChart.data.datasets[0].data = [ph, gas, peso];

        // Limita o histórico visual em 12 pontos
        if (humidityChart.data.labels.length > 12) {
            humidityChart.data.labels.shift();
            humidityChart.data.datasets[0].data.shift();
            temperatureChart.data.labels.shift();
            temperatureChart.data.datasets[0].data.shift();
        }

        humidityChart.update();
        temperatureChart.update();
        profitChart.update();

        // 3. Envia em segundo plano para o banco do Render para salvar o histórico
        const tempoInicioEnvio = performance.now();
        
        fetch('/api/leituras', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                dispositivo_id: 'arduino_01',
                porta_serial: 'Navegador_WebSerial',
                temperatura: temperatura,
                umidade: umidade,
                gas: gas,
                ph: ph,
                peso: peso,
                origem_cliente: 'painel_principal'
            })
        })
        .then(() => {
            const tempoFimEnvio = performance.now();
            const latencia = Math.round(tempoFimEnvio - tempoInicioEnvio);
            
            // Atualiza o gráfico de latência com a resposta do Render
            networkChart.data.labels.push(horaAtual);
            networkChart.data.datasets[0].data.push(latencia);
            if (networkChart.data.labels.length > 12) {
                networkChart.data.labels.shift();
                networkChart.data.datasets[0].data.shift();
            }
            networkChart.update();
        })
        .catch(() => {});
    }

    // ======================================================================
    // CONEXÃO COM A WEB SERIAL API (FORNECIDA PELO NAVEGADOR)
    // ======================================================================
    async function conectarArduinoPeloNavegador() {
        if (!("serial" in navigator)) {
            alert("Seu navegador não suporta conexão USB direta. Use o Google Chrome ou Microsoft Edge.");
            return;
        }

        try {
            // Solicita ao navegador para mostrar a lista de portas disponíveis
            portaSerialNavegador = await navigator.serial.requestPort();
            
            // Abre a conexão com a velocidade padrão do seu Arduino (9600)
            await portaSerialNavegador.open({ baudRate: 9600 });
            
            // Atualiza o Layout para indicar sucesso
            document.getElementById('status-led').style.background = '#16a34a'; // Verde
            document.getElementById('status-led').style.animation = 'pulse 1.5s infinite';
            document.getElementById('nome-porta').textContent = '(Conectado via USB)';
            document.getElementById('admin-status').textContent = '1';
            document.getElementById('btn-conectar-usb').style.display = 'none';

            // Loop de leitura contínua da porta USB
            while (portaSerialNavegador.readable) {
                const textDecoder = new TextDecoderStream();
                const readableStreamClosed = portaSerialNavegador.readable.pipeTo(textDecoder.writable);
                const reader = textDecoder.readable.getReader();
                leitorSerial = reader;

                let buffer = '';
                try {
                    while (true) {
                        const { value, done } = await reader.read();
                        if (done) break;
                        
                        buffer += value;
                        // O Arduino envia um quebra de linha (\n) ao fim de cada transmissão
                        if (buffer.includes('\n')) {
                            const linhas = buffer.split('\n');
                            // Processa a linha completa anterior
                            const linhaCompleta = linhas[0].trim();
                            processarDadosArduinoLocais(linhaCompleta);
                            // Guarda o resto no buffer
                            buffer = linhas.slice(1).join('\n');
                        }
                    }
                } catch (error) {
                    console.error("Erro na leitura dos dados: ", error);
                } finally {
                    reader.releaseLock();
                }
            }

        } catch (err) {
            console.error("O usuário cancelou ou a porta falhou:", err);
            alert("Não foi possível conectar ao dispositivo USB.");
        }
    }

    // Vincula a ação de clicar ao botão criado
    document.getElementById('btn-conectar-usb').addEventListener('click', conectarArduinoPeloNavegador);
</script>
@endsection