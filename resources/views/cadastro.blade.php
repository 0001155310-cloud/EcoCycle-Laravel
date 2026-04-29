<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - EcoCycle</title>
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
</head>
<body>
    <div class="video-page">
        <div class="video-bg">
            <video autoplay muted loop playsinline id="bg-video">
                <source src="{{ asset('assets/img/background.mp4') }}" type="video/mp4">
            </video>
        </div>

        <section class="login-wrapper">
            <div class="login-card">
            <div class="login-banner">
                <h2>Bem-vindo ao EcoCycle</h2>
                <p>Cadastre seus dados e faça parte da nossa comunidade. Use o mesmo estilo do login para garantir consistência.</p>
                <a class="btn-back" href="{{ route('home') }}">Voltar para início</a>
            </div>

            <div class="login-section">
                <h3>Cadastro de cliente</h3>

                @if(session('success'))
                    <div class="alert-box">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="alert-box">{{ session('error') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert-box">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('cadastro.post') }}" method="post">
                    @csrf

                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="senha">Senha</label>
                        <input type="password" id="senha" name="senha" required>
                    </div>

                    <div class="form-group">
                        <label for="tel">Telefone</label>
                        <input type="text" id="tel" name="tel" value="{{ old('tel') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="endereco">Endereço</label>
                        <input type="text" id="endereco" name="endereco" value="{{ old('endereco') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="estado">Estado (UF)</label>
                        <input type="text" id="estado" name="estado" value="{{ old('estado') }}" maxlength="2" required>
                    </div>

                    <div class="form-group">
                        <label for="cpf">CPF</label>
                        <input type="text" id="cpf" name="cpf" value="{{ old('cpf') }}" required>
                    </div>

                    <div class="btn-group">
                        <button type="submit" class="btn-primary">Cadastrar</button>
                        <a href="{{ route('login') }}" class="btn-secondary">Já tenho conta</a>
                    </div>
                </form>

                <div class="login-footer">
                    <p>Todos os dados são gravados diretamente na tabela <strong>clientes</strong> do banco <strong>ecocycle</strong>.</p>
                </div>
            </div>
        </div>
    </section>
    </div>
