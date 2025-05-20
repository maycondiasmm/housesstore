<?php
session_start();

// Verifica se o utilizador está logado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Verifica o tipo de utilizador (admin ou cliente)
$isAdmin = ($_SESSION['role'] === 'admin');
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Área do Utilizador</title>
</head>
<body>
    <h2>Bem-vindo, <?php echo $_SESSION['username']; ?>!</h2>

    <!-- Conteúdo comum a todos os utilizadores -->
    <p>Esta é a sua área pessoal.</p>

    <!-- Separador Administrativo (visível apenas para administradores) -->
    <?php if ($isAdmin): ?>
        <h3>Área Administrativa</h3>
        <ul>
            <li><a href="manage_users.php">Gerir Utilizadores</a></li>
            <li><a href="manage_news.php">Gerir Notícias</a></li>
            <li><a href="manage_projects.php">Gerir Projetos</a></li>
        </ul>
    <?php endif; ?>

    <a href="logout.php">Sair</a>
</body>
</html>