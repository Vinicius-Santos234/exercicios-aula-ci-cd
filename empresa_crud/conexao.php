<?php
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "empresa";

$result = mysqli_connect($servidor, $usuario, $senha, $banco);

if (!$result) {
    die("Erro ao conectar ao banco de dados: " . mysqli_connect_error());
} else {
    echo "Conexão ao banco de dados realizada com sucesso!";
}
?>