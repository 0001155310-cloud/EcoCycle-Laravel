<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebsiteController;
use App\Http\AdminController;
use App\Http\Controllers\Api\LeituraController; 





// routes/web.php

Route::get('/', [WebsiteController::class, 'home'])->name('home');
Route::get('/produtos', [WebsiteController::class, 'produtos'])->name('produtos');
Route::get('/projetos', [WebsiteController::class, 'projetos'])->name('projetos');
Route::get('/parcerias', [WebsiteController::class, 'parcerias'])->name('parcerias');
Route::get('/login', [WebsiteController::class, 'loginForm'])->name('login');
Route::post('/login', [WebsiteController::class, 'logar'])->name('login.post');
Route::post('/logout', [WebsiteController::class, 'deslogar'])->name('logout');
Route::get('/cadastro', [WebsiteController::class, 'cadastroForm'])->name('cadastro');
Route::post('/cadastro', [AdminController::class, 'salvarCliente'])->name('cadastro.post');
Route::get('/cliente', [WebsiteController::class, 'homeCliente'])->name('cliente.home');
Route::get('/cliente/configuracao', [WebsiteController::class, 'configuracaoCliente'])->name('cliente.configuracao');
Route::post('/cliente/configuracao', [WebsiteController::class, 'atualizarConfiguracao'])->name('cliente.configuracao.salvar');
Route::get('/cliente/historico', [WebsiteController::class, 'historicoCliente'])->name('cliente.historico');
Route::get('/cliente/faq', [WebsiteController::class, 'faqCliente'])->name('cliente.faq');
Route::get('/cliente/dispositivos', [WebsiteController::class, 'dispositivosCliente'])->name('cliente.dispositivos');
Route::get('/admin', [WebsiteController::class, 'homeAdmin'])->name('admin.home');
Route::get('/admin/clientes', [WebsiteController::class, 'adminClientes'])->name('admin.clientes');
Route::get('/admin/vendas', [WebsiteController::class, 'adminVendas'])->name('admin.vendas');
Route::get('/admin/historicos', [WebsiteController::class, 'adminHistoricos'])->name('admin.historicos');
Route::get('/admin/rotas', [WebsiteController::class, 'adminRotas'])->name('admin.rotas');
Route::get('/api/arduino/latest', [LeituraController::class, 'latest'])->name('arduino.latest');
Route::post('/admin/clientes/salvar', [AdminController::class, 'salvarCliente'])->name('admin.clientes.salvar');
Route::post('/admin/clientes/{id}/excluir', [AdminController::class, 'excluirCliente'])->name('admin.clientes.excluir');
Route::get('/arduino/latest', [LeituraController::class, 'latest'])->name('arduino.latest');