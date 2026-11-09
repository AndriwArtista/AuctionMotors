<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriaRequest;
use App\Models\Categoria;
use App\Services\Operations;

class CategoriaController extends Controller
{
    public function __construct(protected Operations $operations)
    {
    }

    public function index()
    {
        $categorias = Categoria::withCount('veiculos')->orderBy('nome')->get();

        return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(CategoriaRequest $request)
    {
        Categoria::create($request->validated());

        return redirect()->route('categorias.index')->with('success', 'Categoria cadastrada com sucesso!');
    }

    public function edit($id)
    {
        $categoria = $this->buscar($id);
        if (!$categoria) {
            return redirect()->route('categorias.index')->with('error', 'Link inválido.');
        }

        return view('categorias.edit', compact('categoria', 'id'));
    }

    public function update(CategoriaRequest $request, $id)
    {
        $categoria = $this->buscar($id);
        if (!$categoria) {
            return redirect()->route('categorias.index')->with('error', 'Link inválido.');
        }

        $categoria->update($request->validated());

        return redirect()->route('categorias.index')->with('success', 'Categoria atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $categoria = $this->buscar($id);
        if (!$categoria) {
            return redirect()->route('categorias.index')->with('error', 'Link inválido.');
        }

        if ($categoria->veiculos()->exists()) {
            return redirect()->route('categorias.index')
                ->with('error', 'Não dá pra excluir: existem veículos nessa categoria.');
        }

        $categoria->delete();

        return redirect()->route('categorias.index')->with('success', 'Categoria removida com sucesso!');
    }

    private function buscar($id): ?Categoria
    {
        $realId = $this->operations->decryptId($id);

        return $realId ? Categoria::findOrFail($realId) : null;
    }
}
