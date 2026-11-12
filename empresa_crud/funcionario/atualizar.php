<?php
require_once("../conexao.php");

$id = $_POST['id'];
$nome = $_POST['nome'];
$email = $_POST['email'] ?: null;
$cargo = $_POST['cargo'];
$salario = $_POST['salario'];
$admissao = $_POST['data_admissao'];
$ativo = isset($_POST['ativo']) ? 1 : 0;

$sql = "UPDATE funcionarios SET nome = ?, email = ?, cargo = ?, salario = ?, `data_admissão` = ?, ativo = ? WHERE id = ?";
mysqli_execute_query($conexao, $sql, [$nome, $email, $cargo, $salario, $admissao, $ativo, $id]);

header("Location: listar.php");
