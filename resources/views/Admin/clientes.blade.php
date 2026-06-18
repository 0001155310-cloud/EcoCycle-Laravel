@extends('Admin.layout_admin')

@section('title', 'Clientes - EcoCycle')

@section('styles')
<style>
    .chart-container {
        position: relative;
    }
    
    .chart-container canvas {
        max-width: 100%;
    }
    
    @media (max-width: 768px) {
        .chart-container {
            padding: 1rem !important;
        }
        .projects-container {
            gap: 1rem !important;
        }
        .card-form {
            flex-direction: column !important;
        }
    }
</style>
@endsection

@section('content')

<section class="dashboard-hero">
    <div class="dash-top">
        <div>
            <h2>Clientes cadastrados</h2>
            <p>Consulta do banco de dados com nome, e-mail e nível de acesso dos clientes.</p>
        </div>
        <span class="live-pill">Banco de dados</span>
    </div>

    <form method="GET" class="card-form" style="display:grid; gap:1rem; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); margin-bottom:1rem;">
        <label style="display:grid; gap:0.35rem;">
            <span>Buscar</span>
            <input type="text" name="q" value="{{ old('q', $query ?? '') }}" placeholder="Nome ou e-mail" style="padding:0.75rem; border-radius:12px; border:1px solid #d8e6e4;" />
        </label>
        <label style="display:grid; gap:0.35rem;">
            <span>Tipo de acesso</span>
            <select name="tipo" style="padding:0.75rem; border-radius:12px; border:1px solid #d8e6e4; background:#fff;">
                <option value="">Todos</option>
                @foreach($tipos as $tipoItem)
                    <option value="{{ $tipoItem->id }}" @selected((string)($tipo ?? '') === (string)$tipoItem->id)>{{ $tipoItem->nome }}</option>
                @endforeach
            </select>
        </label>
        <div style="display:flex; align-items:end; gap:0.5rem;">
            <button type="submit" class="btn btn-primary btn-save">Aplicar filtros</button>
            <a href="{{ route('admin.clientes') }}" class="btn" style="background:#edf5f0; color:var(--primary);">Limpar</a>
        </div>
    </form>

    <div class="tcard">
        <div class="tcard-head"><h3>Lista de clientes</h3></div>
        <div class="t-scroll">
            <table>
                <thead>
                    <tr><th>ID</th><th>Nome</th><th>E-mail</th><th>Tipo</th></tr>
                </thead>
                <tbody>
                    @forelse($clientes as $cliente)
                        <tr>
                            <td>{{ $cliente->id }}</td>
                            <td>{{ $cliente->nome }}</td>
                            <td>{{ $cliente->email }}</td>
                            <td>{{ $cliente->tipoAcesso->nome ?? 'cliente' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4">Nenhum cliente encontrado.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    </section>

    <div class="projects-container">
        <article class="project-item"><div class="chart-container"><span class="tag">Clientes</span><h3>Distribuição por tipo</h3><canvas id="tipoChart"></canvas></div></article>
        <article class="project-item"><div class="chart-container"><span class="tag">Última leitura</span><h3>Leitura do banco</h3><canvas id="clienteReadChart"></canvas></div></article>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const latest = @json($latest ?? null);
    const tipoLabels = @json($tipos->pluck('nome'));
    const tipoData = @json($tipos->map(function ($tipo) use ($clientes) {
        return $clientes->where('tipo_acesso_id', $tipo->id)->count();
    })->values());

    new Chart(document.getElementById('tipoChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: tipoLabels,
            datasets: [{ 
                label: 'Clientes por tipo', 
                data: tipoData, 
                backgroundColor: ['#27ae60', '#1e5d3b'] 
            }]
        },
        options: { 
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    labels: { font: { size: window.innerWidth < 768 ? 11 : 12 } }
                }
            },
            scales: { 
                x: { ticks: { font: { size: window.innerWidth < 768 ? 10 : 11 } } },
                y: { ticks: { font: { size: window.innerWidth < 768 ? 10 : 11 } } }
            }
        }
    });

    new Chart(document.getElementById('clienteReadChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: ['Umidade', 'Temperatura', 'pH'],
            datasets: [{ 
                label: 'Última leitura', 
                data: [Number(latest?.umidade ?? 0), Number(latest?.temperatura ?? 0), Number(latest?.ph ?? 0)], 
                borderColor: '#27ae60', 
                backgroundColor: 'rgba(39,174,96,0.12)', 
                fill: true, 
                tension: 0.35,
                pointRadius: window.innerWidth < 768 ? 1 : 2
            }]
        },
        options: { 
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    labels: { font: { size: window.innerWidth < 768 ? 11 : 12 } }
                }
            },
            scales: { 
                x: { ticks: { font: { size: window.innerWidth < 768 ? 10 : 11 } } },
                y: { ticks: { font: { size: window.innerWidth < 768 ? 10 : 11 } } }
            }
        }
    });
</script>
@endsection
