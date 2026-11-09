<?php

namespace App\Http\Controllers;

use App\Models\Arremate;
use App\Models\Categoria;
use App\Models\Veiculo;
use App\Services\LeilaoService;
use App\Services\Operations;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class RelatorioController extends Controller
{
    public function __construct(
        protected LeilaoService $leilaoService,
        protected Operations $operations,
    ) {
    }

    public function veiculosGeral(Request $request)
    {
        $this->leilaoService->encerrarVencidos();

        $categoria = $request->query('categoria') ? Categoria::find($request->query('categoria')) : null;

        $veiculos = Veiculo::with(['categoria', 'user', 'arremate.user'])
            ->withMax('lances', 'valor_ofertado')
            ->withCount('lances')
            ->when($categoria, fn ($q) => $q->where('categoria_id', $categoria->id))
            ->orderBy('status')
            ->orderBy('data_encerramento')
            ->get();

        $resumo = [
            'total' => $veiculos->count(),
            'abertos' => $veiculos->where('status', 'aberto')->count(),
            'encerrados' => $veiculos->where('status', 'encerrado')->count(),
            'lances' => $veiculos->sum('lances_count'),
            'vendido' => $veiculos->sum(fn ($v) => $v->arremate->valor_final ?? 0),
        ];

        $pdf = Pdf::loadView('relatorios.veiculos_geral', compact('veiculos', 'categoria', 'resumo'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('relatorio-veiculos-geral.pdf');
    }

    public function comprovanteArremate($id)
    {
        $realId = $this->operations->decryptId($id);
        if (!$realId) {
            return redirect()->route('arremates.index')->with('error', 'Link inválido.');
        }

        $arremate = Arremate::with(['veiculo.categoria', 'veiculo.user', 'user', 'lance'])->findOrFail($realId);

        $userId = session('user.id');
        abort_unless(
            $arremate->user_id === $userId || $arremate->veiculo->user_id === $userId,
            403,
            'Você não tem acesso a esse comprovante.'
        );

        $pdf = Pdf::loadView('relatorios.arremate', compact('arremate'));

        return $pdf->download('comprovante-arremate-' . $arremate->id . '.pdf');
    }
}
