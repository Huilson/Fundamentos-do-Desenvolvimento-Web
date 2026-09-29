<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <title>Olá Mundo em PHP</title>
</head>
<body>
    <?php
        $mensagem = "Olá, Mundo!";
        echo "<p><strong>Mensagem do Servidor:</strong> " . $mensagem . "</p>";
    ?>
    <!-- Formulario.html / ou form.php -->
    
    <form action="receber.php" method="POST">
        <label>Nome do Estudante:</label>
        <input type="text" name="txtNome">
        <button type="submit">Enviar Dados</button>
    </form>


    <?php
    if (isset($_POST['txtNome'])) {
        $nomeRecebido = $_POST['txtNome'];
        echo "<h3>Dados processados com sucesso no servidor!</h3>";
        echo "<p>Bem-vindo, <strong>" . htmlspecialchars($nomeRecebido) . "</strong>!</p>";
    }
    ?>

    <?php
    $host = "localhost";
    $dbname = "sistema_web";
    $usuario = "postgres";
    $senha = "sua_senha";

    try {
        // Instanciação do objeto PDO para ligação (exemplo com PostgreSQL)
        $conexao = new PDO("pgsql:host=$host;dbname=$dbname", $usuario, $senha);

        // Configuração para lançar exceções em caso de erro
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        echo "Ligação à base de dados estabelecida com sucesso!";

        $nome = "Maria Silva";
        $email = "maria@email.com";

        $sql = "INSERT INTO estudantes (nome, email) VALUES (?, ?)";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$nome, $email]);

        echo "Registo inserido com sucesso!";
    } catch (PDOException $e) {
        echo "Erro na ligação: " . $e->getMessage();
    }
    ?>

    <?php
    $estudantes = null;
    try{
        $conexao = new PDO("pgsql:host=$host;dbname=$dbname", $usuario, $senha);
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Executa a consulta SQL para buscar todos os registos da tabela
        $sql = "SELECT id, nome, email FROM estudantes";
        $stmt = $conexao->query($sql);

        // Transforma os resultados num array associativo para percorrermos facilmente
        $estudantes = $stmt->fetchAll(PDO::FETCH_ASSOC);        
        }catch(PDOException $e) {
            echo "Erro na ligação: " . $e->getMessage();
        }
        
    ?>
</body>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>E-mail</th>
    </tr>
    <?php foreach ($estudantes as $aluno): ?>
        <tr>
            <td><?php echo $aluno['id']; ?></td>
            <td><?php echo htmlspecialchars($aluno['nome']); ?></td>
            <td><?php echo htmlspecialchars($aluno['email']); ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<?php
try{
    $conexao = new PDO("pgsql:host=$host;dbname=$dbname", $usuario, $senha);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $idEstudante = 5;

    $sql = "DELETE FROM estudantes WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->execute([$idEstudante]);

    echo "Registo removido com sucesso!";

}catch(PDOException $e){
    echo "Erro na ligação: " . $e->getMessage();
}
?>


</html>


