<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Painel do Cliente - EcoCycle')</title>
    <link rel="stylesheet" href="{{ asset('/assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/charts.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    @yield('styles')
</head>
<body class="shell">
    @php
        $user = Auth::user();
        $displayName = $user?->nome ?? $user?->name ?? 'Usuário';
    @endphp

    <header class="topbar">
        <button class="topbar-hamburger" id="menuToggle" type="button" aria-label="Abrir menu">
            <span></span><span></span><span></span>
        </button>
        <div class="topbar-brand">EcoCycle <em>Cliente</em></div>
        <div class="topbar-user">{{ $displayName }}</div>
    </header>

    <div class="overlay" id="sidebarOverlay"></div>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-head">
            <div class="sidebar-logo">EcoCycle <span>Client</span><br><small>Painel inteligente</small></div>
            <button class="sidebar-x" id="closeMenu" type="button" aria-label="Fechar menu">✕</button>
        </div>
        <div class="sidebar-profile">
            <div class="avatar">{{ substr($displayName, 0, 1) }}</div>
            <div>
                <div class="profile-name">{{ $displayName }}</div>
                <div class="profile-role">{{ $user->email ?? 'Cliente EcoCycle' }}</div>
            </div>
        </div>
        <nav class="sidebar-nav">
    <div class="nav-group">Navegação</div>

    <a class="nav-link {{ request()->routeIs('cliente.home') ? 'active' : '' }}"
       href="{{ route('cliente.home') }}#graficos">
        Monitoramento
    </a>

    <a class="nav-link {{ request()->routeIs('cliente.configuracao*') ? 'active' : '' }}"
       href="{{ route('cliente.configuracao') }}">
        Configuração
    </a>

    <a class="nav-link {{ request()->routeIs('cliente.dispositivos*') ? 'active' : '' }}"
       href="{{ route('cliente.dispositivos') }}">
        Dispositivos
    </a>

    <a class="nav-link {{ request()->routeIs('cliente.historico*') ? 'active' : '' }}"
       href="{{ route('cliente.historico') }}">
        Históricos
    </a>

    <a class="nav-link {{ request()->routeIs('cliente.faq*') ? 'active' : '' }}"
       href="{{ route('cliente.faq') }}">
        FAQ & ajuda
    </a>

    <form action="{{ route('logout') }}" method="POST" class="nav-link logout" style="padding:0;">
        @csrf
        <button type="submit"
                class="nav-link logout"
                style="width:100%; border:none; text-align:left;">
            ↩ Sair
        </button>
    </form>
</nav>
    </aside>

    <main class="main">
        @if(session('success'))
            <div class="flash flash-ok">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="flash flash-err">{{ $errors->first() }}</div>
        @endif
        <section class="main-body">
            @yield('content')
        </section>
        

        <script src="{{ asset('/assets/js/script.js') }}"></script>
        @yield('scripts')
    </main>

</body>
</html>