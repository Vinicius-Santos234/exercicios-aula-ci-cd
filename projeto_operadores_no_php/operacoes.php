<?php
    $temDados = isset($_POST['numero1']) && isset($_POST['numero2']);
    $numero1 = $temDados ? (int)$_POST['numero1'] : 0;
    $numero2 = $temDados ? (int)$_POST['numero2'] : 0;

    $soma = $numero1 + $numero2;
    $subtracao = $numero1 - $numero2;
    $multiplicacao = $numero1 * $numero2;

    $divisaoPossivel = !($numero1 === 0 || $numero2 === 0);
    if (!$divisaoPossivel) {
        $divisao = "Não é possível dividir por zero";
        $resto = "Não é possível calcular o resto da divisão por zero";
    } else {
        $divisao = $numero1 / $numero2;
        $resto = $numero1 % $numero2;
    }

    $potencia = $numero1 ** $numero2;
    $concatenacao = $numero1 . $numero2;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados das Operações | PHP</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="ambient-glow glow-1"></div>
    <div class="ambient-glow glow-2"></div>

    <main class="container container-wide">
        <div class="card">
            <header class="card-header">
                <span class="badge-tag">Processamento Concluído</span>
                <h1 class="card-title">Resultado dos Operadores</h1>
                <p class="card-subtitle">Cálculos aritméticos e concatenação executados com sucesso em PHP.</p>
            </header>

            <div class="values-banner">
                <div class="value-pill">
                    <span class="value-pill-label">Número 1</span>
                    <span class="value-pill-number"><?= $numero1 ?></span>
                </div>
                <div class="values-divider">&amp;</div>
                <div class="value-pill">
                    <span class="value-pill-label">Número 2</span>
                    <span class="value-pill-number"><?= $numero2 ?></span>
                </div>
            </div>

            <div class="results-grid">
                <article class="result-card">
                    <div class="result-header">
                        <span class="op-badge add">+</span>
                        <span class="op-category">Aritmético</span>
                    </div>
                    <span class="op-title">Soma</span>
                    <span class="op-formula"><?= $numero1 ?> + <?= $numero2 ?></span>
                    <div class="op-value highlight"><?= $soma ?></div>
                </article>

                <article class="result-card">
                    <div class="result-header">
                        <span class="op-badge sub">&minus;</span>
                        <span class="op-category">Aritmético</span>
                    </div>
                    <span class="op-title">Subtração</span>
                    <span class="op-formula"><?= $numero1 ?> - <?= $numero2 ?></span>
                    <div class="op-value"><?= $subtracao ?></div>
                </article>

                <article class="result-card">
                    <div class="result-header">
                        <span class="op-badge mul">&times;</span>
                        <span class="op-category">Aritmético</span>
                    </div>
                    <span class="op-title">Multiplicação</span>
                    <span class="op-formula"><?= $numero1 ?> &times; <?= $numero2 ?></span>
                    <div class="op-value"><?= $multiplicacao ?></div>
                </article>

                <article class="result-card">
                    <div class="result-header">
                        <span class="op-badge div">&divide;</span>
                        <span class="op-category">Aritmético</span>
                    </div>
                    <span class="op-title">Divisão</span>
                    <span class="op-formula"><?= $numero1 ?> &divide; <?= $numero2 ?></span>
                    <div class="op-value <?= !$divisaoPossivel ? 'alert-text' : '' ?>"><?= $divisao ?></div>
                </article>

                <article class="result-card">
                    <div class="result-header">
                        <span class="op-badge mod">%</span>
                        <span class="op-category">Módulo</span>
                    </div>
                    <span class="op-title">Resto da Divisão</span>
                    <span class="op-formula"><?= $numero1 ?> % <?= $numero2 ?></span>
                    <div class="op-value <?= !$divisaoPossivel ? 'alert-text' : '' ?>"><?= $resto ?></div>
                </article>

                <article class="result-card">
                    <div class="result-header">
                        <span class="op-badge pow">**</span>
                        <span class="op-category">Exponenciação</span>
                    </div>
                    <span class="op-title">Potência</span>
                    <span class="op-formula"><?= $numero1 ?> ** <?= $numero2 ?></span>
                    <div class="op-value"><?= $potencia ?></div>
                </article>

                <article class="result-card">
                    <div class="result-header">
                        <span class="op-badge cat">.</span>
                        <span class="op-category">Texto / String</span>
                    </div>
                    <span class="op-title">Concatenação</span>
                    <span class="op-formula">'<?= $numero1 ?>' . '<?= $numero2 ?>'</span>
                    <div class="op-value highlight"><?= $concatenacao ?></div>
                </article>
            </div>

            <div class="actions-footer">
                <a href="index.html" class="btn btn-secondary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    Realizar Novo Cálculo
                </a>
            </div>
        </div>
    </main>
</body>
</html>