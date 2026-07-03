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
                Conectar Dispositivo
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

    <div id="container-triagem" style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 1.5rem; margin-bottom: 2rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); display: flex; flex-direction: column; gap: 1rem; transition: all 0.3s ease;">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <div id="badge-status-triagem" style="background: #cbd5e1; color: #1e293b; font-size: 0.85rem; font-weight: 800; text-transform: uppercase; padding: 6px 16px; border-radius: 50px; letter-spacing: 0.05em;">
                    Aguardando Leitura
                </div>
                <h3 style="font-size: 1.15rem; font-weight: 700; color: #1e293b; margin: 0; font-family: 'Inter', sans-serif;">Análise Diagnóstica da Carga</h3>
            </div>
            <span id="timestamp-triagem" style="font-size: 0.85rem; color: #64748b; font-weight: 500;">--:--:--</span>
        </div>
        <hr style="border: 0; border-top: 1px solid #f1f5f9; margin: 0;">
        <div>
            <h4 style="font-size: 0.9rem; font-weight: 700; color: #475569; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.025em;">Instruções Operacionais:</h4>
            <p id="texto-instrucao-triagem" style="font-size: 1rem; color: #64748b; line-height: 1.6; margin: 0; font-weight: 500;">
                Conecte o dispositivo Arduino na porta correspondente para iniciar o escaneamento físico, químico e visual da bombona recebida.
            </p>
        </div>
        <div id="alertas-detalhes-parametros" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 0.75rem; margin-top: 0.5rem;">
        </div>
    </div>

    <div style="display: flex; flex-direction: column; gap: 1.5rem; width: 100%; margin-bottom: 2rem;">
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

        <div class="charts-adicionais" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.5rem; width: 100%;">
            <div class="ccard" style="min-height: 340px; display: flex; flex-direction: column; background: #ffffff; padding: 1.5rem; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
                <div class="ccard-title" style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 1rem;">Concentração Estimada de Materiais</div>
                <div style="flex: 1; position: relative; width: 100%; display: flex; justify-content: center; align-items: center;">
                    <canvas id="lixiviadoChart"></canvas>
                </div>
            </div>

            <div class="ccard" style="min-height: 340px; display: flex; flex-direction: column; background: #ffffff; padding: 1.5rem; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
                <div class="ccard-title" style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 1rem;">Redução de Massa: Peso Antes vs. Pós-Adubagem (Kg)</div>
                <div style="flex: 1; position: relative; width: 100%;">
                    <canvas id="pesoComparacaoChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div style="display: flex; justify-content: flex-end; width: 100%; padding-top: 1rem; border-top: 1px solid #e2e8f0;">
        <a href="{{ route('admin.estacao.detalhes') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; background: #1e293b; color: #ffffff; font-weight: 600; font-size: 0.95rem; padding: 0.75rem 1.5rem; border-radius: 10px; text-decoration: none; box-shadow: 0 4px 6px -1px rgba(15, 23, 42, 0.1); transition: all 0.2s ease;" onmouseover="this.style.background='#334155'" onmouseout="this.style.background='#1e293b'">
            Acessar Relatórios Detalhados da Estação
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
        </a>
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

    // Configurações analíticas internas
    const LIMITES_QUALIFICACAO = {
        umidade: { aprovadoMin: 60, aprovadoMax: 85, toleravelMin: 30, toleravelMax: 85 },
        temperatura: { aprovadoMax: 65, inspecionarMax: 70 },
        ph: { aprovadoMin: 4.5, aprovadoMax: 8.5, inspecionarMin: 4.0, inspecionarMax: 9.0 },
        gas: { minIdeal: 150, maxIdeal: 450, criticoMax: 600 }
    };

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

    // ADICIONADO: Gráfico de Rosca - Concentração de Lixiviado
    const ctxLixiviado = document.getElementById('lixiviadoChart').getContext('2d');
    const lixiviadoChart = new Chart(ctxLixiviado, {
        type: 'doughnut',
        data: {
            labels: ['Água (Umidade)', 'Matéria Orgânica Dissolvida', 'Compostos Nitrogenados', 'Minerais Traço'],
            datasets: [{
                data: [70, 18, 9, 3],
                backgroundColor: ['#38bdf8', '#854d0e', '#10b981', '#94a3b8'],
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } }
            }
        }
    });

    // ADICIONADO: Gráfico de Barras - Comparação de Peso Antes / Pós Adubagem
    const ctxPesoComparacao = document.getElementById('pesoComparacaoChart').getContext('2d');
    const pesoComparacaoChart = new Chart(ctxPesoComparacao, {
        type: 'bar',
        data: {
            labels: ['Lote 01', 'Lote 02', 'Lote 03', 'Lote 04'],
            datasets: [
                {
                    label: 'Peso Inicial (Entrada)',
                    data: [450, 620, 380, 510],
                    backgroundColor: '#ef4444',
                    borderRadius: 4
                },
                {
                    label: 'Peso Final (Pós-Adubagem)',
                    data: [180, 240, 150, 210],
                    backgroundColor: '#22c55e',
                    borderRadius: 4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true }
            },
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } }
            }
        }
    });

    // ======================================================================
    // PROCESSAR E EXIBIR DADOS DIRETOS DO ARDUINO + INTEGRAÇÃO COM REGRAS DE NEGÓCIO
    // ======================================================================
    function processarDadosArduinoLocais(linhaBruta) {
        if (!linhaBruta || linhaBruta.includes("Iniciando")) return;

        const dados = linhaBruta.split(',');
        if (dados.length < 3) return;

        const umidade = parseFloat(dados[0]);
        const temperatura = parseFloat(dados[1]);
        const gas = parseFloat(dados[2]);
        const ph = dados[3] ? parseFloat(dados[3]) : 7.0;
        const peso = dados[4] ? parseFloat(dados[4]) : 0.0;
        const plasticoDetectado = dados[5] ? parseInt(dados[5].trim()) === 1 : false;

        document.getElementById('admin-umidade').textContent = umidade.toFixed(0);
        document.getElementById('admin-temperatura').textContent = temperatura.toFixed(1);

        const horaAtual = new Date().toLocaleTimeString('pt-BR', { hour12: false });
        document.getElementById('timestamp-triagem').textContent = `Última varredura: ${horaAtual}`;

        let nivelGravidade = 'APROVADO'; 
        let motivosAlertas = [];

        if (plasticoDetectado) {
            nivelGravidade = 'REJEITADO';
            motivosAlertas.push("❌ <strong>Contaminação Física:</strong> Plástico detectado na bombona.");
        }

        if (umidade < LIMITES_QUALIFICACAO.umidade.toleravelMin || umidade > LIMITES_QUALIFICACAO.umidade.toleravelMax) {
            nivelGravidade = 'REJEITADO';
            motivosAlertas.push(`❌ <strong>Umidade Crítica:</strong> Fora da faixa tolerável de processing (${umidade.toFixed(0)}%).`);
        } else if (umidade < LIMITES_QUALIFICACAO.umidade.aprovadoMin) {
            if (nivelGravidade !== 'REJEITADO') nivelGravidade = 'INSPECIONAR';
            motivosAlertas.push(`⚠️ <strong>Umidade Limite:</strong> Fora do padrão ideal determinado (${umidade.toFixed(0)}%).`);
        }

        if (temperatura > LIMITES_QUALIFICACAO.temperatura.inspecionarMax) {
            nivelGravidade = 'REJEITADO';
            motivosAlertas.push(`❌ <strong>Temperatura Crítica:</strong> Superou o teto microbiano (${temperatura.toFixed(1)}°C).`);
        } else if (temperatura > LIMITES_QUALIFICACAO.temperatura.aprovadoMax) {
            if (nivelGravidade !== 'REJEITADO') nivelGravidade = 'INSPECIONAR';
            motivosAlertas.push(`⚠️ <strong>Temperatura Elevada:</strong> Em faixa de transição térmica (${temperatura.toFixed(1)}°C).`);
        }

        if (ph < LIMITES_QUALIFICACAO.ph.inspecionarMin || ph > LIMITES_QUALIFICACAO.ph.inspecionarMax) {
            nivelGravidade = 'REJEITADO';
            motivosAlertas.push(`❌ <strong>pH Inadequado:</strong> Fora dos limites viáveis de compostagem (${ph.toFixed(1)}).`);
        } else if (ph < LIMITES_QUALIFICACAO.ph.aprovadoMin || ph > LIMITES_QUALIFICACAO.ph.aprovadoMax) {
            if (nivelGravidade !== 'REJEITADO') nivelGravidade = 'INSPECIONAR';
            motivosAlertas.push(`⚠️ <strong>pH em Desvio:</strong> Carga levemente ácida ou alcalina (${ph.toFixed(1)}).`);
        }

        if (gas > LIMITES_QUALIFICACAO.gas.criticoMax) {
            nivelGravidade = 'REJEITADO';
            motivosAlertas.push(`❌ <strong>Gases Críticos:</strong> Perigo extremo de emanação volátil (${gas.toFixed(0)} PPM).`);
        } else if (gas > LIMITES_QUALIFICACAO.gas.maxIdeal) {
            if (nivelGravidade !== 'REJEITADO') nivelGravidade = 'INSPECIONAR';
            motivosAlertas.push(`⚠️ <strong>Gás Muito Alto:</strong> Concentração gasosa elevada detectada (${gas.toFixed(0)} PPM).`);
        } else if (gas < LIMITES_QUALIFICACAO.gas.minIdeal) {
            if (nivelGravidade !== 'REJEITADO') nivelGravidade = 'INSPECIONAR';
            motivosAlertas.push(`⚠️ <strong>Atenção - Ausência de Gases:</strong> Concentração abaixo do esperado para material orgânico active (${gas.toFixed(0)} PPM).`);
        }

        const containerTriagem = document.getElementById('container-triagem');
        const badgeTriagem = document.getElementById('badge-status-triagem');
        const textoInstrucao = document.getElementById('texto-instrucao-triagem');
        const painelDetalhes = document.getElementById('alertas-detalhes-parametros');

        painelDetalhes.innerHTML = ''; 

        if (nivelGravidade === 'REJEITADO') {
            containerTriagem.style.borderColor = '#ef4444';
            containerTriagem.style.background = '#fef2f2';
            badgeTriagem.style.background = '#ef4444';
            badgeTriagem.style.color = '#ffffff';
            badgeTriagem.textContent = 'REJEITADO / CONTAMINADO';
            
            textoInstrucao.innerHTML = '<span style="color: #b91c1c; font-weight: 700;">AÇÃO EXIGIDA:</span> Realize o <strong>DESVIO IMEDIATO</strong> deste material orgânico do fluxo de esteira padrão. A carga contém contaminantes ou desvios químicos críticos que inviabilizam a sua mistura com a massa principal, sob risco de inviabilizar o lote microbiológico.';
        } else if (nivelGravidade === 'INSPECIONAR') {
            containerTriagem.style.borderColor = '#f59e0b';
            containerTriagem.style.background = '#fffbeb';
            badgeTriagem.style.background = '#f59e0b';
            badgeTriagem.style.color = '#ffffff';
            badgeTriagem.textContent = 'INSPECIONAR CARGA';

            textoInstrucao.innerHTML = '<span style="color: #b45309; font-weight: 700;">AÇÃO SUGERIDA:</span> Conduza uma <strong>AVALIAÇÃO VISUAL E SELETIVA</strong> manual na bombona antes da deposição final. Verifique o histórico de descarte deste cliente específico e avalie a presença de impurezas pontuais.';
        } else {
            containerTriagem.style.borderColor = '#10b981';
            containerTriagem.style.background = '#f0fdf4';
            badgeTriagem.style.background = '#10b981';
            badgeTriagem.style.color = '#ffffff';
            badgeTriagem.textContent = 'APROVADO';

            textoInstrucao.innerHTML = 'Carga em conformidade estrutural e microbiológica ideal. <strong>LIBERAÇÃO AUTORIZADA</strong> para processamento e encaminhamento direto ao pátio de compostagem activa da Massalas.';
        }

        motivosAlertas.forEach(motivo => {
            const minicard = document.createElement('div');
            minicard.style.background = 'rgba(255,255,255,0.85)';
            minicard.style.border = '1px solid rgba(0,0,0,0.06)';
            minicard.style.padding = '0.5rem 0.75rem';
            minicard.style.borderRadius = '8px';
            minicard.style.fontSize = '0.85rem';
            minicard.style.color = '#334155';
            minicard.innerHTML = motivo;
            painelDetalhes.appendChild(minicard);
        });

        if (motivosAlertas.length === 0) {
            painelDetalhes.innerHTML = '<div style="color: #047857; font-size: 0.85rem; font-weight: 600;">✓ Todas as variáveis físico-químicas operam dentro da faixa verde.</div>';
        }

        humidityChart.data.labels.push(horaAtual);
        humidityChart.data.datasets[0].data.push(umidade);
        temperatureChart.data.labels.push(horaAtual);
        temperatureChart.data.datasets[0].data.push(temperatura);
        profitChart.data.datasets[0].data = [ph, gas, peso];

        if (humidityChart.data.labels.length > 12) {
            humidityChart.data.labels.shift();
            humidityChart.data.datasets[0].data.shift();
            temperatureChart.data.labels.shift();
            temperatureChart.data.datasets[0].data.shift();
        }

        humidityChart.update();
        temperatureChart.update();
        profitChart.update();

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
                status_contaminacao: nivelGravidade.toLowerCase(),
                origem_cliente: 'painel_principal'
            })
        })
        .then(() => {
            const tempoFimEnvio = performance.now();
            const latencia = Math.round(tempoFimEnvio - tempoInicioEnvio);
            
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
    // LOGICA ROBUSTA DE LEITURA E CONEXÃO SERIAL (AUTO-RECONECTÁVEL)
    // ======================================================================
    async function gerenciarFluxoLeitura(porta) {
        try {
            await porta.open({ baudRate: 9600 });
            portaSerialNavegador = porta;
            
            document.getElementById('status-led').style.background = '#16a34a'; 
            document.getElementById('status-led').style.animation = 'pulse 1.5s infinite';
            document.getElementById('nome-porta').textContent = '(Conectado via USB)';
            document.getElementById('admin-status').textContent = '1';
            document.getElementById('btn-conectar-usb').style.display = 'none';

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
                    console.error("Erro na leitura serial contínua:", error);
                } finally {
                    reader.releaseLock();
                }
            }
        } catch (err) {
            console.error("Falha ao abrir ou ler porta USB:", err);
            redefinirInterfaceDesconectado();
        }
    }

    function redefinirInterfaceDesconectado() {
        document.getElementById('status-led').style.background = '#dc2626'; 
        document.getElementById('status-led').style.animation = 'none';
        document.getElementById('nome-porta').textContent = '(Desconectado)';
        document.getElementById('admin-status').textContent = '0';
        document.getElementById('btn-conectar-usb').style.display = 'inline-block';
        portaSerialNavegador = null;
    }

    async function conectarArduinoPeloNavegador() {
        if (!("serial" in navigator)) {
            alert("Seu navegador não suporta conexão USB direta. Use o Google Chrome ou Microsoft Edge.");
            return;
        }
        try {
            const porta = await navigator.serial.requestPort();
            await gerenciarFluxoLeitura(porta);
        } catch (err) {
            console.error("Solicitação manual rejeitada:", err);
        }
    }

    async function checarEAutoConectar() {
        if ("serial" in navigator && !portaSerialNavegador) {
            try {
                const portasAutorizadas = await navigator.serial.getPorts();
                if (portasAutorizadas.length > 0) {
                    console.log("Porta previamente autorizada encontrada. Reconectando...");
                    await gerenciarFluxoLeitura(portasAutorizadas[0]);
                }
            } catch (e) {
                console.error("Falha na varredura automática:", e);
            }
        }
    }

    document.getElementById('btn-conectar-usb').addEventListener('click', conectarArduinoPeloNavegador);
    window.addEventListener('DOMContentLoaded', checarEAutoConectar);
    window.addEventListener('focus', checarEAutoConectar); 
    
    if ("serial" in navigator) {
        navigator.serial.addEventListener('disconnect', () => {
            console.warn("Dispositivo USB desconectado fisicamente.");
            redefinirInterfaceDesconectado();
        });
    }
</script>
@endsection