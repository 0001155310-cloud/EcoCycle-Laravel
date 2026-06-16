<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - EcoCycle')</title>
    <link rel="stylesheet" href="{{ asset('/assets_admin/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/charts.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    @yield('styles')
</head>
<body class="shell">
    @php
        $user = Auth::user();
        $displayName = $user?->nome ?? $user?->name ?? 'Administrador';
    @endphp

    <header class="topbar">
        <button class="topbar-hamburger" id="menuToggle" type="button" aria-label="Abrir menu">
            <span></span><span></span><span></span>
        </button>
        <div class="topbar-brand">EcoCycle <em>Admin</em></div>
        <div class="topbar-user">{{ $displayName }}</div>
    </header>

    <div class="overlay" id="sidebarOverlay"></div>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-head">
            <div class="sidebar-logo">EcoCycle <span>Admin</span><br><small>Console de operação</small></div>
            <button class="sidebar-x" id="closeMenu" type="button" aria-label="Fechar menu">✕</button>
        </div>
        <div class="sidebar-profile">
            <div class="avatar admin">AD</div>
            <div>
                <div class="profile-name">{{ $displayName }}</div>
                <div class="profile-role">{{ $user->email ?? 'Administrador EcoCycle' }}</div>
            </div>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-group">Operação</div>
            <a class="nav-link active" href="{{ route('admin.home') }}"> Dashboard</a>
            <a class="nav-link" href="{{ route('admin.vendas') }}"> Vendas</a>
            <a class="nav-link" href="{{ route('admin.clientes') }}"> Clientes</a>
            <a class="nav-link" href="{{ route('admin.historicos') }}"> Histórico</a>
            <a class="nav-link" href="{{ route('admin.rotas') }}"> Rotas</a>
            <form action="{{ route('logout') }}" method="POST" class="nav-link logout" style="padding:0;">
                @csrf
                <button type="submit" class="nav-link logout" style="width:100%; border:none; text-align:left;">↩ Sair</button>
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
    </main>

    <script src="{{ asset('assets/js/script.js') }}"></script>
    @yield('scripts')
</body>
</html>  