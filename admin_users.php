<?php
session_start();
include 'db_connection.php';

// Verifica se o utilizador está logado e é um administrador
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['funcao'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Obter todos os utilizadores
$query = "SELECT * FROM Utilizadores";
$result = $conn->query($query);

// Atualizar dados de um utilizador selecionado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_user'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $apelido = $_POST['apelido'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $funcao = $_POST['funcao'];

    $update = $conn->prepare("UPDATE Utilizadores SET nome = ?, apelido = ?, email = ?, telefone = ?, funcao = ? WHERE id = ?");
    $update->bind_param("sssssi", $nome, $apelido, $email, $telefone, $funcao, $id);

    if ($update->execute()) {
        echo "Utilizador atualizado com sucesso!";
        header("Refresh:0");
    } else {
        echo "Erro ao atualizar o utilizador.";
    }
}

// Excluir um utilizador
if (isset($_GET['delete_user'])) {
    $id = $_GET['delete_user'];
    $delete = $conn->prepare("DELETE FROM Utilizadores WHERE id = ?");
    $delete->bind_param("i", $id);
    $delete->execute();
    header("Location: admin_users.php");
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Administração de Utilizadores</title>
</head>
<body>
    <h2>Administração de Utilizadores</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Apelido</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Função</th>
            <th>Ações</th>
        </tr>
        <?php while ($user = $result->fetch_assoc()): ?>
        <tr>
            <form method="POST" action="admin_users.php">
                <td><?php echo $user['id']; ?></td>
                <td><input type="text" name="nome" value="<?php echo htmlspecialchars($user['nome']); ?>"></td>
                <td><input type="text" name="apelido" value="<?php echo htmlspecialchars($user['apelido']); ?>"></td>
                <td><input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"></td>
                <td><input type="text" name="telefone" value="<?php echo htmlspecialchars($user['telefone']); ?>"></td>
                <td>
                    <select name="funcao">
                        <option value="utilizador" <?php if ($user['funcao'] == 'utilizador') echo 'selected'; ?>>Utilizador</option>
                        <option value="admin" <?php if ($user['funcao'] == 'admin') echo 'selected'; ?>>Administrador</option>
                    </select>
                </td>
                <td>
                    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                    <button type="submit" name="update_user">Atualizar</button>
                    <a href="admin_users.php?delete_user=<?php echo $user['id']; ?>">Excluir</a>
                </td>
            </form>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>