<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginSubmit(LoginRequest $request)
    {
        $user = User::where('email', $request->input('text_email'))->first();

        if (!$user || !password_verify($request->input('text_senha'), $user->senha)) {
            return redirect()->back()->withInput()->with('login_error', 'E-mail ou senha incorretos!');
        }

        $this->logarUsuario($request, $user);

        return redirect('/');
    }

    public function register()
    {
        return view('register');
    }

    public function registerSubmit(RegisterRequest $request)
    {
        $dados = $request->validated();

        $user = User::create([
            'nome' => $dados['nome'],
            'email' => $dados['email'],
            'senha' => bcrypt($dados['senha']),
        ]);

        $this->logarUsuario($request, $user);

        return redirect()->route('veiculos.index')->with('success', 'Conta criada com sucesso! Bem-vindo, ' . $user->nome . '.');
    }

    private function logarUsuario(Request $request, User $user)
    {
        $user->last_login = now();
        $user->save();

        $request->session()->regenerate();

        session([
            'user' => [
                'id' => $user->id,
                'nome' => $user->nome,
                'is_admin' => $user->is_admin,
            ]
        ]);
    }

    public function logout(Request $request)
    {
        session()->forget('user');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
