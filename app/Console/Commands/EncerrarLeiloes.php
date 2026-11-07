<?php

namespace App\Console\Commands;

use App\Services\LeilaoService;
use Illuminate\Console\Command;

class EncerrarLeiloes extends Command
{
    protected $signature = 'leiloes:encerrar';

    protected $description = 'Encerra os leilões que passaram da data e registra o vencedor';

    public function handle(LeilaoService $leilaoService): int
    {
        $total = $leilaoService->encerrarVencidos();

        $this->info("{$total} leilão(ões) encerrado(s).");

        return self::SUCCESS;
    }
}
