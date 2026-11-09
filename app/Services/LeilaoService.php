<?php

namespace App\Services;

use App\Models\Arremate;
use App\Models\Lance;
use App\Models\Veiculo;
use Illuminate\Support\Facades\DB;

class LeilaoService
{
    public function __construct(protected NotificacaoService $notificacaoService)
    {
    }

    public function encerrarVencidos(): int
    {
        $vencidos = Veiculo::where('status', 'aberto')
            ->where('data_encerramento', '<=', now())
            ->get();

        foreach ($vencidos as $veiculo) {
            $this->encerrar($veiculo);
        }

        return $vencidos->count();
    }

    public function encerrar(Veiculo $veiculo): Arremate
    {
        return DB::transaction(function () use ($veiculo) {
            $maiorLance = Lance::where('veiculo_id', $veiculo->id)
                ->orderByDesc('valor_ofertado')
                ->first();

            $arremate = Arremate::firstOrCreate(
                ['veiculo_id' => $veiculo->id],
                [
                    'user_id' => $maiorLance?->user_id,
                    'lance_id' => $maiorLance?->id,
                    'valor_final' => $maiorLance?->valor_ofertado,
                    'encerrado_em' => now(),
                ]
            );

            $veiculo->update(['status' => 'encerrado']);

            if ($arremate->wasRecentlyCreated) {
                $this->notificacaoService->leilaoEncerrado($veiculo, $arremate);
            }

            return $arremate;
        });
    }
}
