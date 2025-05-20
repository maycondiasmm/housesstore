<?php
session_start();
include 'db_connection.php';

// Verifica se o utilizador está logado e é um cliente
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['funcao'] !== 'utilizador') {
    header("Location: login.php");
    exit;
}

// Processa o formulário de solicitação de consulta
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['solicitar_consulta'])) {
    $cliente_id = $_SESSION['id'];
    $data_consulta = $_POST['data_consulta'];
    $observacoes = $_POST['observacoes'];

    // Verifica se a data é válida
    if (new DateTime($data_consulta) <= new DateTime()) {
        echo "A data da consulta deve ser uma data futura.";
    } else {
        // Insere a consulta na base de dados
        $insert = $conn->prepare("INSERT INTO Consultas (cliente_id, data_consulta, observacoes) VALUES (?, ?, ?)");
        $insert->bind_param("iss", $cliente_id, $data_consulta, $observacoes);

        if ($insert->execute()) {
            echo "Consulta solicitada com sucesso!";
        } else {
            echo "Erro ao solicitar a consulta.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Solicitar Consulta</title>
</head>
<body>
    <h2>Solicitar Consulta</h2>
    <form method="POST" action="solicitar_consulta.php">
        <label for="data_consulta">Data da Consulta:</label>
        <input type="datetime-local" name="data_consulta" required><br>

        <label for="observacoes">Observações:</label>
        <textarea name="observacoes" rows="4" required></textarea><br>

        <button type="submit" name="solicitar_consulta">Solicitar Consulta</button>
    </form>
</body>
</html>