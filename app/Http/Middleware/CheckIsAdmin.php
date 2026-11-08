<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = User::find(session('user.id'));

        abort_unless($user?->is_admin, 403, 'Somente administradores podem acessar essa área.');

        return $next($request);
    }
}
