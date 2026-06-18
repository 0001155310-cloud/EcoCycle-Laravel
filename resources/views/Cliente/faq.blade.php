@extends('Cliente.layout_cliente')

@section('title', 'FAQ & ajuda - EcoCycle')

@section('content')
<section class="dashboard-hero">
    <div class="dash-top">
        <div>
            <h2>FAQ &amp; ajuda</h2>
            <p>Respostas rápidas para configuração, aprovação de compra e suporte da conta.</p>
        </div>
        <span class="live-pill">Suporte</span>
    </div>

    <div class="projects-container">
        <article class="project-item full-width-card">
            <div class="chart-container full-chart-card">
                <span class="tag">Dispositivos EcoCycle</span>
                <h3>Como cadastrar um dispositivo novo?</h3>
                <ul style="padding-left:1rem; padding-top:1rem; display:grid; gap:0.6rem; color:var(--muted);">
                    <li>Entre em contato com o suporte para solicitar a adição do dispositivo à sua conta.</li>
                    <li>Forneça o número de série ou identificação do dispositivo para vinculação.</li>
                    <li>Após a confirmação, o dispositivo aparecerá na seção de dados dos dispositivos conectados.</li>
                </ul>
            </div>
        </article>
    </div>

    <div class="projects-container">
        <article class="project-item full-width-card">
            <div class="chart-container full-chart-card">
                <span class="tag">Recuperação de Conta</span>
                <h3>Como recuperar minha conta?</h3>
                <ul style="padding-left:1rem; padding-top:1rem; display:grid; gap:0.6rem; color:var(--muted);">
                    <li>Entre em contato com o suporte para solicitar a recuperação da sua conta. Você pode fazer isso clicando no link "<a href="/login"><strong>Esqueci minha senha</strong></a>"".</li>
                    <li>Forneça as informações necessárias para verificar sua identidade, como nome completo e endereço de email.</li>
                    <li>Após a confirmação, um email de recuperação será enviado para o seu endereço de email.</li>
                </ul>
            </div>
        </article>
    </div>

    <div class="projects-container">
        <article class="project-item full-width-card">
            <div class="chart-container full-chart-card">
                <span class="tag">Falha na atualização</span>
                <h3>Meus dados não estão atualizados!</h3>
                <ul style="padding-left:1rem; padding-top:1rem; display:grid; gap:0.6rem; color:var(--muted);">
                    <li>Verifique se o dispositivo está conectado corretamente ao computador.</li>
                    <li>Reinicie o dispositivo e tente novamente; normalmente o erro ocorre quando há problemas de conexão.</li>
                    <li>Caso o problema persista, entre em contato com o suporte para obter assistência adicional.</li>
                    <li><a href="mailto:suporte@ecocycle.com"><strong>Entre em contato com o suporte</strong></a> para obter assistência adicional.</li>
                </ul>
            </div>
        </article>
    </div>
</section>
@endsection
