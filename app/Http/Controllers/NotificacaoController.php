<?php

namespace App\Http\Controllers;

use App\Models\Notificacao;
use App\Services\Operations;

class NotificacaoController extends Controller
{
    public function __construct(protected Operations $operations)
    {
    }

    public function index()
    {
        $notificacoes = Notificacao::with('veiculo')
            ->where('user_id', session('user.id'))
            ->latest()
            ->paginate(10);

        $notificacoes->getCollection()->transform(function ($notificacao) {
            $notificacao->encrypted_veiculo_id = $notificacao->veiculo_id
                ? $this->operations->encryptId($notificacao->veiculo_id)
                : null;
            return $notificacao;
        });

        return view('notificacoes.index', compact('notificacoes'));
    }

    public function marcarLida($id)
    {
        $realId = $this->operations->decryptId($id);

        // so mexe nas notificacoes do proprio usuario
        $notificacao = Notificacao::where('user_id', session('user.id'))->findOrFail($realId);
        $notificacao->update(['lida_em' => now()]);

        return redirect()->back();
    }

    public function marcarTodas()
    {
        Notificacao::where('user_id', session('user.id'))
            ->naoLidas()
            ->update(['lida_em' => now()]);

        return redirect()->route('notificacoes.index')->with('success', 'Todas as notificações foram marcadas como lidas.');
    }
}
