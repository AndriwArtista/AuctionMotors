<!DOCTYPE html>
<html>
<head>
    <title>Novo Leilão</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333;">
    <h2>Um novo veículo entrou em leilão!</h2>
    <p>Confira os detalhes do novo lote disponível:</p>
    
    <ul>
        <li><strong>Marca:</strong> {{ $veiculo->marca }}</li>
        <li><strong>Modelo:</strong> {{ $veiculo->modelo }}</li>
        <li><strong>Ano:</strong> {{ $veiculo->ano }}</li>
    </ul>

    <p>Acesse a plataforma para dar o seu lance!</p>
</body>
</html>