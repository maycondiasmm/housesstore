<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form action="login_process.php" method="POST">
        <label for="username">Nome de Utilizador:</label>
        <input type="text" name="username" required><br>
        <label for="password">Senha:</label>
        <input type="password" name="password" required><br>
        <button type="submit">Entrar</button>
    </form>
</body>
</html>