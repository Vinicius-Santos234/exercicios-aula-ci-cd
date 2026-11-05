<?php
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "empresa";

$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);
mysqli_set_charset($conexao, "utf8mb4");

if (!$conexao) {
    die("Erro ao conectar ao banco de dados: " . mysqli_connect_error());
} else {
    echo "Conexão ao banco de dados realizada com sucesso!";
}