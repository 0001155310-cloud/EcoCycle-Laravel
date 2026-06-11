@extends('Cliente.layout_cliente')

@section('title', 'Configuração da Conta - EcoCycle')

@section('content')
<section class="dashboard-hero">
    <div class="dash-top">
        <div>
            <h2>Configuração da conta</h2>
            <p>Atualize seus dados de acesso e mantenha o perfil do cliente sempre alinhado com o banco.</p>
        </div>
        <span class="live-pill">Acesso: {{ $cliente->tipoAcesso->nome ?? 'cliente' }}</span>
    </div>

    <div class="projects-container">
        <article class="project-item full-width-card">
            <div class="chart-container full-chart-card">
                <span class="tag">Dados da conta</span>
                <h3>Editar username, e-mail e informações de contato</h3>
                <br></br>
                <form action="{{ route('cliente.configuracao.salvar') }}" method="POST" class="card-form" style="display:grid; gap:1rem;">
                    @csrf
                    <div style="display:grid; gap:0.75rem; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));">
                        <label style="display:grid; gap:0.35rem;">
                            <span>Nome de usuário</span>
                            <input type="text" name="nome" value="{{ old('nome', $cliente->nome) }}" required style="padding:0.75rem; border-radius:12px; border:1px solid #d8e6e4;">
                        </label>
                        <label style="display:grid; gap:0.35rem;">
                            <span>E-mail</span>
                            <input type="email" name="email" value="{{ old('email', $cliente->email) }}" required style="padding:0.75rem; border-radius:12px; border:1px solid #d8e6e4;">
                        </label>
                        <label style="display:grid; gap:0.35rem;">
                            <span>Telefone</span>
                            <input type="text" name="tel" value="{{ old('tel', $cliente->tel) }}" style="padding:0.75rem; border-radius:12px; border:1px solid #d8e6e4;">
                        </label>
                        <label style="display:grid; gap:0.35rem;">
                            <span>CPF</span>
                            <input type="text" name="cpf" value="{{ old('cpf', $cliente->cpf) }}" style="padding:0.75rem; border-radius:12px; border:1px solid #d8e6e4;">
                        </label>
                        <label style="display:grid; gap:0.35rem;">
                            <span>Endereço</span>
                            <input type="text" name="endereco" value="{{ old('endereco', $cliente->endereco) }}" style="padding:0.75rem; border-radius:12px; border:1px solid #d8e6e4;">
                        </label>
                        <label style="display:grid; gap:0.35rem;">
                            <span>Estado</span>
                            <input type="text" name="estado" value="{{ old('estado', $cliente->estado) }}" style="padding:0.75rem; border-radius:12px; border:1px solid #d8e6e4;">
                        </label>
                        <label style="display:grid; gap:0.35rem;">
                            <span>Nova senha</span>
                            <input type="password" name="password" style="padding:0.75rem; border-radius:12px; border:1px solid #d8e6e4;">
                        </label>
                        <label style="display:grid; gap:0.35rem;">
                            <span>Confirmar senha</span>
                            <input type="password" name="password_confirmation" style="padding:0.75rem; border-radius:12px; border:1px solid #d8e6e4;">
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-save">Salvar alterações</button>
                </form>
            </div>
        </article>
    </div>
</section>
@endsection
