@extends('Admin.layout_admin')

@section('title', 'Clientes - EcoCycle')

@section('styles')
<style>
    .t-scroll { width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }
    
    /* Crachá de identificação de níveis de acesso */
    .badge-role { padding: 4px 8px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; }
    .role-admin { background: #fee2e2; color: #b91c1c; }
    .role-client { background: #dcfce7; color: #15803d; }
    .role-default { background: #f1f5f9; color: #475569; }

    /* Contêiner estrutural dos Gráficos */
    .projects-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }

    .chart-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    }

    .chart-container {
        position: relative;
        width: 100%;
        height: 240px; /* Limita a altura máxima para manter a uniformidade */
    }
    
    @media (max-width: 768px) {
        .projects-container {
            grid-template-columns: 1fr;
            gap: 1rem !important;
        }
        .chart-card {
            padding: 1rem !important;
        }
    }
</style>
@endsection

@section('content')
<section class="dashboard-hero" style="padding: 1.5rem; background-color: #f8fafc;">
    <div class="dash-top" style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="color: #1e293b; font-weight: 700; margin-bottom: 0.25rem;">Clientes Cadastrados</h2>
            <p style="color: #64748b; font-size: 0.95rem;">Consulta do banco de dados com nome, e-mail e nível de acesso dos usuários.</p>
        </div>
        <span class="live-pill" style="background: #edf5f0; color: #16a34a; padding: 6px 12px; border-radius: 20px; font-weight: 600; font-size: 0.85rem;">Banco de Dados</span>
    </div>

    <form method="GET" class="card-form" style="display: grid; gap: 1rem; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); margin-bottom: 2rem; background: #ffffff; padding: 1.25rem; border-radius: 12px; border: 1px solid #e2e8f0;">
        <label style="display: grid; gap: 0.35rem; color: #475569; font-size: 0.9rem; font-weight: 600;">
            <span>Buscar</span>
            <input type="text" name="q" value="{{ old('q', $query ?? '') }}" placeholder="Nome ou e-mail" style="padding: 0.65rem 0.75rem; border-radius: 8px; border: 1px solid #cbd5e1; color: #334155;" />
        </label>
        
        <label style="display: grid; gap: 0.35rem; color: #475569; font-size: 0.9rem; font-weight: 600;">
            <span>Tipo de acesso</span>
            <select name="tipo" style="padding: 0.65rem 0.75rem; border-radius: 8px; border: 1px solid #cbd5e1; background: #fff; color: #334155;">
                <option value="">Todos</option>
                @foreach($tipos as $tipoItem)
                    <option value="{{ $tipoItem->id }}" @selected((string)($tipo ?? '') === (string)$tipoItem->id)>{{ $tipoItem->nome }}</option>
                @endforeach
            </select>
        </label>
        
        <div style="display: flex; align-items: flex-end; gap: 0.5rem;">
            <button type="submit" class="btn btn-primary btn-save" style="background: #16a34a; border: none; padding: 0.65rem 1.2rem; border-radius: 8px; color: #fff; font-weight: 600; cursor: pointer; width: 100%;">Aplicar filtros</button>
            <a href="{{ route('admin.clientes') }}" class="btn" style="background: #f1f5f9; color: #475569; padding: 0.65rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 600; text-align: center;">Limpar</a>
        </div>
    </form>

    <div class="tcard" style="background: #ffffff; border-radius: 16px; padding: 1.5rem; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
        <div class="tcard-head" style="margin-bottom: 1rem;"><h3 style="font-size: 1.1rem; font-weight: 700; color: #1e293b;">Lista de Usuários</h3></div>
        <div class="t-scroll">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 2px solid #f1f5f9; color: #64748b; font-size: 0.85rem; text-transform: uppercase;">
                        <th style="padding: 1rem 0.5rem;">ID</th>
                        <th style="padding: 1rem 0.5rem;">Nome</th>
                        <th style="padding: 1rem 0.5rem;">E-mail</th>
                        <th style="padding: 1rem 0.5rem;">Tipo</th>
                    </tr>
                </thead>
                <tbody style="color: #334155; font-size: 0.95rem;">
                    @forelse($clientes as $cliente)
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 1rem 0.5rem; font-weight: 600; color: #64748b;">#{{ $cliente->id }}</td>
                            <td style="padding: 1rem 0.5rem; font-weight: 600;">{{ $cliente->nome }}</td>
                            <td style="padding: 1rem 0.5rem; color: #475569;">{{ $cliente->email }}</td>
                            <td style="padding: 1rem 0.5rem;">
                                @php
                                    $roleName = strtolower($cliente->tipoAcesso->nome ?? 'cliente');
                                    $classRole = str_contains($roleName, 'admin') ? 'role-admin' : (str_contains($roleName, 'client') || str_contains($roleName, 'comum') ? 'role-client' : 'role-default');
                                @endphp
                                <span class="badge-role {{ $classRole }}">{{ $cliente->tipoAcesso->nome ?? 'Cliente' }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" style="padding: 2rem; text-align: center; color: #94a3b8;">Nenhum cliente encontrado.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="projects-container">
        <article class="chart-card">
            <span class="tag" style="color: #64748b; font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Métricas</span>
            <h3 style="font-size: 1.05rem; font-weight: 700; color: #1e293b; margin: 0.25rem 0 1rem 0;">Distribuição por Tipo</h3>
            <div class="chart-container">
                <canvas id="tipoChart"></canvas>
            </div>
        </article>
        
        <article class="chart-card">
            <span class="tag" style="color: #64748b; font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Última Leitura Real</span>
            <h3 style="font-size: 1.05rem; font-weight: 700; color: #1e293b; margin: 0.25rem 0 1rem 0;">Telemetria Geral do Sistema</h3>
            <div class="chart-container">
                <canvas id="clienteReadChart"></canvas>
            </div>
        </article>
    </div>
</section>
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
                label: 'Usuários Cadastrados', 
                data: tipoData, 
                backgroundColor: ['#16a34a', '#475569', '#0284c7'] 
            }]
        },
        options: { 
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: { 
                x: { grid: { display: false }, ticks: { color: '#64748b', font: { size: 11 } } },
                y: { grid: { color: '#f1f5f9' }, ticks: { color: '#64748b', font: { size: 11 }, precision: 0 } }
            }
        }
    });

    new Chart(document.getElementById('clienteReadChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: ['Umidade', 'Temperatura', 'pH'],
            datasets: [{ 
                label: 'Métricas Atuais', 
                data: [Number(latest?.umidade ?? 0), Number(latest?.temperatura ?? 0), Number(latest?.ph ?? 0)], 
                borderColor: '#16a34a', 
                backgroundColor: 'rgba(22,163,74,0.08)', 
                fill: true, 
                tension: 0.3,
                pointRadius: 4,
                pointBackgroundColor: '#16a34a'
            }]
        },
        options: { 
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: { 
                x: { grid: { display: false }, ticks: { color: '#64748b', font: { size: 11 } } },
                y: { grid: { color: '#f1f5f9' }, ticks: { color: '#64748b', font: { size: 11 } } }
            }
        }
    });
</script>
@endsection