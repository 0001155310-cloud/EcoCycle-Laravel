@extends('Admin.layout_admin')
@section('title', 'Monitoramento Avançado ESG & Business Intelligence')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<section style="padding: 2rem; background-color: #f8fafc; min-height: 100vh; font-family: system-ui, -apple-system, sans-serif;">
    
    <div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center; background: #ffffff; padding: 1.5rem 2rem; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03); border: 1px solid #e2e8f0;">
        <div>
            <h2 style="color: #0f172a; font-weight: 800; margin: 0; font-size: 1.75rem; letter-spacing: -0.02em;">Centro de Comando de Sustentabilidade & Viabilidade Financeira</h2>
            <p style="color: #64748b; font-size: 0.95rem; margin: 0.35rem 0 0 0;">Dados integrados com auditoria ESG, economia circular e balanço econômico operacional.</p>
        </div>
        <div style="display: flex; gap: 1.25rem; align-items: center;">
            <div id="badge-conexao" style="display: flex; align-items: center; gap: 0.6rem; background: #fef2f2; padding: 10px 16px; border-radius: 10px; border: 1px solid #fee2e2; transition: all 0.3s ease;">
                <div id="luz-conexao" style="width: 10px; height: 10px; background: #ef4444; border-radius: 50%; animation: pulse 2s infinite;"></div>
                <span style="font-size: 0.8rem; font-weight: 800; color: #991b1b; letter-spacing: 0.05em;" id="status-conexao">CONECTANDO...</span>
            </div>
            <a href="{{ route('admin.home') }}" style="background: #0f172a; color: #ffffff; font-weight: 600; font-size: 0.9rem; padding: 11px 20px; border-radius: 10px; text-decoration: none; box-shadow: 0 4px 6px -1px rgba(15,23,42,0.15); transition: background 0.2s;">Painel Principal</a>
        </div>
    </div>

    <div style="margin-bottom: 1rem; font-weight: 700; color: #475569; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.075em; border-left: 4px solid #10b981; padding-left: 0.5rem;">Indicadores Ambientais e de Economia Circular (Metas ESG)</div>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.25rem; margin-bottom: 2.5rem;">
        
        <div style="background: #ffffff; padding: 1.5rem; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
            <span style="color: #64748b; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">Aproveitamento de Orgânicos</span>
            <h4 style="font-size: 2rem; font-weight: 800; color: #0f172a; margin: 0.35rem 0;" id="val-aproveitamento">0%</h4>
            <div style="width: 100%; background: #f1f5f9; height: 8px; border-radius: 9999px; margin-top: 0.75rem; overflow: hidden; border: 1px solid #e2e8f0;">
                <div id="barra-aproveitamento" style="width: 0%; background: linear-gradient(90deg, #10b981, #059669); height: 100%; transition: width 1.2s cubic-bezier(0.4, 0, 0.2, 1);"></div>
            </div>
            <p style="font-size: 0.75rem; color: #64748b; margin: 0.75rem 0 0 0;">Resíduos desviados de aterros industriais.</p>
        </div>

        <div style="background: #ffffff; padding: 1.5rem; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
            <span style="color: #64748b; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">Gases de Efeito Estufa (GEE)</span>
            <h4 style="font-size: 2rem; font-weight: 800; color: #0f172a; margin: 0.35rem 0;" id="val-co2">0 kg</h4>
            <p style="font-size: 0.75rem; color: #10b981; margin: 0.75rem 0 0 0; font-weight: 600;">Carbono total mitigado (CO₂e).</p>
        </div>

        <div style="background: #ffffff; padding: 1.5rem; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
            <span style="color: #64748b; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">Pureza do Composto Final</span>
            <h4 style="font-size: 2rem; font-weight: 800; color: #0f172a; margin: 0.35rem 0;" id="val-pureza">0%</h4>
            <p style="font-size: 0.75rem; color: #64748b; margin: 0.75rem 0 0 0;">Isenção de plásticos, metais e inertes.</p>
        </div>

        <div style="background: #ffffff; padding: 1.5rem; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
            <span style="color: #64748b; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">Conformidade Regulatória</span>
            <h4 style="font-size: 1.4rem; font-weight: 800; color: #0f172a; margin: 0.65rem 0;" id="val-auditoria">Verificando...</h4>
            <p style="font-size: 0.75rem; color: #64748b; margin: 0 0 0 0;">Padrão em linha com auditorias ambientais.</p>
        </div>
    </div>

    <div style="margin-bottom: 1rem; font-weight: 700; color: #475569; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.075em; border-left: 4px solid #3b82f6; padding-left: 0.5rem;">Desempenho Econômico e Otimização Operacional</div>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.75rem; margin-bottom: 2.5rem;">
        
        <div style="background: #ffffff; border-radius: 16px; padding: 1.75rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02); border: 1px solid #e2e8f0;">
            <h4 style="font-size: 1.1rem; font-weight: 700; color: #0f172a; margin: 0 0 1.25rem 0;">Retorno do Investimento e Custos Evitados</h4>
            
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
                <div style="padding: 1rem; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                    <span style="display: block; font-size: 0.7rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.02em;">Triagem Mecânica</span>
                    <strong style="font-size: 1.25rem; color: #0f172a; display: block; margin-top: 0.35rem;" id="val-triagem">R$ 0,00</strong>
                    <span style="font-size: 0.65rem; color: #64748b; display: block; margin-top: 0.25rem;">Otimização de mão de obra</span>
                </div>
                <div style="padding: 1rem; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                    <span style="display: block; font-size: 0.7rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.02em;">Logística Reversa</span>
                    <strong style="font-size: 1.25rem; color: #0f172a; display: block; margin-top: 0.35rem;" id="val-descarte">R$ 0,00</strong>
                    <span style="font-size: 0.65rem; color: #64748b; display: block; margin-top: 0.25rem;">Custos de descarte mitigados</span>
                </div>
                <div style="padding: 1rem; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                    <span style="display: block; font-size: 0.7rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.02em;">Valor Ativo Composto</span>
                    <strong style="font-size: 1.25rem; color: #10b981; display: block; margin-top: 0.35rem;" id="val-receita">R$ 0,00</strong>
                    <span style="font-size: 0.65rem; color: #64748b; display: block; margin-top: 0.25rem;">Patrimônio de subprodutos</span>
                </div>
            </div>
            
            <div style="width: 100%; height: 260px; position: relative;">
                <canvas id="graficoFinanceiro"></canvas>
            </div>
        </div>

        <div style="background: #ffffff; border-radius: 16px; padding: 1.75rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02); border: 1px solid #e2e8f0;">
            <h4 style="font-size: 1.1rem; font-weight: 700; color: #0f172a; margin: 0 0 1.25rem 0;">Fluxo Metrológico de Resíduos (Massa)</h4>
            <div style="display: flex; justify-content: space-between; margin-bottom: 1.5rem; font-size: 0.85rem; background: #f8fafc; padding: 12px 16px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <span style="color: #475569; font-weight: 600;">Rastreabilidade da Cadeia de Fornecimento:</span>
                <strong style="color: #0f172a;" id="val-fornecedor">Buscando fornecedor logístico...</strong>
            </div>
            <div style="width: 100%; height: 290px; position: relative;">
                <canvas id="graficoVolumetrico"></canvas>
            </div>
        </div>
    </div>

    <div style="margin-bottom: 1rem; font-weight: 700; color: #475569; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.075em; border-left: 4px solid #0f172a; padding-left: 0.5rem;">Diagnóstico Físico do Processamento Técnico</div>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.25rem;">
        <div style="background: #0f172a; color: #ffffff; padding: 1.5rem; border-radius: 14px; border: 1px solid #1e293b;">
            <span style="font-size: 0.75rem; color: #94a3b8; text-transform: uppercase; font-weight: 700; letter-spacing: 0.05em;">Vazão Operacional</span>
            <div style="font-size: 1.6rem; font-weight: 800; margin-top: 0.5rem; color: #f8fafc;" id="val-velocidade">0 un/min</div>
        </div>
        <div style="background: #0f172a; color: #ffffff; padding: 1.5rem; border-radius: 14px; border: 1px solid #1e293b;">
            <span style="font-size: 0.75rem; color: #94a3b8; text-transform: uppercase; font-weight: 700; letter-spacing: 0.05em;">Temperatura Biológica</span>
            <div style="font-size: 1.6rem; font-weight: 800; margin-top: 0.5rem; color: #f8fafc;" id="val-temperatura">0 °C</div>
        </div>
        <div style="background: #0f172a; color: #ffffff; padding: 1.5rem; border-radius: 14px; border: 1px solid #1e293b;">
            <span style="font-size: 0.75rem; color: #94a3b8; text-transform: uppercase; font-weight: 700; letter-spacing: 0.05em;">Umidade Relativa</span>
            <div style="font-size: 1.6rem; font-weight: 800; margin-top: 0.5rem; color: #f8fafc;" id="val-umidade">0%</div>
        </div>
        <div style="background: #0f172a; color: #ffffff; padding: 1.5rem; border-radius: 14px; border: 1px solid #1e293b;">
            <span style="font-size: 0.75rem; color: #94a3b8; text-transform: uppercase; font-weight: 700; letter-spacing: 0.05em;">Contaminação Interceptada</span>
            <div style="font-size: 1.6rem; font-weight: 800; color: #f87171; margin-top: 0.5rem;" id="val-contaminantes">0 kg</div>
        </div>
    </div>
</section>

<style>
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: .4; }
    }
</style>

<script>
    // Configurações Gráfico Financeiro
    const ctxFin = document.getElementById('graficoFinanceiro').getContext('2d');
    let chartFin = new Chart(ctxFin, {
        type: 'line',
        data: {
            labels: [],
            datasets: [
                { 
                    label: 'Custos Evitados (R$)', 
                    data: [], 
                    borderColor: '#3b82f6', 
                    backgroundColor: 'rgba(59,130,246,0.06)', 
                    fill: true, 
                    tension: 0.3,
                    borderWidth: 2.5,
                    pointBackgroundColor: '#3b82f6'
                },
                { 
                    label: 'Valorização do Composto (R$)', 
                    data: [], 
                    borderColor: '#10b981', 
                    backgroundColor: 'transparent', 
                    tension: 0.3,
                    borderWidth: 2.5,
                    pointBackgroundColor: '#10b981'
                }
            ]
        },
        options: { 
            responsive: true, 
            maintainAspectRatio: false, 
            plugins: { legend: { labels: { boxWidth: 12, font: { family: 'system-ui', size: 11 } } } },
            scales: { 
                y: { grid: { color: '#f1f5f9' }, ticks: { font: { size: 11 } } }, 
                x: { grid: { display: false }, ticks: { font: { size: 11 } } } 
            } 
        }
    });

    // Configurações Gráfico Volumétrico (Massa de Destinação)
    const ctxVol = document.getElementById('graficoVolumetrico').getContext('2d');
    let chartVol = new Chart(ctxVol, {
        type: 'bar',
        data: {
            labels: ['Massa Recebida', 'Massa Biotransformada', 'Inertes Retidos'],
            datasets: [{
                label: 'Massa Acumulada (Kg)',
                data: [0, 0, 0],
                backgroundColor: ['#64748b', '#10b981', '#ef4444'],
                borderRadius: 8,
                barThickness: 45
            }]
        },
        options: { 
            responsive: true, 
            maintainAspectRatio: false, 
            plugins: { legend: { display: false } },
            scales: { 
                y: { grid: { color: '#f1f5f9' }, beginAtZero: true, ticks: { font: { size: 11 } } },
                x: { grid: { display: false }, ticks: { font: { size: 11 } } }
            } 
        }
    });

    const formatBRL = (v) => new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(v);

    async function atualizarDadosPlanta() {
        try {
            const res = await fetch("{{ route('admin.api.estacao.latest') }}");
            if (!res.ok) throw new Error("Erro de infraestrutura HTTP");
            const payload = await res.json();

            if (payload.ok && payload.data) {
                const d = payload.data;

                // Visual de Sucesso Conexão Estável
                const badge = document.getElementById('badge-conexao');
                badge.style.background = "#f0fdf4"; 
                badge.style.borderColor = "#bbf7d0";
                document.getElementById('luz-conexao').style.background = "#10b981";
                const status = document.getElementById('status-conexao');
                status.innerText = "SISTEMA ONLINE"; 
                status.style.color = "#166534";

                // Atualizações de Telemetria Ambiental
                document.getElementById('val-aproveitamento').innerText = d.percentual_aproveitamento + '%';
                document.getElementById('barra-aproveitamento').style.width = d.percentual_aproveitamento + '%';
                document.getElementById('val-co2').innerText = d.co2_evitado_kg.toLocaleString() + ' kg';
                document.getElementById('val-pureza').innerText = d.pureza_composto_percentual + '%';
                document.getElementById('val-auditoria').innerText = d.conformidade_auditoria ? '100% CONFORME' : 'NÃO CONFORME';

                // Atualizações Econômicas
                document.getElementById('val-triagem').innerText = formatBRL(d.custo_triagem_economizado);
                document.getElementById('val-descarte').innerText = formatBRL(d.custo_descarte_evitado);
                document.getElementById('val-receita').innerText = formatBRL(d.valor_gerado_composto);
                document.getElementById('val-fornecedor').innerText = d.fornecedor_origem;

                // Atualizações Técnicas do Dispositivo
                document.getElementById('val-velocidade').innerText = d.pecas_por_minuto + ' un/min';
                document.getElementById('val-temperatura').innerText = d.temperatura + ' °C';
                document.getElementById('val-umidade').innerText = d.umidade + '%';
                document.getElementById('val-contaminantes').innerText = d.contaminantes_rejeitados_kg + ' kg';

                // Alimentação Temporal do Gráfico de Tendências
                const horaAtual = new Date().toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
                if (chartFin.data.labels.length > 7) {
                    chartFin.data.labels.shift();
                    chartFin.data.datasets[0].data.shift();
                    chartFin.data.datasets[1].data.shift();
                }
                chartFin.data.labels.push(horaAtual);
                chartFin.data.datasets[0].data.push(d.custo_triagem_economizado + d.custo_descarte_evitado);
                chartFin.data.datasets[1].data.push(d.valor_gerado_composto);
                chartFin.update();

                // Atualização do Gráfico de Carga Volumétrica
                chartVol.data.datasets[0].data = [d.volume_recebido_kg, d.volume_aproveitado_kg, d.contaminantes_rejeitados_kg];
                chartVol.update();
            }
        } catch (e) {
            console.error("Falha no barramento de sincronização:", e);
            // Visual de Queda / Interrupção de Sinal
            const badge = document.getElementById('badge-conexao');
            badge.style.background = "#fef2f2"; 
            badge.style.borderColor = "#fee2e2";
            document.getElementById('luz-conexao').style.background = "#ef4444";
            const status = document.getElementById('status-conexao');
            status.innerText = "FALHA DE CONEXÃO"; 
            status.style.color = "#991b1b";
        }
    }

    setInterval(atualizarDadosPlanta, 5000);
    window.onload = atualizarDadosPlanta;
</script>
@endsection