<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class WebsiteController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function produtos()
    {
        return view('produtos');
    }

    public function projetos()
    {
        return view('projetos');
    }

    public function parcerias()
    {
        return view('parcerias');
    }

    public function loginForm()
    {
        return view('login');
    }

    public function cadastroForm()
    {
        return view('cadastro');
    }

    // LOGIN
    public function logar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'senha' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->senha])) {
            $request->session()->regenerate();

            return redirect()->route('home');
        }

        return redirect()->back()
            ->withErrors(['email' => 'Usuário ou senha inválidos'])
            ->withInput();
    }

    // LOGOUT
    public function deslogar(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function cadastrarCliente(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:clientes,email',
            'senha' => 'required|min:6',
            'tel' => 'required|string|max:30',
            'endereco' => 'required|string|max:255',
            'estado' => 'required|string|max:2',
            'cpf' => 'required|string|max:20',
            'nome' => 'nullable|string|max:255',
            'confirmar_senha' => 'nullable|string|same:senha'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->filled('confirmar_senha') && $request->input('senha') !== $request->input('confirmar_senha')) {
            return redirect()->back()->with('error', 'As senhas não coincidem!')->withInput();
        }

        $cl = new Clientes();
        $cl->nome = $request->input('nome', explode('@', $request->input('email'))[0]);
        $cl->email = $request->input('email');
        $cl->password = Hash::make($request->input('senha'));
        $cl->tel = $request->input('tel');
        $cl->endereco = $request->input('endereco');
        $cl->estado = $request->input('estado');
        $cl->cpf = $request->input('cpf');

        $cl->save();

        return redirect()->route('cadastro')->with('success', 'Cliente cadastrado com sucesso!');
    }

    public function salvarCliente(Request $request)
    {
        return $this->cadastrarCliente($request);
    }

    public function homeCliente()
    {
        return view('Cliente.home_cliente');
    }

    public function homeAdmin() {
    return view('Admin.home_admin');}
}
