<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - EcoCycle</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
    
    <style>
        /* Remove this inline background when using video */
    </style>
</head>
<body>
    <div class="video-page">
        <div class="video-bg">
            <video autoplay muted loop playsinline id="bg-video">
                <source src="{{ asset('assets/img/background.mp4') }}" type="video/mp4">
            </video>
        </div>

        <main class="login-wrapper">
            <div class="login-card">
            
            <aside class="login-banner">
                <div class="banner-content">
                    <h2>Olá, <br>Bem-vindo!</h2>
                    <p>Conecte-se à EcoCycle para continuar sua jornada sustentável e transformar o planeta.</p>
                    <a href="{{ url('/') }}" class="btn-back">Voltar</a>
                </div>
            </aside>

            <section class="login-section">
                <h3>Aceder à Conta</h3>

                @if($errors->any() || session('error'))
                    <div class="alert-box">
                        @if(session('error'))
                            <p>{{ session('error') }}</p>
                        @endif
                        @foreach($errors->all() as $error)
                            <p>• {{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input id="email" type="email" name="email" placeholder="exemplo@email.com" required value="{{ old('email') }}">
                    </div>

                    <div class="form-group">
                        <label for="senha">Senha</label>
                        <input id="senha" type="password" name="senha" placeholder="Digite sua senha aqui..." required>
                    </div>

                    <div class="form-helper">
                        <a href="#">Esqueceu a senha?</a>
                    </div>

                    <div class="btn-group">
                        <button type="submit" class="btn-primary">Entrar</button>
                        <a href="{{ route('cadastro') }}" class="btn-secondary">Criar nova conta</a>
                    </div>
                </form>

                <footer class="login-footer">
                    <p>EcoCycle © 2026</p>
                </footer>
            </section>

        </div>
    </main>
</body>
</html>