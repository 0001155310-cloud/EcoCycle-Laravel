<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\AdminController;

// routes/web.php

Route::get('/', [WebsiteController::class, 'home'])->name('home');
Route::get('/produtos', [WebsiteController::class, 'produtos'])->name('produtos');
Route::get('/projetos', [WebsiteController::class, 'projetos'])->name('projetos');
Route::get('/parcerias', [WebsiteController::class, 'parcerias'])->name('parcerias');
Route::get('/login', [WebsiteController::class, 'loginForm'])->name('login');
Route::post('/login', [WebsiteController::class, 'logar'])->name('login.post');
Route::post('/logout', [WebsiteController::class, 'deslogar'])->name('logout');
Route::get('/cadastro', [WebsiteController::class, 'cadastroForm'])->name('cadastro');
Route::post('/cadastro', [WebsiteController::class, 'cadastrarCliente'])->name('cadastro.post');
Route::get('/cliente', [WebsiteController::class, 'homeCliente'])->name('cliente.home');
Route::get('/admin', [WebsiteController::class, 'homeAdmin'])->name('admin.home');
Route::post('/admin/clientes/salvar', [AdminController::class, 'salvarCliente'])->name('admin.clientes.salvar');
Route::post('/admin/clientes/{id}/excluir', [AdminController::class, 'excluirCliente'])->name('admin.clientes.excluir');