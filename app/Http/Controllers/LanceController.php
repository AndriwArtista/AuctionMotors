<?php

namespace App\Http\Controllers;

use App\Http\Requests\LanceRequest;
use App\Models\Lance;
use App\Models\User;
use App\Models\Veiculo;
use App\Services\LeilaoService;
use App\Services\Operations;
use Illuminate\Support\Facades\DB;

class LanceController extends Controller
{
    protected $operations;
    protected $leilaoService;

    public function __construct(Operations $operations, LeilaoService $leilaoService)
    {
        $this->operations = $operations;
        $this->leilaoService = $leilaoService;
    }

    public function index($veiculo_id)
    {
        $id = $this->operations->decryptId($veiculo_id);

        if (!$id) {
            return redirect()->route('veiculos.index')->with('error', 'Veículo inválido.');
        }

        $veiculo = Veiculo::findOrFail($id);

        // se ja passou da data, fecha o leilao antes de mostrar
        if ($veiculo->status === 'aberto' && $veiculo->data_encerramento->isPast()) {
            $this->leilaoService->encerrar($veiculo);
        }

        $veiculo->load(['categoria', 'arremate.user']);
        $lances = Lance::where('veiculo_id', $id)->orderBy('created_at', 'desc')->get();
        $maiorLance = $veiculo->maiorLance();
        $minLance = $veiculo->valorMinimoLance();

        return view('lances.create', compact('veiculo', 'lances', 'maiorLance', 'minLance'));
    }

    // as regras (valor minimo, dono, leilao encerrado) ficam no LanceRequest
    public function store(LanceRequest $request, $encrypted_veiculo_id)
    {
        $veiculo = $request->veiculo();
        $user = User::findOrFail(session('user.id'));
        $valor = $request->validated()['valor_ofertado'];

        // trava o veiculo enquanto grava, assim dois lances ao mesmo tempo nao passam com o mesmo valor
        $ok = DB::transaction(function () use ($veiculo, $valor, $user) {
            Veiculo::whereKey($veiculo->id)->lockForUpdate()->first();

            $maior = Lance::where('veiculo_id', $veiculo->id)->max('valor_ofertado');
            if ($maior !== null && $valor <= $maior) {
                return false;
            }

            Lance::create([
                'valor_ofertado' => $valor,
                'nome_licitante' => $user->nome,
                'veiculo_id' => $veiculo->id,
                'user_id' => $user->id,
            ]);

            return true;
        });

        if (!$ok) {
            return redirect()->back()->with('error', 'Alguém deu um lance maior antes de você. Tente novamente.');
        }

        return redirect()->route('lances.create', $encrypted_veiculo_id)
            ->with('success', 'Lance efetuado com sucesso!');
    }
}
