<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoCycle - Sustentabilidade e Reciclagem</title>
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/png">
    <link rel="stylesheet" href="/assets/css/home.css">

    <style>
        /* ===================================================
           ESTILOS RESPONSIVOS PARA DISPOSITIVOS MÓVEIS
        =================================================== */
        
        /* Botão do Menu Hambúrguer (Oculto no Desktop) */
        .menu-toggle {
            display: none;
            flex-direction: column;
            justify-content: space-around;
            width: 30px;
            height: 25px;
            background: transparent;
            border: none;
            cursor: pointer;
            z-index: 1001; /* Garante que o botão fique acima de tudo */
            padding: 0;
            margin: 0; /* Remove margens que podem desalinhá-lo */
        }

        .menu-toggle span {
            width: 100%;
            height: 3px;
            background-color: #ffffff; /* Cor do ícone */
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        /* Regras para Celulares e Tablets (Até 768px) */
        @media (max-width: 768px) {
            
            /* --- CORREÇÃO DE ALINHAMENTO DA TOPBAR --- */
            .topbar {
                display: flex;
                justify-content: space-between; /* ESQUERDA (Logo) e DIREITA (Hambúrguer) */
                align-items: center; /* Alinhamento vertical centralizado perfeito */
                position: relative;
                padding: 1rem 1.5rem; /* Ajuste o padding conforme necessário */
                z-index: 1000;
                width: 100%; /* Garante que ocupe toda a largura */
                box-sizing: border-box; /* Inclui padding na largura total */
                /* Adicionei isso para garantir que não haja altura extra */
                min-height: auto; 
                margin-top: 0; 
            }

            /* Ajuste para o texto da marca (logo) */
            .topbar .brand {
                display: flex;
                align-items: center;
                margin: 0;
                padding: 0;
                /* Adicionei isso para garantir que o texto não tenha margem extra */
                line-height: 1; 
            }

            .menu-toggle {
                display: flex; /* Exibe o botão hamburguer no mobile */
                margin-left: auto; /* Força o botão para a direita se houver espaço */
                /* Adicionei isso para remover qualquer altura extra herdada */
                height: 20px; 
                align-self: center; /* Garante que o hambúrguer se centralize verticalmente */
            }
            /* ------------------------------------------- */

            .nav-links {
                display: none; /* Esconde o menu original */
                position: absolute;
                top: 100%; /* Cola logo abaixo da topbar */
                left: 0;
                width: 100%;
                background-color: rgba(15, 23, 42, 0.98); /* Fundo do menu mobile mais opaco */
                backdrop-filter: blur(10px);
                flex-direction: column;
                align-items: center;
                padding: 1.5rem 0;
                gap: 1.2rem;
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.5);
                
                /* --- A CORREÇÃO DE SOBREPOSIÇÃO ESTÁ AQUI --- */
                z-index: 9999; /* Valor muito alto para garantir sobreposição */
                /* ------------------------------------------- */
            }

            .nav-links.active {
                display: flex; /* Exibe ao clicar no menu */
            }

            /* Animação do botão do menu quando ativo */
            .menu-toggle.active span:nth-child(1) {
                transform: rotate(45deg) translate(5px, 5px);
            }
            .menu-toggle.active span:nth-child(2) {
                opacity: 0;
            }
            .menu-toggle.active span:nth-child(3) {
                transform: rotate(-45deg) translate(7px, -6px);
            }

            /* Ajustes no Hero para não quebrar */
            .hero-content {
                display: flex;
                flex-direction: column;
                padding: 2rem 1.5rem;
                gap: 2rem;
                position: relative;
                z-index: 1; /* Garante que o conteúdo do hero fique em uma camada baixa */
                /* Adicionei isso para garantir que o hero não sobreponha a topbar */
                margin-top: 0; 
            }

            .hero-copy h1 {
                font-size: 1.8rem;
                line-height: 1.3;
            }

            .hero-actions {
                display: flex;
                flex-direction: column;
                width: 100%;
                gap: 0.8rem;
            }

            .hero-actions .btn {
                width: 100%;
                text-align: center;
            }

            .hero-card-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 1rem;
            }

            /* Ajuste das Seções Gerais */
            .section-block {
                padding: 3rem 1.5rem !important;
            }

            .section-head {
                display: flex;
                flex-direction: column;
                gap: 1rem;
            }

            /* Cards de Produtos / Projetos / Parcerias em 1 Coluna */
            .cards-container {
                display: flex;
                flex-direction: column;
                gap: 1.5rem;
            }

            .card {
                width: 100%;
                height: auto;
                min-height: 250px;
            }

            .pill-list {
                display: flex;
                flex-wrap: wrap;
                gap: 0.5rem;
                margin-top: 1rem;
            }

            /* Seção de Contato e Info Card */
            .contact-card {
                display: flex;
                flex-direction: column;
                gap: 1.5rem;
                text-align: center;
            }

            .contact-card .btn {
                width: 100%;
            }
        }
    </style>
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
            
            <!-- Botão Menu Hambúrguer para Mobile -->
            <button class="menu-toggle" id="menuToggle" aria-label="Abrir Menu">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <nav class="nav-links" id="navLinks">
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
        <section id="welcome" class="section-block">
            <div class="section-head">
                <div>
                    <span class="eyebrow">Boas-vindas</span>
                    <h2>Uma nova forma de pensar resíduos.</h2>
                    <p>Bem-vindo à EcoCycle, sua plataforma de sustentabilidade e reciclagem, criada para transformar desperdício em oportunidade e impacto real.</p>
                </div>
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

        <section id="about" class="section-block">
            <div class="section-head">
                <div>
                    <span class="eyebrow">Sobre nós</span>
                    <h2>Construímos soluções para um futuro mais circular.</h2>
                    <p>Transformamos o desperdício de resíduos orgânicos em oportunidade. Por meio de tecnologia e análise de dados, desenvolvemos soluções acessíveis para converter restos de alimentos, resíduos agrícolas e subprodutos em recursos valiosos para a economia circular.</p>
                </div>
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

    <!-- SCRIPT PARA O MENU HAMBÚRGUER -->
    <script>
        const menuToggle = document.getElementById('menuToggle');
        const navLinks = document.getElementById('navLinks');

        menuToggle.addEventListener('click', () => {
            menuToggle.classList.toggle('active');
            navLinks.classList.toggle('active');
        });

        // Fecha o menu ao clicar em algum link
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', () => {
                menuToggle.classList.remove('active');
                navLinks.classList.remove('active');
            });
        });
    </script>
</body>

</html>