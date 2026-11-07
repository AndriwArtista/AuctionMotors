<?php

namespace App\Http\Controllers;

use App\Http\Requests\VeiculoRequest;
use App\Mail\LeilaoCriadoMail;
use App\Models\Categoria;
use App\Models\Veiculo;
use App\Services\Operations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VeiculoController extends Controller
{
    protected $operations;

    public function __construct(Operations $operations)
    {
        $this->operations = $operations;
    }

    public function index(Request $request)
    {
        $categorias = Categoria::orderBy('nome')->get();
        $categoriaSelecionada = $request->query('categoria');

        $veiculos = Veiculo::with('categoria')
            ->withMax('lances', 'valor_ofertado')
            ->when($categoriaSelecionada, fn ($q) => $q->where('categoria_id', $categoriaSelecionada))
            ->orderBy('data_encerramento')
            ->paginate(3)
            ->withQueryString();

        $veiculos->getCollection()->transform(function ($veiculo) {
            $veiculo->encrypted_id = $this->operations->encryptId($veiculo->id);
            $veiculo->valor_atual = $veiculo->lances_max_valor_ofertado ?? $veiculo->valor_inicial;
            return $veiculo;
        });

        return view('veiculos.index', compact('veiculos', 'categorias', 'categoriaSelecionada'));
    }

    public function create()
    {
        $categorias = Categoria::orderBy('nome')->get();

        return view('veiculos.create', compact('categorias'));
    }

    public function store(VeiculoRequest $request)
    {
        $dados = $request->validated();
        $dados['user_id'] = session('user.id');

        $veiculo = Veiculo::create($dados);

        // Dispara a notificação por e-mail
        Mail::to('teste@usuario.com')->send(new LeilaoCriadoMail($veiculo));

        return redirect()->route('veiculos.index')->with('success', 'Veículo cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $realId = $this->operations->decryptId($id);
        if (!$realId) {
            return redirect()->route('veiculos.index')->with('error', 'Link inválido.');
        }

        $veiculo = Veiculo::findOrFail($realId);
        $this->verificaDono($veiculo);

        $categorias = Categoria::orderBy('nome')->get();

        return view('veiculos.edit', compact('veiculo', 'id', 'categorias'));
    }

    public function update(VeiculoRequest $request, $id)
    {
        $realId = $this->operations->decryptId($id);
        if (!$realId) {
            return redirect()->route('veiculos.index')->with('error', 'Link inválido.');
        }

        $veiculo = Veiculo::findOrFail($realId);
        $this->verificaDono($veiculo);

        $veiculo->update($request->validated());

        return redirect()->route('veiculos.index')->with('success', 'Veículo atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $realId = $this->operations->decryptId($id);
        if (!$realId) {
            return redirect()->route('veiculos.index')->with('error', 'Link inválido.');
        }

        $veiculo = Veiculo::findOrFail($realId);
        $this->verificaDono($veiculo);

        $veiculo->delete();
        return redirect()->route('veiculos.index')->with('success', 'Veículo removido com sucesso!');
    }

    public function list()
    {
        $id = session('user.id');

        $veiculos = Veiculo::with('categoria')->where('user_id', $id)->get()->transform(function ($veiculo) {
            $veiculo->encrypted_id = $this->operations->encryptId($veiculo->id);
            return $veiculo;
        });

        return view('veiculos.list', compact('veiculos'));
    }

    // so quem cadastrou o veiculo pode editar ou excluir
    private function verificaDono(Veiculo $veiculo)
    {
        abort_if($veiculo->user_id !== session('user.id'), 403, 'Você não tem permissão para alterar este veículo.');
    }
}
