<?php

namespace App\Services;

use App\Models\Arremate;
use App\Models\Lance;
use App\Models\Notificacao;
use App\Models\Veiculo;

class NotificacaoService
{
    public function notificar(int $userId, string $tipo, string $mensagem, ?int $veiculoId = null): Notificacao
    {
        return Notificacao::create([
            'user_id' => $userId,
            'veiculo_id' => $veiculoId,
            'tipo' => $tipo,
            'mensagem' => $mensagem,
        ]);
    }

    public function lanceDado(Veiculo $veiculo, Lance $lance, ?int $usuarioSuperadoId): void
    {
        $nomeVeiculo = "{$veiculo->marca} {$veiculo->modelo}";
        $valor = 'R$ ' . number_format($lance->valor_ofertado, 2, ',', '.');

        $this->notificar(
            $veiculo->user_id,
            'lance_recebido',
            "{$lance->nome_licitante} deu um lance de {$valor} no seu {$nomeVeiculo}.",
            $veiculo->id
        );

        if ($usuarioSuperadoId && $usuarioSuperadoId !== $lance->user_id) {
            $this->notificar(
                $usuarioSuperadoId,
                'lance_superado',
                "Seu lance no {$nomeVeiculo} foi superado. Novo lance: {$valor}.",
                $veiculo->id
            );
        }
    }

    public function leilaoEncerrado(Veiculo $veiculo, Arremate $arremate): void
    {
        $nomeVeiculo = "{$veiculo->marca} {$veiculo->modelo}";

        if ($arremate->user_id) {
            $valor = 'R$ ' . number_format($arremate->valor_final, 2, ',', '.');

            $this->notificar(
                $arremate->user_id,
                'leilao_vencido',
                "Parabéns! Você arrematou o {$nomeVeiculo} por {$valor}.",
                $veiculo->id
            );

            $this->notificar(
                $veiculo->user_id,
                'leilao_encerrado',
                "O leilão do seu {$nomeVeiculo} terminou: vendido por {$valor}.",
                $veiculo->id
            );
        } else {
            $this->notificar(
                $veiculo->user_id,
                'leilao_encerrado',
                "O leilão do seu {$nomeVeiculo} terminou sem lances.",
                $veiculo->id
            );
        }
    }
}
