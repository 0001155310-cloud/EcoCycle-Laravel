@extends('Cliente.layout_cliente')

@section('title', 'FAQ & ajuda - EcoCycle')

@section('content')
<section class="dashboard-hero">
    <div class="dash-top">
        <div>
            <h2>FAQ &amp; ajuda</h2>
            <p>Respostas rápidas para configuração, aprovação de compra e suporte da conta.</p>
        </div>
        <span class="live-pill">Suporte</span>
    </div>

    <div class="projects-container">
        <article class="project-item full-width-card">
            <div class="chart-container full-chart-card">
                <span class="tag">Perguntas frequentes</span>
                <h3>Como usar a área do cliente</h3>
                <ul style="padding-left:1rem; display:grid; gap:0.6rem; color:var(--muted);">
                    <li>Use Configuração para editar seus dados e senha.</li>
                    <li>Use Compra &amp; aprovação para validar uma solicitação simulada.</li>
                    <li>Consulte Históricos para acompanhar as alterações recentes.</li>
                </ul>
            </div>
        </article>
    </div>
</section>
@endsection
