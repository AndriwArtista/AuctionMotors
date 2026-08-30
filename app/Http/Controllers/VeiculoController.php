<?php

namespace App\Http\Controllers;

use App\Models\Veiculo;
use App\Services\Operations;
use Illuminate\Http\Request;

class VeiculoController extends Controller
{
    protected $operations;

    public function __construct(Operations $operations)
    {
        $this->operations = $operations;
    }

    public function index()
    {
        $veiculos = Veiculo::withMax('lances', 'valor_ofertado')
            ->get()
            ->map(function ($veiculo) {
                $veiculo->encrypted_id = $this->operations->encryptId($veiculo->id);
                $veiculo->valor_atual = $veiculo->lances_max_valor_ofertado ?? $veiculo->valor_inicial;
                return $veiculo;
            });

        return view('veiculos.index', compact('veiculos'));
    }

    public function create()
    {
        return view('veiculos.create');
    }

    private function regrasValidacao()
    {
        return [
            [
                'marca' => 'required|min:2',
                'modelo' => 'required|min:1',
                'ano' => 'required|integer|min:1900',
                'kilometragem' => 'required|integer|min:0',
                'valor_inicial' => 'required|numeric|min:0',
                'data_encerramento' => 'required|date',
            ],
            [
                'marca.required' => 'Informe a marca do veículo.',
                'marca.min' => 'A marca deve ter pelo menos 2 letras.',
                'modelo.required' => 'Informe o modelo do veículo.',
                'ano.required' => 'Informe o ano do veículo.',
                'ano.integer' => 'O ano deve ser um número.',
                'kilometragem.required' => 'Informe a kilometragem.',
                'valor_inicial.required' => 'Informe o valor inicial do leilão.',
                'valor_inicial.numeric' => 'O valor inicial deve ser um número.',
                'data_encerramento.required' => 'Informe a data de encerramento do leilão.',
            ],
        ];
    }

    public function store(Request $request)
    {
        [$regras, $mensagens] = $this->regrasValidacao();
        $request->validate($regras, $mensagens);

        $user_id = session('user')['id'];
        if (!$user_id) {
            return redirect()->back();
        }

        $dados = $request->only([
            'marca',
            'modelo',
            'ano',
            'kilometragem',
            'valor_inicial',
            'data_encerramento',
        ]);

        $dados['user_id'] = $user_id;

        Veiculo::create($dados);

        return redirect()->route('veiculos.index')->with('success', 'Veículo cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $realId = $this->operations->decryptId($id);
        if (!$realId) {
            return redirect()->route('veiculos.index')->with('error', 'Link inválido.');
        }

        $veiculo = Veiculo::findOrFail($realId);
        return view('veiculos.edit', compact('veiculo', 'id'));
    }

    public function update(Request $request, $id)
    {
        $realId = $this->operations->decryptId($id);
        if (!$realId) {
            return redirect()->route('veiculos.index')->with('error', 'Link inválido.');
        }

        [$regras, $mensagens] = $this->regrasValidacao();
        $request->validate($regras, $mensagens);

        $veiculo = Veiculo::findOrFail($realId);
        $veiculo->update($request->only([
            'marca',
            'modelo',
            'ano',
            'kilometragem',
            'valor_inicial',
            'data_encerramento',
        ]));

        return redirect()->route('veiculos.index')->with('success', 'Veículo atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $realId = $this->operations->decryptId($id);
        if (!$realId) {
            return redirect()->route('veiculos.index')->with('error', 'Link inválido.');
        }

        Veiculo::findOrFail($realId)->delete();
        return redirect()->route('veiculos.index')->with('success', 'Veículo removido com sucesso!');
    }
    public function list()
    {
        $id = session('user')['id'];

        $veiculos = Veiculo::where('user_id', $id)->get()->transform(function ($veiculo) {
            $veiculo->encrypted_id = $this->operations->encryptId($veiculo->id);
            return $veiculo;
        });

        return view('veiculos.list', compact('veiculos'));
    }

}