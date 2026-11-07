<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório Geral de Veículos</title>
    <style>
        @page { margin: 25px 30px; }
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 10px;
            color: #333;
        }
        .header {
            border-bottom: 3px solid #D4AF37;
            padding-bottom: 8px;
            margin-bottom: 14px;
        }
        .header h1 {
            margin: 0;
            color: #0b132b;
            font-size: 18px;
        }
        .header p {
            margin: 4px 0 0 0;
            color: #666;
        }
        .resumo {
            width: 100%;
            border-collapse: separate;
            border-spacing: 6px 0;
            margin-bottom: 14px;
        }
        .resumo td {
            background: #f8f9fa;
            border-left: 4px solid #D4AF37;
            padding: 6px 8px;
        }
        .resumo .num {
            display: block;
            font-size: 14px;
            font-weight: bold;
            color: #0b132b;
        }
        table.dados {
            width: 100%;
            border-collapse: collapse;
        }
        table.dados th, table.dados td {
            border: 1px solid #cbd5e1;
            padding: 5px 6px;
            text-align: left;
        }
        table.dados th {
            background-color: #0b132b;
            color: #fff;
            font-weight: bold;
        }
        table.dados tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .direita { text-align: right !important; }
        .status-aberto { color: #198754; font-weight: bold; }
        .status-encerrado { color: #555; font-weight: bold; }
        .footer {
            margin-top: 16px;
            text-align: right;
            font-size: 9px;
            color: #94a3b8;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>AuctionMotors - Relatório Geral de Veículos</h1>
        <p>
            {{ $categoria ? 'Categoria: ' . $categoria->nome : 'Todas as categorias' }}
            &nbsp;|&nbsp; Gerado em: {{ now()->format('d/m/Y H:i') }}
            &nbsp;|&nbsp; Por: {{ session('user.nome') }}
        </p>
    </div>

    <table class="resumo">
        <tr>
            <td>Veículos<span class="num">{{ $resumo['total'] }}</span></td>
            <td>Leilões abertos<span class="num">{{ $resumo['abertos'] }}</span></td>
            <td>Leilões encerrados<span class="num">{{ $resumo['encerrados'] }}</span></td>
            <td>Lances recebidos<span class="num">{{ $resumo['lances'] }}</span></td>
            <td>Total arrematado<span class="num">R$ {{ number_format($resumo['vendido'], 2, ',', '.') }}</span></td>
        </tr>
    </table>

    <table class="dados">
        <thead>
            <tr>
                <th>ID</th>
                <th>Veículo</th>
                <th>Categoria</th>
                <th>Ano</th>
                <th class="direita">Km</th>
                <th class="direita">Valor inicial</th>
                <th class="direita">Maior lance</th>
                <th class="direita">Lances</th>
                <th>Status</th>
                <th>Vencedor</th>
                <th>Anunciante</th>
                <th>Encerramento</th>
            </tr>
        </thead>
        <tbody>
            @forelse($veiculos as $veiculo)
                <tr>
                    <td>#{{ $veiculo->id }}</td>
                    <td>{{ $veiculo->marca }} {{ $veiculo->modelo }}</td>
                    <td>{{ $veiculo->categoria->nome ?? '—' }}</td>
                    <td>{{ $veiculo->ano }}</td>
                    <td class="direita">{{ number_format($veiculo->kilometragem, 0, ',', '.') }}</td>
                    <td class="direita">R$ {{ number_format($veiculo->valor_inicial, 2, ',', '.') }}</td>
                    <td class="direita">
                        {{ $veiculo->lances_max_valor_ofertado ? 'R$ ' . number_format($veiculo->lances_max_valor_ofertado, 2, ',', '.') : '—' }}
                    </td>
                    <td class="direita">{{ $veiculo->lances_count }}</td>
                    <td class="status-{{ $veiculo->status }}">{{ ucfirst($veiculo->status) }}</td>
                    <td>{{ $veiculo->arremate->user->nome ?? '—' }}</td>
                    <td>{{ $veiculo->user->nome ?? '—' }}</td>
                    <td>{{ $veiculo->data_encerramento->format('d/m/Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="12" style="text-align: center;">Nenhum veículo cadastrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>AuctionMotors &middot; Total de veículos: {{ $veiculos->count() }}</p>
    </div>

</body>
</html>
