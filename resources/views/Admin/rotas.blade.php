@extends('Admin.layout_admin')

@section('title', 'Rotas - EcoCycle')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

<style>
    /* Mantém o padrão de espaçamento do painel */
    .projects-container {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
        margin-top: 2rem;
    }

    .full-width-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    }

    /* Container do Mapa */
    #map {
        width: 100%;
        height: 480px; /* Altura ideal para visualização em desktops e notebooks */
        border-radius: 12px;
        border: 1px solid #cbd5e1;
        margin-top: 1rem;
        z-index: 1; /* Evita que o mapa sobreponha menus suspensos do painel */
    }

    @media (max-width: 768px) {
        .full-width-card {
            padding: 1rem !important;
        }
        #map {
            height: 320px; /* Compacta em telas mobile */
        }
    }
</style>
@endsection

@section('content')
<section class="dashboard-hero" style="padding: 1.5rem; background-color: #f8fafc;">
    <div class="dash-top" style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="color: #1e293b; font-weight: 700; margin-bottom: 0.25rem;">Rotas e Logística</h2>
            <p style="color: #64748b; font-size: 0.95rem;">Monitoramento das rotas e logística de coleta/distribuição do sistema EcoCycle.</p>
        </div>
        <span class="live-pill" style="background: #edf5f0; color: #16a34a; padding: 6px 12px; border-radius: 20px; font-weight: 600; font-size: 0.85rem;">Operação</span>
    </div>

    <div class="projects-container">
        <article class="full-width-card">
            <span class="tag" style="color: #64748b; font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Mapa Integrado</span>
            <h3 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin: 0.25rem 0 0.5rem 0;">Logística de Coleta em Tempo Real</h3>
            <p style="color: #64748b; font-size: 0.9rem;">Abaixo você confere os pontos ativos das estações de reciclagem e centrais operacionais.</p>
            
            <div id="map"></div>
        </article>
    </div>
</section>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
    // 1. Inicializa o mapa centralizado no Brasil (Lat: -15.78, Lng: -47.93) com zoom ajustado
    // Dica: Se sua operação for regional (ex: São Paulo), mude as coordenadas para [-23.55, -46.63] e aumente o zoom para 12
    const map = L.map('map').setView([-23.5505, -46.6333], 10); 

    // 2. Carrega a camada visual de mapas públicos do OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // 3. Exemplo Prático: Adicionando pontos fictícios de operação na região (Estações EcoCycle)
    const pontosColeta = [
        { nome: "Central de Distribuição EcoCycle", lat: -23.5505, lng: -46.6333, status: "Operacional" },
        { nome: "Estação Inteligente 01 - Jardins", lat: -23.5615, lng: -46.6623, status: "Coleta Necessária (85% Cheio)" },
        { nome: "Estação Inteligente 02 - Pinheiros", lat: -23.5670, lng: -46.7020, status: "Coleta Efetuada" }
    ];

    // 4. Percorre o array e renderiza os marcadores na tela com popups informativos
    pontosColeta.forEach(ponto => {
        L.marker([ponto.lat, ponto.lng])
            .addTo(map)
            .bindPopup(`
                <div style="font-family: sans-serif; font-size: 13px;">
                    <strong style="color: #1e293b;">${ponto.nome}</strong><br>
                    <span style="color: #16a34a; font-weight: 600;">Status: ${ponto.status}</span>
                </div>
            `);
    });
</script>
@endsection