<?php
include 'db_connection.php';

// Processa o formulário de registo
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $apelido = $_POST['apelido'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $nome_utilizador = $_POST['nome_utilizador'];
    $senha = $_POST['senha'];
    $funcao = 'utilizador'; // Define a função padrão como 'utilizador'

    // Verifica se o nome de utilizador já existe
    $check_user = $conn->prepare("SELECT * FROM Utilizadores WHERE nome_utilizador = ?");
    $check_user->bind_param("s", $nome_utilizador);
    $check_user->execute();
    $check_user->store_result();

    if ($check_user->num_rows > 0) {
        echo "Nome de utilizador já existe. Por favor, escolha outro.";
    } else {
        // Encripta a senha utilizando password_hash
        $senha_encriptada = password_hash($senha, PASSWORD_BCRYPT);

        // Insere o novo utilizador na base de dados
        $insert = $conn->prepare("INSERT INTO Utilizadores (nome, apelido, email, telefone, nome_utilizador, senha_encriptada, funcao) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $insert->bind_param("sssssss", $nome, $apelido, $email, $telefone, $nome_utilizador, $senha_encriptada, $funcao);

        if ($insert->execute()) {
            echo "Registo concluído com sucesso!";
        } else {
            echo "Erro ao registar o utilizador.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Registo de Utilizador</title>
</head>
<body>
    <h2>Registo de Utilizador</h2>
    <form method="POST" action="register.php">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" required><br>

        <label for="apelido">Apelido:</label>
        <input type="text" name="apelido" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <label for="telefone">Telefone:</label>
        <input type="text" name="telefone"><br>

        <label for="nome_utilizador">Nome de Utilizador:</label>
        <input type="text" name="nome_utilizador" required><br>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" required><br>

        <button type="submit">Registar</button>
    </form>
</body>
</html>