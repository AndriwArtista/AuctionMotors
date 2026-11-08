<?php

namespace App\Providers;

use App\Models\Notificacao;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        View::composer('partials.navbar', function ($view) {
            $userId = session('user.id');

            $view->with('notificacoesNaoLidas', $userId
                ? Notificacao::where('user_id', $userId)->naoLidas()->count()
                : 0);
        });
    }
}
