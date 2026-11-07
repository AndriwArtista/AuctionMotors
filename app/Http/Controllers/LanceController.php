<?php

namespace App\Http\Controllers;

use App\Models\Lance;
use App\Models\User;
use App\Models\Veiculo;
use App\Services\Operations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LanceController extends Controller
{
    protected $operations;

    public function __construct(Operations $operations)
    {
        $this->operations = $operations;
    }

    public function index($veiculo_id)
    {
        $id = $this->operations->decryptId($veiculo_id);

        if (!$id) {
            return redirect()->route('veiculos.index')->with('error', 'Veículo inválido.');
        }

        $veiculo = Veiculo::findOrFail($id);
        $lances = Lance::where('veiculo_id', $id)->orderBy('created_at', 'desc')->get();

        return view('lances.create', compact('veiculo', 'lances'));
    }

    public function store(Request $request, $encrypted_veiculo_id)
    {
        $veiculo_id = $this->operations->decryptId($encrypted_veiculo_id);

        if (!$veiculo_id) {
            return redirect()->route('veiculos.index')->with('error', 'Veículo inválido.');
        }

        $user_id = session('user.id');
        $veiculo = Veiculo::findOrFail($veiculo_id);

        if ($veiculo->user_id === $user_id) {
            return redirect()->back()->with('error', 'Você não pode dar lance no seu próprio veículo.');
        }

        if ($veiculo->data_encerramento->isPast()) {
            return redirect()->back()->with('error', 'Esse leilão já foi encerrado.');
        }

        $maiorLanceAtual = Lance::where('veiculo_id', $veiculo_id)->max('valor_ofertado') ?? $veiculo->valor_inicial;
        $valorMinimo = $maiorLanceAtual + 0.01;

        $request->validate([
            'valor_ofertado' => "required|numeric|min:{$valorMinimo}",
        ], [
            'valor_ofertado.required' => 'Informe o valor do lance.',
            'valor_ofertado.numeric' => 'O lance deve ser um número.',
            'valor_ofertado.min' => 'O lance deve ser maior do que a última oferta (Mínimo: R$ ' . number_format($valorMinimo, 2, ',', '.') . ').',
        ]);

        $user = User::findOrFail($user_id);

        // trava o veiculo enquanto grava, assim dois lances ao mesmo tempo nao passam com o mesmo valor
        $ok = DB::transaction(function () use ($veiculo_id, $request, $user) {
            Veiculo::whereKey($veiculo_id)->lockForUpdate()->first();

            $maior = Lance::where('veiculo_id', $veiculo_id)->max('valor_ofertado');
            if ($maior !== null && $request->input('valor_ofertado') <= $maior) {
                return false;
            }

            Lance::create([
                'valor_ofertado' => $request->input('valor_ofertado'),
                'nome_licitante' => $user->nome,
                'veiculo_id' => $veiculo_id,
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
