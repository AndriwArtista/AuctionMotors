<?php

namespace App\Http\Controllers;

use App\Models\Lance;
use App\Models\User;
use App\Models\Veiculo;
use App\Services\Operations;
use Illuminate\Http\Request;

class LanceController extends Controller
{
    protected $operations;

    public function __construct(Operations $operations)
    {
        $this->operations = $operations;
    }

    public function index($veiculo_id)
    {
        if ($veiculo_id) {
            $veiculo_id = $this->operations->decryptId($veiculo_id);
            $veiculo = Veiculo::find($veiculo_id);
            $lances = Lance::where('veiculo_id', $veiculo_id)->orderBy('created_at', 'desc')->get();
            return view('lances.create', compact('veiculo', 'lances'));
        }
        return redirect()->back();

    }

    public function store(Request $request, $encrypted_veiculo_id)
    {
        $veiculo_id = $this->operations->decryptId($encrypted_veiculo_id);

        if (!$veiculo_id) {
            return redirect()->back()->with('error', 'Veículo inválido.');
        }

        $veiculo = Veiculo::findOrFail($veiculo_id);
        $maiorLanceAtual = Lance::where('veiculo_id', $veiculo_id)->max('valor_ofertado') ?? $veiculo->valor_inicial;
        $valorMinimo = $maiorLanceAtual + 0.01;

        $request->validate([
            'valor_ofertado' => "required|numeric|min:{$valorMinimo}",
        ], [
            'valor_ofertado.min' => 'O lance deve ser maior do que a última oferta (Mínimo: R$ ' . number_format($valorMinimo, 2, ',', '.') . ').',
        ]);

        $user_id = session('user')['id'];
        $user = User::findOrFail($user_id);

        Lance::create([
            'valor_ofertado' => $request->input('valor_ofertado'),
            'nome_licitante' => $user->nome,
            'veiculo_id' => $veiculo_id,
            'user_id' => $user_id,
        ]);

        return redirect()->route('lances.create', $encrypted_veiculo_id)
            ->with('success', 'Lance efetuado com sucesso!');
    }
}
