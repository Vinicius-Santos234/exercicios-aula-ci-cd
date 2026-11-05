<?php
require_once("../conexao.php");

$nome = $_POST['nome'];
$email = $_POST['email'] ?: null;
$cargo = $_POST['cargo'];
$salario = $_POST['salario'];
$admissao = $_POST['data_admissao'];

$sql = "INSERT INTO funcionarios (nome, email, cargo, salario, `data_admissão`) VALUES (?, ?, ?, ?, ?)";
mysqli_execute_query($conexao, $sql, [$nome, $email, $cargo, $salario, $admissao]);

header("Location: listar.php");
