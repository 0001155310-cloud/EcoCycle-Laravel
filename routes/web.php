<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\AdminController; // Corrigido o namespace que estava faltando o "Controllers"
use App\Http\Controllers\Api\LeituraController; 

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rotas Institucionais / Públicas
Route::get('/', [WebsiteController::class, 'home'])->name('home');
Route::get('/produtos', [WebsiteController::class, 'produtos'])->name('produtos');
Route::get('/projetos', [WebsiteController::class, 'projetos'])->name('projetos');
Route::get('/parcerias', [WebsiteController::class, 'parcerias'])->name('parcerias');

// Autenticação (Login / Logout)
Route::get('/login', [WebsiteController::class, 'loginForm'])->name('login');
Route::post('/login', [WebsiteController::class, 'logar'])->name('login.post');
Route::post('/logout', [WebsiteController::class, 'deslogar'])->name('logout');

// Cadastro Inicial
Route::get('/cadastro', [WebsiteController::class, 'cadastroForm'])->name('cadastro');
Route::post('/cadastro', [AdminController::class, 'salvarCliente'])->name('cadastro.post');

// Painel do Cliente (Escopo do Usuário Comum)
Route::get('/cliente', [WebsiteController::class, 'homeCliente'])->name('cliente.home');
Route::get('/cliente/configuracao', [WebsiteController::class, 'configuracaoCliente'])->name('cliente.configuracao');
Route::post('/cliente/configuracao', [WebsiteController::class, 'atualizarConfiguracao'])->name('cliente.configuracao.salvar');
Route::get('/cliente/historico', [WebsiteController::class, 'historicoCliente'])->name('cliente.historico');
Route::get('/cliente/faq', [WebsiteController::class, 'faqCliente'])->name('cliente.faq');
Route::get('/cliente/dispositivos', [WebsiteController::class, 'dispositivosCliente'])->name('cliente.dispositivos');

// Endpoints de Integração com o Arduino (API Externa do Sistema)
Route::get('/api/arduino/latest', [LeituraController::class, 'latest'])->name('arduino.latest');
Route::get('/api/arduino/live', [LeituraController::class, 'live'])->name('arduino.live');


// PAINEL DO ADMIN (Grupo organizado com prefixos automáticos)
Route::prefix('admin')->name('admin.')->group(function () {
    
    // URLs geradas automaticamente: /admin, /admin/clientes, etc.
    Route::get('/', [WebsiteController::class, 'homeAdmin'])->name('home');
    Route::get('/clientes', [WebsiteController::class, 'adminClientes'])->name('clientes');
    Route::post('/clientes/salvar', [AdminController::class, 'salvarCliente'])->name('clientes.salvar');
    Route::post('/clientes/{id}/excluir', [AdminController::class, 'excluirCliente'])->name('clientes.excluir');
    Route::get('/vendas', [WebsiteController::class, 'adminVendas'])->name('vendas');
    Route::get('/historicos', [WebsiteController::class, 'adminHistoricos'])->name('historicos');
    Route::get('/rotas', [WebsiteController::class, 'adminRotas'])->name('rotas');

    // Tela de Informações específicas e detalhadas da Estação (URL: /admin/estacao/detalhes | Nome: admin.estacao.detalhes)
    Route::get('/estacao/detalhes', [WebsiteController::class, 'adminEstacaoDetalhes'])->name('estacao.detalhes');
    Route::put('/estacao/update-limites/{id}', [WebsiteController::class, 'updateLimites'])->name('estacao.update-limites');

    // API interna de atualização do Dashboard (URL: /admin/api/estacao/latest | Nome: admin.api.estacao.latest)
    Route::get('/api/estacao/latest', [WebsiteController::class, 'arduinoLatest'])->name('api.estacao.latest');

});