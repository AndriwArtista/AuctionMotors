<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
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
