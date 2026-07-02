<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Clientes;
use App\Models\LeituraArduino;
use App\Models\TipoAcesso;
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

        // Tenta autenticar o usuário
        if (Auth::attempt(['email' => $request->email, 'password' => $request->senha])) {
            $user = Auth::user();

            // Verifica se a opção "Entrar como Administrador" foi marcada
            if ($request->has('is_admin')) {
                // Se NÃO for Admin (ID diferente de 2)
                if ($user->tipo_acesso_id != 2) {
                    Auth::logout(); // Desloga o usuário
                    
                    return redirect()->back()
                        ->withErrors(['email' => 'Esta conta não possui privilégios de Administrador.'])
                        ->withInput();
                }

                $request->session()->regenerate();
                return redirect()->route('admin.home');
            }

            // Se não marcou admin, faz o login comum de cliente
            $request->session()->regenerate();
            return redirect()->route('cliente.home');
        }

        // Credenciais erradas
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

    // --- ACESSOS CLIENTE (Proteção básica de Login) ---

    public function homeCliente()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $latest = LeituraArduino::latest()->first();

        return view('Cliente.home_cliente', compact('latest'));
    }

    public function configuracaoCliente()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $cliente = Auth::user();

        return view('Cliente.configuracao', compact('cliente'));
    }

    public function atualizarConfiguracao(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $cliente = Auth::user();

        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:clientes,email,' . $cliente->id,
            'tel' => 'nullable|string|max:30',
            'endereco' => 'nullable|string|max:255',
            'estado' => 'nullable|string|max:2',
            'cpf' => 'nullable|string|max:20',
            'password' => 'nullable|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $cliente->nome = $request->input('nome');
        $cliente->email = $request->input('email');
        $cliente->tel = $request->input('tel', $cliente->tel);
        $cliente->endereco = $request->input('endereco', $cliente->endereco);
        $cliente->estado = $request->input('estado', $cliente->estado);
        $cliente->cpf = $request->input('cpf', $cliente->cpf);

        if ($request->filled('password')) {
            $cliente->password = Hash::make($request->input('password'));
        }

        $cliente->save();

        return redirect()->back()->with('success', 'Configuração updated com sucesso.');
    }

    public function historicoCliente()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return view('Cliente.historico');
    }

    public function faqCliente()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return view('Cliente.faq');
    }

    public function compraCliente()
    {
        return $this->dispositivosCliente();
    }

    public function dispositivosCliente()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $devices = LeituraArduino::select('dispositivo_id')
            ->distinct()
            ->pluck('dispositivo_id')
            ->filter()
            ->values();

        if ($devices->isEmpty()) {
            $devices = collect(['estacao-01', 'estacao-02', 'estacao-03']);
        }

        $deviceData = $devices->mapWithKeys(function ($device) {
            return [$device => LeituraArduino::where('dispositivo_id', $device)->latest()->first()];
        });

        return view('Cliente.dispositivos', compact('devices', 'deviceData'));
    }


    // --- ACESSOS ADMIN (Proteção rígida contra penetras) ---

    public function homeAdmin()
    {
        if (!Auth::check() || Auth::user()->tipo_acesso_id != 2) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Acesso restrito a administradores.');
        }

        $latest = LeituraArduino::latest()->first();

        return view('Admin.home_admin', compact('latest'));
    }

    public function adminClientes(Request $request)
    {
        if (!Auth::check() || Auth::user()->tipo_acesso_id != 2) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Acesso restrito a administradores.');
        }

        $latest = LeituraArduino::latest()->first();
        $query = $request->input('q');
        $tipo = $request->input('tipo');

        $clientes = Clientes::with('tipoAcesso')
            ->when($query, function ($builder) use ($query) {
                $builder->where(function ($sub) use ($query) {
                    $sub->where('nome', 'like', "%{$query}%")
                        ->orWhere('email', 'like', "%{$query}%");
                });
            })
            ->when($tipo, fn ($builder) => $builder->where('tipo_acesso_id', $tipo))
            ->latest('id')
            ->get();

        $tipos = TipoAcesso::orderBy('nome')->get();

        return view('Admin.clientes', compact('clientes', 'tipos', 'query', 'tipo', 'latest'));
    }

    public function adminVendas()
    {
        if (!Auth::check() || Auth::user()->tipo_acesso_id != 2) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Acesso restrito a administradores.');
        }

        $latest = LeituraArduino::latest()->first();
        $clientes = Clientes::count();
        $leituras = LeituraArduino::count();

        return view('Admin.vendas', compact('latest', 'clientes', 'leituras'));
    }

    public function adminHistoricos(Request $request)
    {
        if (!Auth::check() || Auth::user()->tipo_acesso_id != 2) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Acesso restrito a administradores.');
        }

        // Unificado: Carrega ambas as tabelas reais do banco de dados de forma paginada e independente
        $historicos = LeituraArduino::orderBy('created_at', 'desc')->paginate(10, ['*'], 'page_arduino');
        $logs = ActivityLog::with('user')->orderBy('created_at', 'desc')->paginate(10, ['*'], 'page_logs');

        return view('Admin.historicos', compact('historicos', 'logs'));
    }

    public function adminRotas()
    {
        if (!Auth::check() || Auth::user()->tipo_acesso_id != 2) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Acesso restrito a administradores.');
        }

        $latest = LeituraArduino::latest()->first();

        return view('Admin.rotas', compact('latest'));
    }

    public function arduinoLatest(Request $request)
    {
        $device = $request->input('device');

        $latest = $device
            ? LeituraArduino::where('dispositivo_id', $device)->latest()->first()
            : LeituraArduino::latest()->first();

        return response()->json([
            'ok' => true,
            'data' => $latest,
            'updated_at' => $latest?->updated_at?->toDateTimeString(),
        ]);
    }

    public function adminEstacaoDetalhes()
    {
        // Certifique-se de que a view foi criada em: resources/views/Admin/estacao_detalhes.blade.php
        return view('Admin.estacao_detalhes');
    }

    
}