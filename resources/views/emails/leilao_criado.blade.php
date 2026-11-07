<!DOCTYPE html>
<html>
<head>
    <title>Novo Leilão</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333;">
    <h2>Seu veículo entrou em leilão!</h2>
    <p>Olá, {{ $veiculo->user->nome }}. O seu lote já está disponível na vitrine:</p>

    <ul>
        <li><strong>Categoria:</strong> {{ $veiculo->categoria->nome ?? '—' }}</li>
        <li><strong>Marca:</strong> {{ $veiculo->marca }}</li>
        <li><strong>Modelo:</strong> {{ $veiculo->modelo }}</li>
        <li><strong>Ano:</strong> {{ $veiculo->ano }}</li>
        <li><strong>Valor inicial:</strong> R$ {{ number_format($veiculo->valor_inicial, 2, ',', '.') }}</li>
        <li><strong>Encerramento:</strong> {{ $veiculo->data_encerramento->format('d/m/Y H:i') }}</li>
    </ul>

    <p>Você vai receber uma notificação no sistema a cada lance novo.</p>
</body>
</html>
