<html>
    <body>
        <?php 
            include.once("../menu.php");
        ?>
        <form action="inserir.php" method="post">
            <p>
                <label>Nome:</label>
                <input type="text" name="nome" required>
            </p>
            <p>
                <label>Email:</label>
                <input type="text" name="email" required>
            </p>
            <p>
                <label>Cargo:</label>
                <input type="text" name="cargo" required>
            </p>
            <p>
                <label>Salário:</label>
                <input type="number" name="salario" required>
            </p>
            <p>
                <label>Data de admissão:</label>
                <input type="date" name="data_admissão" required>
            </p>
            <p>
                <input type="submit" value="Cadastrar">
                <input type="reset" value="Limpar">
            </p>
        </form>
    </body>
</html>