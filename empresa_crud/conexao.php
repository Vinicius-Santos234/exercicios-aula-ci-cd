<?php
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "empresa";

$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);

if (!$conexao) {
    die("Erro ao conectar ao banco de dados: " . mysqli_connect_error());
} else {
    echo "Conexão ao banco de dados realizada com sucesso!";
}
?>