<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsuariosController extends Controller
{
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

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->senha])) {
            $request->session()->regenerate();

            return redirect()->route('admin.home');
        }

        return redirect()->back()
            ->withErrors(['email' => 'Usuário ou senha inválidos'])
            ->withInput();
    }

    // LOGOUT
    public function deslogar(Request $request)
    {
        Auth::guard('admin')->logout();

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

        Auth::login($cl);

        return redirect()->route('cliente.home');
    }

}
