@extends('Cliente.layout_cliente')

@section('title', 'Históricos - EcoCycle')

@section('content')
<section class="dashboard-hero">
    <div class="dash-top">
        <div>
            <h2>Históricos</h2>
            <p>Consulte o histórico recente das operações e compras vinculadas à sua conta.</p>
        </div>
        <span class="live-pill">Central de histórico</span>
    </div>

    <div class="projects-container">
        <article class="project-item full-width-card">
            <div class="chart-container full-chart-card">
                <span class="tag">Registro</span>
                <h3>Histórico da conta</h3>
                <div class="tcard">
                    <div class="tcard-head"><h3>Últimas atividades</h3></div>
                    <div class="t-scroll">
                        <table>
                            <thead><tr><th>Data</th><th>Evento</th><th>Status</th></tr></thead>
                            <tbody>
                                <tr><td>11/06/2026</td><td>Atualização de dados</td><td><span class="bs bs-aprovado">Concluído</span></td></tr>
                                <tr><td>10/06/2026</td><td>Solicitação de aprovação</td><td><span class="bs bs-inspecao">Pendente</span></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </article>
    </div>
</section>
@endsection
