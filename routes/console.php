<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// fecha os leiloes vencidos a cada minuto (rodar com: php artisan schedule:work)
Schedule::command('leiloes:encerrar')->everyMinute();
