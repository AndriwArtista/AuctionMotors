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
                'text_email' => 'required|min:10',
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

        $email = $request->input('text_email');
        $senha = $request->input('text_senha');
        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect()->back()->withInput()->with('login_error', 'Email ou senha incorretos!');
        } else {
            if (!password_verify($senha, $user->senha)) {
                return redirect()->back()->withInput()->with('login_error', 'Username ou password incorretos!');
            }
        }
        $user->last_login = date('Y-m-d H:i:s');
        $user->save();
        session([
            'user' => [
                'id' => $user->id,
                'nome' => $user->nome,
            ]
        ]);
        return redirect('/');

    }

        public function logout()
    {
        session()->forget('user');
        return redirect()->route('login');
    }
}
