@extends('layout')
@section('title', 'Projetos - EcoCycle')

@section('content')
        <section class="intro-text">
            <article>
                <h2>Inovação em Ação</h2>
                <p>Conheça as iniciativas onde aplicamos nossa tecnologia de economia circular para regenerar o meio ambiente.</p>
            </article>
        </section>

        <div class="projects-container">
            
            <article class="project-item">
                <div class="project-img">
                    <img src="https://www.assai.com.br/sites/default/files/sustentabilidade-assai-compostagem-como-transformar-residuos-em-adubo-banner-01.jpg" alt="Compostagem Industrial">
                </div>
                <div class="project-details">
                    <span class="tag">Industrial</span>
                    <h3>Compostagem em Larga Escala</h3>
                    <p>Implementação de sistemas automatizados em redes de varejo, transformando toneladas de descartes orgânicos diários.</p>
                    <div class="button-wrapper">
                        <a href="#modal-1" class="btn-open">Ver Detalhes</a>
                    </div>
                </div>
            </article>

            <article class="project-item">
                <div class="project-img">
                    <img src="https://www.portaldoagronegocio.com.br/img/cache/cover//storage/images/notices/64010b42e9550.jpg" alt="Biofertilizantes">
                </div>
                <div class="project-details">
                    <span class="tag">Campo</span>
                    <h3>Biofertilizantes Líquidos</h3>
                    <p>Desenvolvimento de uma linha de nutrientes orgânicos extraídos de processos fermentativos para alta produtividade.</p>
                    <div class="button-wrapper">
                        <a href="#modal-2" class="btn-open">Ver Detalhes</a>
                    </div>
                </div>
            </article>

            <article class="project-item">
                <div class="project-img">
                    <img src="https://www.tribunapr.com.br/wp-content/uploads/2023/12/11112227/composteira.jpg" alt="Educação Ambiental">
                </div>
                <div class="project-details">
                    <span class="tag">Educação</span>
                    <h3>Escolas Sustentáveis</h3>
                    <p>Projeto educativo que leva unidades de compostagem para dentro das escolas, ensinando o ciclo da vida.</p>
                    <div class="button-wrapper">
                        <a href="#modal-3" class="btn-open">Ver Detalhes</a>
                    </div>
                </div>
            </article>

        </div>

        <div id="modal-1" class="modal-overlay">
            <div class="modal-content">
                <a href="#" class="modal-close">&times;</a>
                <span class="tag">Industrial</span>
                <h3>Compostagem Industrial</h3>
                <hr>
                <p>Métricas de impacto e dados técnicos do varejo:</p>
                <ul>
                    <li>Redução de 40% na emissão de metano.</li>
                    <li>Produção de 5 toneladas de adubo/mês.</li>
                </ul>
            </div>
        </div>

        <div id="modal-2" class="modal-overlay">
            <div class="modal-content">
                <a href="#" class="modal-close">&times;</a>
                <span class="tag">Campo</span>
                <h3>Biofertilizantes</h3>
                <hr>
                <p>Dados de produtividade no campo:</p>
                <ul>
                    <li>Aumento de 15% na colheita orgânica.</li>
                    <li>Zero resíduos químicos no solo.</li>
                </ul>
            </div>
        </div>

        <div id="modal-3" class="modal-overlay">
            <div class="modal-content">
                <a href="#" class="modal-close">&times;</a>
                <span class="tag">Educação</span>
                <h3>Escolas Sustentáveis</h3>
                <hr>
                <p>Impacto educacional:</p>
                <ul>
                    <li>Mais de 50 escolas atendidas.</li>
                    <li>10.000 alunos conscientizados.</li>
                </ul>
            </div>
        </div>
@endsection