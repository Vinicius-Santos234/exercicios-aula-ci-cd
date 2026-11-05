<?php
require_once("../conexao.php");

$resultado = mysqli_query($conexao, "SELECT * FROM funcionarios ORDER BY nome");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Funcionários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-B/GM4XqrwHnWXNOWMbloTmrYXZg10cakYGmpfsR/bbzQ6JAJI4ihuyADKLnBgrCe" crossorigin="anonymous">
    <script type="module" src="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-1a/pXj49ZQ1aHEmrJ+gMw1otqoVsYwlEnlD8mIfY2TV03r20Y0CN7uqx1tQogjPL" crossorigin="anonymous"></script>
</head>
<body>
    <?php include_once("../menu.php"); ?>
    <div class="container mt-4">
        <h1>Funcionários</h1>
        <a href="adicionar.php" class="btn-solid theme-primary">Novo funcionário</a>
        <table class="table table-striped mt-4">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Cargo</th>
                <th>Salário</th>
                <th>Admissão</th>
                <th>Ativo</th>
                <th>Ações</th>
            </tr>
            <?php while ($funcionario = mysqli_fetch_assoc($resultado)) { ?>
                <tr>
                    <td><?= $funcionario['id'] ?></td>
                    <td><?= htmlspecialchars($funcionario['nome']) ?></td>
                    <td><?= htmlspecialchars($funcionario['email'] ?? '') ?></td>
                    <td><?= htmlspecialchars($funcionario['cargo']) ?></td>
                    <td>R$ <?= number_format($funcionario['salario'], 2, ',', '.') ?></td>
                    <td><?= date('d/m/Y', strtotime($funcionario['data_admissão'])) ?></td>
                    <td><?= $funcionario['ativo'] ? 'Sim' : 'Não' ?></td>
                    <td>
                        <a href="editar.php?id=<?= $funcionario['id'] ?>" class="btn-outline theme-primary">Editar</a>
                        <form action="remover.php" method="post" onsubmit="return confirm('Remover este funcionário?')">
                            <input type="hidden" name="id" value="<?= $funcionario['id'] ?>">
                            <button type="submit" class="btn-outline theme-danger">Remover</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
