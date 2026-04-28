@extends('layout')
@section('title', 'Produtos - EcoCycle')

@section('content')
        <section id="vitrine">
            <article>
                <h2>Soluções Sustentáveis</h2>
                <p>
                    Transforme sua rotina com nossos produtos focados em economia circular 
                    e regeneração do meio ambiente.
                </p>
            </article>

            <div class="products-grid">
                
                <div class="product-card">
                    <div class="product-image">
                        <img src="https://www.tribunapr.com.br/wp-content/uploads/2023/12/11112227/composteira.jpg" alt="Composteira Doméstica">
                    </div>
                    <div class="product-info">
                        <h4>Composteira Doméstica</h4>
                        <p>Solução prática para transformar resíduos orgânicos em adubo em sua cozinha.</p>
                        <span class="price">R$ 189,90</span>
                        <a href="#prod-1" class="btn-buy">Saber Mais</a>
                    </div>
                </div>

                <div class="product-card">
                    <div class="product-image">
                        <img src="https://www.assai.com.br/sites/default/files/sustentabilidade-assai-compostagem-como-transformar-residuos-em-adubo-banner-01.jpg" alt="Bio-Acelerador">
                    </div>
                    <div class="product-info">
                        <h4>Bio-Acelerador</h4>
                        <p>Mix biológico que reduz o tempo de decomposição e elimina odores.</p>
                        <span class="price">R$ 45,00</span>
                        <a href="#prod-2" class="btn-buy">Saber Mais</a>
                    </div>
                </div>

                <div class="product-card">
                    <div class="product-image">
                        <img src="https://www.portaldoagronegocio.com.br/img/cache/cover//storage/images/notices/64010b42e9550.jpg" alt="Adubo Premium">
                    </div>
                    <div class="product-info">
                        <h4>Adubo Premium</h4>
                        <p>Fertilizante 100% natural, rico em nutrientes para hortas e jardins.</p>
                        <span class="price">R$ 29,90</span>
                        <a href="#prod-3" class="btn-buy">Saber Mais</a>
                    </div>
                </div>

            </div>
        </section>

        <div id="prod-1" class="modal-overlay">
            <div class="modal-content">
                <a href="#" class="modal-close">&times;</a>
                <h4>Composteira Doméstica</h4>
                <hr>
                <p>Processamento higiênico e sem cheiro para restos de alimentos.</p>
                <ul>
                    <li>Capacidade: 15 Litros</li>
                    <li>Acompanha serragem e manual</li>
                    <li>Plástico reciclado BPA Free</li>
                </ul>
                
                <div class="button-cart-wrapper">
                    <a href="{{ route('login') }}" style="text-decoration: none;">
                        <button class="button-animated" data-tooltip="R$ 189,90">
                            <div class="text-btn">Comprar Agora!</div>
                            <div class="icon-btn">
                                <svg viewBox="0 0 24 24"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"></path></svg>
                            </div>
                        </button>
                    </a>
                </div>
            </div>
        </div>

        <div id="prod-2" class="modal-overlay">
            <div class="modal-content">
                <a href="#" class="modal-close">&times;</a>
                <h4>Bio-Acelerador</h4>
                <hr>
                <p>Microrganismos que aceleram a fermentação natural.</p>
                <ul>
                    <li>Até 20 ciclos de uso</li>
                    <li>100% Livre de químicos</li>
                    <li>Elimina moscas e odores</li>
                </ul>
                
                <div class="button-cart-wrapper">
                    <a href="{{ route('login') }}" style="text-decoration: none;">
                        <button class="button-animated" data-tooltip="R$ 45,00">
                            <div class="text-btn">Comprar Agora!</div>
                            <div class="icon-btn">
                                <svg viewBox="0 0 24 24"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"></path></svg>
                            </div>
                        </button>
                    </a>
                </div>
            </div>
        </div>

        <div id="prod-3" class="modal-overlay">
            <div class="modal-content">
                <a href="#" class="modal-close">&times;</a>
                <h4>Adubo Premium</h4>
                <hr>
                <p>Fertilizante rico em NPK natural para suas plantas.</p>
                <ul>
                    <li>Embalagem sustentável de 2kg</li>
                    <li>Nutrição de liberação lenta</li>
                    <li>Ideal para hortas urbanas</li>
                </ul>
                
                <div class="button-cart-wrapper">
                    <a href="{{ route('login') }}" style="text-decoration: none;">
                        <button class="button-animated" data-tooltip="R$ 29,90">
                            <div class="text-btn">Comprar Agora!</div>
                            <div class="icon-btn">
                                <svg viewBox="0 0 24 24"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"></path></svg>
                            </div>
                        </button>
                    </a>
                </div>
            </div>
        </div>
@endsection