<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Clientes;
use App\Http\Controllers\WebsiteController;

// routes/web.php

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/produtos', function () {
    return view('produtos');
})->name('produtos');

Route::get('/projetos', function () {
    return view('projetos');
})->name('projetos');

Route::get('/parcerias', function () {
    return view('parcerias');
})->name('parcerias');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [WebsiteController::class, 'logar'])->name('login.post');
Route::post('/logout', [WebsiteController::class, 'deslogar'])->name('logout');

Route::post('/cadastro', function (Request $request) {
    // Exemplo de como gravar no banco usando o modelo Clientes.
    // Ajuste o migration para criar a tabela 'clientes' antes de usar.
    Clientes::create([
        'nome' => $request->input('nome'),
        'email' => $request->input('email'),
        'tel' => $request->input('tel'),
        'password' => bcrypt($request->input('password')),
        'nascimento' => $request->input('nascimento'),
        'estado' => $request->input('estado'),
        'genero' => $request->input('genero'),
        'interesses' => implode(',', (array) $request->input('interesses', [])),
        'apresentacao' => $request->input('apresentacao'),
    ]);

    return redirect()->route('home');
})->name('cadastro');
