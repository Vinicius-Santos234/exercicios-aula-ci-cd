<?php
$horas = $_POST['horas'];
$veiculo = $_POST['veiculo'];
if (isset($_POST['lavagem']))
{
    $lavagem = "sim";
}
else
{
    $lavagem = "não";
}

if ($veiculo == 0)
{
    $primeira = 10;
    $adicional = 6;
}
else
{
    $primeira = 6;
    $adicional = 3;
}

$total = $primeira;
for ($i = 2 ; $i <= $horas ; $i++) {
    $total = $total + $adicional;
}

if ($total > 50) {
    $total = 50;
}

if ($lavagem == "sim") {
    $total = $total + 20;
}

$nomeVeiculo = ($veiculo == 0) ? "Carro" : "Moto";
$valorFormatado = number_format($total, 2, ',', '.');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Resultado do cálculo do estacionamento no Park Fácil.">
    <title>Resultado - Park Fácil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="card">
        <h1>Park Fácil</h1>

        <div class="resultado">
            <p class="resultado-rotulo">O valor a ser pago é</p>
            <p class="resultado-valor">R$ <?= $valorFormatado ?></p>
        </div>

        <ul class="resumo">
            <li><span>Horas</span><strong><?= htmlspecialchars($horas) ?></strong></li>
            <li><span>Veículo</span><strong><?= $nomeVeiculo ?></strong></li>
            <li><span>Lavagem</span><strong><?= $lavagem ?></strong></li>
        </ul>

        <div class="acoes">
            <a href="index.html" class="botao" id="btn-voltar">Voltar ao início</a>
        </div>
    </main>
</body>
</html>