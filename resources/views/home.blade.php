
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoCycle - Sustentabilidade e Reciclagem</title>
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
</head>

<body>

    <header>
        <div class="header-content">
            <div class="leaf leaf-1"></div>
            <div class="leaf leaf-2"></div>
            <div class="leaf leaf-3"></div>
            <h1>Bem-vindo à EcoCycle</h1>
        </div>
    </header>

    <nav>
    <ul>
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropbtn">Home </a>
            <div class="dropdown-content">
                <a href="#home">Boas Vindas!</a>
                <a href="#about">Sobre Nós</a>
                <a href="#contact">Contatos</a>
            </div>
        </li>

        <li><a href="/produtos">Produtos</a></li>
        <li><a href="/projetos">Projetos</a></li>
        <li><a href="/parcerias">Parcerias</a></li>
        <li><a href="/login">Login</a></li>
    </ul>
</nav>

    <main>
        <section id="home">
            <article>
                <h2>Boas Vindas!</h2>
                <p>Bem-vindo à EcoCycle, sua plataforma de sustentabilidade e reciclagem!</p>
            </article>
        </section>

        <section id="options-select">
            <div class="options-header">
                <h2>Explore a EcoCycle</h2>
                <p>Selecione uma das áreas abaixo para conhecer nosso trabalho</p>
            </div>

            <div class="cards-container">
                <a href="/produtos" class="card-link">
                    <div class="card">
                        <img src="{{ asset('assets/img/composteira.jpg') }}" alt="Produtos">
                        <div class="overlay">
                            <h4>Produtos</h4>
                            <p>Conheça nossos produtos sustentáveis</p>
                        </div>
                    </div>
                </a>

                <a href="/projetos" class="card-link">
                    <div class="card">
                        <img src="{{ asset('assets/img/adubo.jpg') }}" alt="Projetos">
                        <div class="overlay">
                            <h4>Projetos</h4>
                            <p>Veja nossos projetos inovadores</p>
                        </div>
                    </div>
                </a>

                <a href="/parcerias" class="card-link">
                    <div class="card">
                        <img src="{{ asset('assets/img/parcerias.jpg') }}" alt="Parcerias">
                        <div class="overlay">
                            <h4>Parcerias</h4>
                            <p>Conheça nossos parceiros</p>
                        </div>
                    </div>
                </a>
            </div>
        </section>

        <section id="about">
            <article>
                <h2>Sobre Nós</h2>
                <p>
                    Somos uma iniciativa de inovação focada em transformar um dos maiores problemas ambientais
                    da atualidade em uma oportunidade sustentável e economicamente viável: o desperdício
                    de resíduos orgânicos.
                </p>

                <h3>Nossa Missão</h3>
                <p>
                    Nossa missão é desenvolver soluções tecnológicas acessíveis capazes de converter restos
                    de alimentos, resíduos agrícolas e subprodutos animais em recursos valiosos como
                    adubo orgânico, biofertilizante líquido e biogás.
                </p>

                <h3>O Projeto</h3>
                <p>
                    O projeto nasceu com o objetivo de unir engenharia, sustentabilidade e economia
                    circular em um único sistema inteligente de compostagem industrial.
                </p>

                <h3>Nossa Visão</h3>
                <p>
                    Nossa visão é contribuir para um futuro onde empresas e indústrias alimentícias possam 
                    tratar seus próprios resíduos de forma eficiente, reduzindo impactos e gerando valor.
                </p>
            </article>
        </section>

        <section id="contact">
            <article>
                <h2>Contatos</h2>
                <p>
                    Entre em contato conosco através do email:
                    <a href="mailto:ecocycle.company@gmail.com">ecocycle.company@gmail.com</a>
                </p>
            </article>
        </section>
    </main>

    <footer>
        <p>&copy; 2026 EcoCycle. Todos os direitos reservados.</p>
    </footer>

</body>
</html>