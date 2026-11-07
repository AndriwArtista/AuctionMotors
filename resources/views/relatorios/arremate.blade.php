<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Comprovante de Arremate</title>
    <style>
        @page { margin: 40px 50px; }
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .topo {
            border-bottom: 3px solid #D4AF37;
            padding-bottom: 10px;
            margin-bottom: 25px;
        }
        .topo h1 { margin: 0; color: #0b132b; font-size: 22px; }
        .topo p { margin: 4px 0 0 0; color: #666; }
        h2 {
            color: #0b132b;
            font-size: 14px;
            margin: 22px 0 8px 0;
            border-bottom: 1px solid #ddd;
            padding-bottom: 4px;
        }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 6px 4px; vertical-align: top; }
        td.rotulo { width: 35%; color: #666; }
        .valor-final {
            margin-top: 25px;
            background: #0b132b;
            color: #fff;
            padding: 16px;
            text-align: center;
        }
        .valor-final span { display: block; color: #D4AF37; font-size: 11px; }
        .valor-final strong { font-size: 24px; }
        .rodape {
            margin-top: 40px;
            font-size: 10px;
            color: #94a3b8;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="topo">
        <h1>Comprovante de Arremate</h1>
        <p>AuctionMotors &middot; Nº {{ str_pad($arremate->id, 6, '0', STR_PAD_LEFT) }} &middot; Emitido em {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <h2>Veículo</h2>
    <table>
        <tr><td class="rotulo">Marca / Modelo</td><td>{{ $arremate->veiculo->marca }} {{ $arremate->veiculo->modelo }}</td></tr>
        <tr><td class="rotulo">Categoria</td><td>{{ $arremate->veiculo->categoria->nome ?? '—' }}</td></tr>
        <tr><td class="rotulo">Ano</td><td>{{ $arremate->veiculo->ano }}</td></tr>
        <tr><td class="rotulo">Quilometragem</td><td>{{ number_format($arremate->veiculo->kilometragem, 0, ',', '.') }} km</td></tr>
        <tr><td class="rotulo">Valor inicial</td><td>R$ {{ number_format($arremate->veiculo->valor_inicial, 2, ',', '.') }}</td></tr>
    </table>

    <h2>Negociação</h2>
    <table>
        <tr><td class="rotulo">Vendedor</td><td>{{ $arremate->veiculo->user->nome ?? '—' }} ({{ $arremate->veiculo->user->email ?? '—' }})</td></tr>
        <tr><td class="rotulo">Comprador</td><td>{{ $arremate->user->nome ?? '—' }} ({{ $arremate->user->email ?? '—' }})</td></tr>
        <tr><td class="rotulo">Lance vencedor dado em</td><td>{{ $arremate->lance?->created_at?->format('d/m/Y H:i') ?? '—' }}</td></tr>
        <tr><td class="rotulo">Leilão encerrado em</td><td>{{ $arremate->encerrado_em->format('d/m/Y H:i') }}</td></tr>
    </table>

    <div class="valor-final">
        <span>VALOR FINAL ARREMATADO</span>
        <strong>R$ {{ number_format($arremate->valor_final, 2, ',', '.') }}</strong>
    </div>

    <div class="rodape">
        Documento gerado automaticamente pelo sistema AuctionMotors.
    </div>
</body>
</html>
