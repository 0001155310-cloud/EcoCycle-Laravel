<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Painel do Cliente - EcoCycle')</title>
    {{-- Importante: Use asset() para garantir que o CSS carregue em qualquer rota --}}
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
 
    @yield('styles')

</head>
<body>

    <header>
        <div class="header-content">
            <h1>Olá, Cliente!</span></h1>
            <p>Bem-vindo à sua área exclusiva de sustentabilidade</p>
        </div>
    </header>

    @if(Auth::check())
    <div class="user-info">
        Conectado como: <strong>{{ Auth::user()->email }}</strong>
    </div>
    @endif

    <nav>
        <ul>
            {{-- As 3 Opções principais --}}
            <li><a href="{{ route('cliente.home') }}">Início</a></li>
            <li><a href="{{ route('cliente.home') }}#graficos">Monitoramento</a></li>
            <li><a href="{{ route('produtos') }}">Nova Compra</a></li>
            
            {{-- Opção de Logout via Formulário (Segurança do Laravel) --}}
            <li>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-logout">Sair</button>
                </form>
            </li>
        </ul>
    </nav>


        @yield('content')

    <footer>
        <p>&copy; {{ date('Y') }} EcoCycle. Todos os direitos reservados.</p>
    </footer>

    @yield('scripts')
</body>
</html>