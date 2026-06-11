@extends('Admin.layout_admin')

@section('title', 'Rotas - EcoCycle')

@section('content')
<section class="dashboard-hero">
    <div class="dash-top">
        <div>
            <h2>Rotas</h2>
            <p>Monitoramento das rotas e logística de distribuição do sistema.</p>
        </div>
        <span class="live-pill">Operação</span>
    </div>

    <div class="projects-container">
        <article class="project-item full-width-card">
            <div class="chart-container full-chart-card">
                <span class="tag">Mapa</span>
                <h3>Rotas em andamento</h3>
                <p>Seção preparada para exibir mapa e logística futura da operação.</p>
            </div>
        </article>
    </div>
</section>
@endsection
