@extends('layout')
@section('title', 'Parcerias - EcoCycle')

@section('content')
    <section class="intro-text">
        <h2>Quem caminha conosco</h2>
        <p>Colaboramos com líderes de diversos setores para escalar o impacto ambiental positivo.</p>
    </section>

    <section class="products-grid">
        <article class="product-card">
            <div class="product-info">
                <span class="tag">Redes de Varejo</span>
                <h4>Logística reversa</h4>
                <p>Implementação de logística reversa e gestão de resíduos orgânicos em supermercados.</p>
            </div>
        </article>

        <article class="product-card">
            <div class="product-info">
                <span class="tag">Cooperativas Agrícolas</span>
                <h4>Biofertilizantes sustentáveis</h4>
                <p>Distribuição de biofertilizantes para pequenos e médios produtores rurais.</p>
            </div>
        </article>

        <article class="product-card">
            <div class="product-info">
                <span class="tag">Instituições de Ensino</span>
                <h4>Educação ambiental</h4>
                <p>Desenvolvimento de programas de educação ambiental e laboratórios vivos.</p>
            </div>
        </article>

        <article class="product-card">
            <div class="product-info">
                <span class="tag">Construtoras Verdes</span>
                <h4>Compromisso com o verde</h4>
                <p>Integração de sistemas de compostagem em condomínios residenciais modernos.</p>
            </div>
        </article>
    </section>

    <section class="intro-text">
        <div style="background: var(--white); margin-top: 4rem; border-radius: 32px; padding: 3rem; text-align: center;">
            <h2>Sua empresa quer ser parte da mudança?</h2>
            <p>Temos soluções B2B personalizadas para reduzir sua pegada de carbono e otimizar custos.</p>
            <div class="button-wrapper" style="margin-top: 1.5rem;">
                <a href="mailto:parcerias@ecocycle.com" style="display: inline-flex; align-items: center; justify-content: center; gap: 0.6rem; background: var(--secondary-color); color: var(--white); padding: 0.95rem 2rem; border-radius: 999px; font-weight: 700; text-transform: uppercase; text-decoration: none; transition: var(--transition); border: 2px solid transparent; box-shadow: 0 12px 30px rgba(39, 174, 96, 0.25);">
                    Seja um Parceiro EcoCycle
                </a>
            </div>
        </div>
    </section>
@endsection