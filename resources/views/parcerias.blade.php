@extends('layout')
@section('title', 'Parcerias - EcoCycle')

@section('content')
        <section class="partners-section">
            <article>
                <h2>Quem caminha conosco</h2>
                <p>Colaboramos com líderes de diversos setores para escalar o impacto ambiental positivo.</p>
            </article>

            <div class="partners-grid">
                <div class="partner-card">
                    <div class="partner-logo">🏢</div>
                    <h3>Redes de Varejo</h3>
                    <p>Implementação de logística reversa e gestão de resíduos orgânicos em supermercados.</p>
                </div>

                <div class="partner-card">
                    <div class="partner-logo">🌱</div>
                    <h3>Cooperativas Agrícolas</h3>
                    <p>Distribuição de biofertilizantes para pequenos e médios produtores rurais.</p>
                </div>

                <div class="partner-card">
                    <div class="partner-logo">🎓</div>
                    <h3>Instituições de Ensino</h3>
                    <p>Desenvolvimento de programas de educação ambiental e laboratórios vivos.</p>
                </div>

                <div class="partner-card">
                    <div class="partner-logo">🏗️</div>
                    <h3>Construtoras Verdes</h3>
                    <p>Integração de sistemas de compostagem em condomínios residenciais modernos.</p>
                </div>
            </div>
        </section>

        <section class="cta-section">
            <h2>Sua empresa quer ser parte da mudança?</h2>
            <p>Temos soluções B2B personalizadas para reduzir sua pegada de carbono e otimizar custos.</p>
            <a href="mailto:parcerias@ecocycle.com" class="btn-contact">Seja um Parceiro EcoCycle</a>
        </section>
@endsection