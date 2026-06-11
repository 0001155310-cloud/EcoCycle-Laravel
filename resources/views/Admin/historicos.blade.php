@extends('Admin.layout_admin')

@section('title', 'Histórico - EcoCycle')

@section('content')
<section class="dashboard-hero">
    <div class="dash-top">
        <div>
            <h2>Histórico</h2>
            <p>Registro administrativo das atividades principais da operação.</p>
        </div>
        <span class="live-pill">Log</span>
    </div>

    <div class="tcard">
        <div class="tcard-head"><h3>Últimas ações</h3></div>
        <div class="t-scroll">
            <table>
                <thead><tr><th>Data</th><th>Evento</th><th>Responsável</th></tr></thead>
                <tbody>
                    <tr><td>11/06/2026</td><td>Atualização de cliente</td><td>Admin</td></tr>
                    <tr><td>10/06/2026</td><td>Aprovação de compra</td><td>Admin</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
