<?php
    $erro = null;

    if (!isset($_POST['nome']) || !isset($_POST['total'])) {
        $erro = "Dados incompletos. Por favor, preencha o formulário novamente.";
    } elseif (!isset($_POST['idade'])) {
        $erro = "Por favor, selecione uma faixa etária para continuar.";
    } else {
        $nome = htmlspecialchars($_POST['nome'], ENT_QUOTES, 'UTF-8');
        $total = (float) str_replace(',', '.', $_POST['total']);
        $idade = (int) $_POST['idade'];
        $cartao = isset($_POST['cartao']) ? "Sim" : "Não";

        $desconto = 0;
        if ($idade == 1) {
            $desconto = $total * 0.05;
        } elseif ($idade == 2) {
            $desconto = $total * 0.07;
        }

        if ($cartao == "Sim") {
            $desconto += $total * 0.05;
        }

        $totalComDesconto = $total - $desconto;
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado do Pedido - Farmácia Paracetaloka</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="container">
        <div class="card">
            <?php if ($erro): ?>
                <header class="card-header">
                    <span class="card-badge" style="background-color: #fee2e2; color: #991b1b;">Atenção</span>
                    <h1 class="card-title">Ops, algo faltou!</h1>
                    <p class="card-subtitle">Verifique os dados informados</p>
                </header>

                <div class="alert-box">
                    <?= $erro ?>
                </div>

                <a href="index.html" class="btn btn-secondary">Voltar ao Formulário</a>
            <?php else: ?>
                <header class="card-header">
                    <span class="card-badge">Resumo</span>
                    <h1 class="card-title">Resultado do Cálculo</h1>
                    <p class="card-subtitle">Confira os detalhes e descontos do pedido</p>
                </header>

                <ul class="result-list">
                    <li class="result-item">
                        <span class="label">Nome do Cliente</span>
                        <span class="value"><?= $nome ?></span>
                    </li>
                    <li class="result-item">
                        <span class="label">Total Original</span>
                        <span class="value">R$ <?= number_format($total, 2, ',', '.') ?></span>
                    </li>
                    <li class="result-item">
                        <span class="label">Cartão Fidelidade</span>
                        <span class="value"><?= $cartao ?></span>
                    </li>
                    <li class="result-item highlight-discount">
                        <span class="label">Desconto Aplicado</span>
                        <span class="value">- R$ <?= number_format($desconto, 2, ',', '.') ?></span>
                    </li>
                    <li class="result-item highlight-total">
                        <span class="label">Total a Pagar</span>
                        <span class="value">R$ <?= number_format($totalComDesconto, 2, ',', '.') ?></span>
                    </li>
                </ul>

                <a href="index.html" class="btn btn-secondary">Voltar ao Início</a>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>