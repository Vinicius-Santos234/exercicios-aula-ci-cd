<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado</title>
</head>
<body>
    <h1>Resultado</h1>
    <p>
        <?php
            $numero = $_POST['numero'];

            for ($i = 1; $i <= 10; $i++) {
                echo $numero . " x " . $i . " = " . $numero * $i . "<br>";
            }
        ?>
    </p>
    <a href="index.html">Voltar</a>
</body>
</html>