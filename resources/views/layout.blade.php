<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EcoCycle - Sustentabilidade')</title>
    <link rel="stylesheet" href="assets/css/app.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    @yield('styles')
</head>
<body>

    <header>
        <div class="header-content">
            <h1>EcoCycle</h1>
            <p>Plataforma de sustentabilidade e reciclagem</p>
        </div>
    </header>

    <nav>
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="/produtos">Produtos</a></li>
            <li><a href="/projetos">Projetos</a></li>
            <li><a href="/parcerias">Parcerias</a></li>
            <li><a href="/login">Login</a></li>
        </ul>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} EcoCycle. Todos os direitos reservados.</p>
    </footer>

    @yield('scripts')
</body>
</html>