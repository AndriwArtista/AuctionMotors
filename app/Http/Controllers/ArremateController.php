<?php

namespace App\Http\Controllers;

use App\Models\Arremate;
use App\Services\LeilaoService;
use App\Services\Operations;

class ArremateController extends Controller
{
    public function __construct(
        protected LeilaoService $leilaoService,
        protected Operations $operations,
    ) {
    }

    // leiloes que o usuario logado venceu
    public function index()
    {
        $this->leilaoService->encerrarVencidos();

        $arremates = Arremate::with(['veiculo.categoria', 'veiculo.user'])
            ->where('user_id', session('user.id'))
            ->orderByDesc('encerrado_em')
            ->get()
            ->transform(function ($arremate) {
                $arremate->encrypted_veiculo_id = $this->operations->encryptId($arremate->veiculo_id);
                return $arremate;
            });

        return view('arremates.index', compact('arremates'));
    }
}
