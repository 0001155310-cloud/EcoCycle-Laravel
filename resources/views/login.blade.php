@extends('layout')
@section('title', 'Login/Cadastro - EcoCycle')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
@endsection

@section('content')
    <main class="page-hero">
        <div class="container">
            @if(session('success'))
                <div class="notice">{{ session('success') }}</div>
            @endif

            <div class="banner-section">
                <img src="{{ asset('assets/img/logo.jpg') }}" alt="EcoCycle Banner" class="banner-image">
            </div>

            <div class="grid-2">
                <!-- LOGIN -->
                <section class="page-panel">
                    <span class="kicker">Já tenho conta</span>
                    <h2>Login</h2>

                    <form action="{{ route('login.post') }}" method="POST" class="list">
                        @csrf
                        <label>
                            Email
                            <input required type="email" name="email" placeholder="voce@email.com" value="{{ old('email') }}" />
                        </label>

                        <label>
                            Senha
                            <input required type="password" name="senha" placeholder="Digite sua senha" />
                        </label>

                        <button class="btn btn-primary" type="submit">Entrar</button>
                    </form>
                </section>

                <!-- CADASTRO -->
                <section class="page-panel">
                    <span class="kicker">Novo por aqui?</span>
                    <h2>Cadastro</h2>

                    <form action="{{ route('cadastro') }}" method="POST" class="list">
                        @csrf
                        <label>
                            Nome
                            <input required type="text" name="nome" placeholder="Seu nome completo" value="{{ old('nome') }}" />
                        </label>

                        <label>
                            Email
                            <input required type="email" name="email" placeholder="voce@email.com" value="{{ old('email') }}" />
                        </label>

                        <label>
                            Senha
                            <input required type="password" name="password" placeholder="Digite sua senha" />
                        </label>

                        <label>
                            Confirmar senha
                            <input required type="password" name="password_confirmation" placeholder="Repita sua senha" />
                        </label>

                        <label style="display:flex; gap:10px; align-items:flex-start;">
                            <input required type="checkbox" name="termos" style="width:18px; height:18px; margin-top:2px;" />
                            <span class="small">Aceito os termos de uso</span>
                        </label>

                        <button class="btn btn-primary" type="submit">Cadastrar</button>
                    </form>
                </section>
            </div>
        </div>
    </main>
@endsection