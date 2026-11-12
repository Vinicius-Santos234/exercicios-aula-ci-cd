<?php
require_once("../conexao.php");

$id = $_POST['id'];
mysqli_execute_query($conexao, "DELETE FROM funcionarios WHERE id = ?", [$id]);

header("Location: listar.php");
