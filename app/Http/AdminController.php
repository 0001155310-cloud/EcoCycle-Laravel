<?php

namespace App\Http;

use App\Http\Controllers\Controller;
use App\Models\Clientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function salvarCliente(Request $request)
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

        return redirect()->back()->with('success', 'Cliente salvo com sucesso!');
    }

    public function excluirCliente($id)
    {
        $cliente = Clientes::findOrFail($id);
        $cliente->delete();

        return redirect()->back()->with('success', 'Cliente excluído com sucesso!');
    }
    
}
