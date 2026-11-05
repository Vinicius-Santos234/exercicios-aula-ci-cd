<?php
require_once("../conexao.php");

$id = $_GET['id'];
$resultado = mysqli_execute_query($conexao, "SELECT * FROM funcionarios WHERE id = ?", [$id]);
$funcionario = mysqli_fetch_assoc($resultado);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar funcionário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-B/GM4XqrwHnWXNOWMbloTmrYXZg10cakYGmpfsR/bbzQ6JAJI4ihuyADKLnBgrCe" crossorigin="anonymous">
    <script type="module" src="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-1a/pXj49ZQ1aHEmrJ+gMw1otqoVsYwlEnlD8mIfY2TV03r20Y0CN7uqx1tQogjPL" crossorigin="anonymous"></script>
</head>
<body>
    <?php include_once("../menu.php"); ?>
    <div class="container mt-4">
        <h1>Editar funcionário</h1>
        <form action="atualizar.php" method="post" class="vstack gap-2">
            <input type="hidden" name="id" value="<?= $funcionario['id'] ?>">
            <div class="form-field">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" class="form-control" value="<?= htmlspecialchars($funcionario['nome']) ?>" required>
            </div>
            <div class="form-field">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($funcionario['email'] ?? '') ?>">
            </div>
            <div class="form-field">
                <label for="cargo">Cargo:</label>
                <input type="text" id="cargo" name="cargo" class="form-control" value="<?= htmlspecialchars($funcionario['cargo']) ?>" required>
            </div>
            <div class="form-field">
                <label for="salario">Salário:</label>
                <input type="number" id="salario" name="salario" class="form-control" step="0.01" value="<?= $funcionario['salario'] ?>" required>
            </div>
            <div class="form-field">
                <label for="data_admissao">Data de admissão:</label>
                <input type="date" id="data_admissao" name="data_admissao" class="form-control" value="<?= $funcionario['data_admissão'] ?>" required>
            </div>
            <div class="form-field">
                <input type="checkbox" id="ativo" name="ativo" class="check" <?= $funcionario['ativo'] ? 'checked' : '' ?>>
                <label for="ativo">Ativo</label>
            </div>
            <div class="hstack gap-2 mt-4">
                <input type="submit" value="Salvar" class="btn-solid theme-primary">
                <a href="listar.php" class="btn-text">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
