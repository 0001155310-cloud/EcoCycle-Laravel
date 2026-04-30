<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - EcoCycle')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    @yield('styles')
</head>
<body>

    <header>
        <div class="header-content">
            <h1>EcoCycle <span style="color: #f1c40f;">Admin</span></h1>
            <p>Painel de Gestão e Controle do Sistema</p>
        </div>
    </header>

        
    <nav>
        <ul>
            <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
            <li><a href="#">Vendas</a></li>
            <li><a href="#">Relatórios</a></li>
            <li><a href="#">Clientes</a></li>
            <li><a href="#">Produtos</a></li>
            <li>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-logout-admin">Sair do Console</button>
                </form>
            </li>
        </ul>
    </nav>

    <main>
        {{-- Mensagens de Sucesso/Erro comuns em Admin --}}
        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 15px; margin-bottom: 20px; border-radius: 8px; border: 1px solid #c3e6cb;">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} EcoCycle. Todos os direitos reservados.</p>
    </footer>

    @yield('scripts')
</body>
</html>