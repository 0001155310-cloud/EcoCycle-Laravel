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

Route::get('/cadastro', function () {
    return view('cadastro');
})->name('cadastro');

Route::post('/cadastro', function (Request $request) {
    $request->validate([
        'email' => 'required|email|max:100',
        'senha' => 'required|min:6|max:100',
        'tel' => 'required|max:20',
        'endereco' => 'required|max:100',
        'estado' => 'required|max:2',
        'cpf' => 'required|max:14',
    ]);

    $conn = mysqli_connect('127.0.0.1', 'root', '', 'ecocycle');
    if (!$conn) {
        return redirect()->back()->withInput()->with('error', 'Não foi possível conectar ao banco de dados.');
    }

    $email = mysqli_real_escape_string($conn, $request->email);
    $senha = password_hash($request->senha, PASSWORD_DEFAULT);
    $tel = mysqli_real_escape_string($conn, $request->tel);
    $endereco = mysqli_real_escape_string($conn, $request->endereco);
    $estado = mysqli_real_escape_string($conn, $request->estado);
    $cpf = mysqli_real_escape_string($conn, $request->cpf);
    $data = date('Y-m-d H:i:s');

    $sql = "INSERT INTO clientes (email, senha, tel, endereco, estado, cpf, created_at, updated_at) VALUES ('{$email}', '{$senha}', '{$tel}', '{$endereco}', '{$estado}', '{$cpf}', '{$data}', '{$data}')";

    if (!mysqli_query($conn, $sql)) {
        $error = mysqli_error($conn);
        mysqli_close($conn);
        return redirect()->back()->withInput()->with('error', 'Erro ao salvar o cadastro: ' . $error);
    }

    mysqli_close($conn);
    return redirect()->route('home');
})->name('cadastro.post');
