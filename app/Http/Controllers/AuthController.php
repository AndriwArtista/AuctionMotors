<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginSubmit(Request $request)
    {
        $request->validate(
            [
                'text_email' => 'required|email|min:10',
                'text_senha' => 'required|min:6',
            ],
            [
                'text_email.required' => 'O campo e-mail é obrigatório.',
                'text_email.email' => 'O campo de e-mail deve conter um endereço válido.',
                'text_email.min' => 'O campo e-mail deve ter no mínimo 10 caracteres',

                'text_senha.required' => 'O campo senha é obrigatório.',
                'text_senha.min' => 'O campo senha deve ter no mínimo 6 caracteres',
            ],
        );

        $user = User::where('email', $request->input('text_email'))->first();

        if (!$user || !password_verify($request->input('text_senha'), $user->senha)) {
            return redirect()->back()->withInput()->with('login_error', 'E-mail ou senha incorretos!');
        }

        $user->last_login = now();
        $user->save();

        // gera um novo id de sessao pra evitar session fixation
        $request->session()->regenerate();

        session([
            'user' => [
                'id' => $user->id,
                'nome' => $user->nome,
            ]
        ]);

        return redirect('/');
    }

    public function logout(Request $request)
    {
        session()->forget('user');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
