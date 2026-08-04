
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoCycle - Sustentabilidade e Reciclagem</title>
    <link rel="stylesheet" href="/assets/css/home.css">
</head>

<body>
    <header class="hero">
        <div class="hero-glow hero-glow-1"></div>
        <div class="hero-glow hero-glow-2"></div>
        <div class="hero-orb hero-orb-1"></div>
        <div class="hero-orb hero-orb-2"></div>
        <div class="hero-orb hero-orb-3"></div>

        <div class="topbar">
            <a href="/" class="brand">Eco<span>Cycle</span></a>
            <nav class="nav-links">
                <a href="#home">Início</a>
                <a href="/produtos">Produtos</a>
                <a href="/projetos">Projetos</a>
                <a href="/parcerias">Parcerias</a>
                <a href="/login" class="nav-cta">Login</a>
            </nav>
        </div>

        <div class="hero-content">
            <div class="hero-copy">
                <span class="eyebrow">Sustentabilidade inteligente</span>
                <h1>Transforme resíduos em valor com tecnologia, eficiência e propósito.</h1>
                <p>Uma plataforma moderna para conectar compostagem, dados e impacto ambiental em um único ecossistema.</p>
                <div class="hero-actions">
                    <a href="/produtos" class="btn btn-primary">Conhecer soluções</a>
                    <a href="#about" class="btn btn-secondary">Nossa visão</a>
                </div>
                <ul class="hero-points">
                    <li>Monitoramento em tempo real</li>
                    <li>Processos mais limpos</li>
                    <li>Economia circular</li>
                </ul>
            </div>

            <div class="hero-card">
                <div class="hero-card-head">
                    <span class="dot"></span>
                    Sistema inteligente ativo
                </div>
                <div class="hero-card-grid">
                    <div>
                        <strong>+40%</strong>
                        <span>redução de desperdício</span>
                    </div>
                    <div>
                        <strong>24/7</strong>
                        <span>acompanhamento</span>
                    </div>
                    <div>
                        <strong>100%</strong>
                        <span>dados confiáveis</span>
                    </div>
                    <div>
                        <strong>Eco</strong>
                        <span>impacto real</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main>
        <section id="options-select" class="section-block">
            <div class="section-head">
                <div>
            
                <span class="eyebrow">Boas-vindas</span>
                <h2>Uma nova forma de pensar resíduos.</h2>
                <p>Bem-vindo à EcoCycle, sua plataforma de sustentabilidade e reciclagem, criada para transformar desperdício em oportunidade e impacto real.</p>
            </div>
            <div class="pill-list">
                <span>Monitoramento</span>
                <span>Inovação</span>
                <span>Reciclagem</span>
                <span>Eficiência</span>
            </div>
        </section>

        <section id="options-select" class="section-block">
            <div class="section-head">
                <div>
                    <span class="eyebrow">Explore a EcoCycle</span>
                    <h2>Áreas que conectam tecnologia e sustentabilidade.</h2>
                </div>
                <p>Selecione uma das frentes abaixo para conhecer nosso trabalho com mais profundidade.</p>
            </div>

            <div class="cards-container">
                <a href="/produtos" class="card-link">
                    <div class="card">
                        <img src="{{ asset('/assets/img/composteira.jpg') }}" alt="Produtos">
                        <div class="overlay">
                            <h4>Produtos</h4>
                            <p>Conheça soluções sustentáveis pensadas para o dia a dia.</p>
                        </div>
                    </div>
                </a>

                <a href="/projetos" class="card-link">
                    <div class="card">
                        <img src="{{ asset('/assets/img/adubo.jpg') }}" alt="Projetos">
                        <div class="overlay">
                            <h4>Projetos</h4>
                            <p>Veja iniciativas inovadoras que geram impacto real.</p>
                        </div>
                    </div>
                </a>

                <a href="/parcerias" class="card-link">
                    <div class="card">
                        <img src="{{ asset('/assets/img/parcerias.jpg') }}" alt="Parcerias">
                        <div class="overlay">
                            <h4>Parcerias</h4>
                            <p>Conheça nossos parceiros e a rede que sustenta o projeto.</p>
                        </div>
                    </div>
                </a>
            </div>
        </section>

        <section id="options-select" class="section-block">
            <div class="section-head">
                <div>
                <span class="eyebrow">Sobre nós</span>
                <h2>Construímos soluções para um futuro mais circular.</h2>
                <p>Somos uma iniciativa de inovação focada em transformar um dos maiores problemas ambientais da atualidade em uma oportunidade sustentável e economicamente viável: o desperdício de resíduos orgânicos.</p>
                <p>Nossa missão é desenvolver soluções tecnológicas acessíveis capazes de coletar dados a partir de restos de alimentos, resíduos agrícolas e subprodutos animais em recursos valiosos.</p>
            </div>

            <div class="info-card">
                <h3>Nossa visão</h3>
                <p>Contribuir para um futuro onde empresas e indústrias alimentícias possam tratar seus próprios resíduos de forma eficiente, reduzindo impactos e gerando valor.</p>
                <hr class="info-sep">
                <h3>O projeto</h3>
                <p>Unimos engenharia, sustentabilidade e economia circular em um sistema inteligente de compostagem industrial.</p>
            </div>
        </section>

        <section id="contact" class="contact-card section-block">
            <div>
                <span class="eyebrow">Contato</span>
                <h2>Fale com a equipe EcoCycle.</h2>
                <p>Entre em contato conosco pelo e-mail abaixo para conversar sobre soluções, parcerias ou suporte.</p>
            </div>
            <a href="mailto:ecocycle.company@gmail.com" class="btn btn-primary">Enviar e-mail</a>
        </section>
    </main>

    <footer>
        <p>&copy; 2026 EcoCycle. Todos os direitos reservados.</p>
    </footer>
</body>
</html>