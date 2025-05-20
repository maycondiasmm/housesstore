<?php
session_start();
include 'db_connection.php';

// Verifica se o utilizador está logado e é um cliente
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['funcao'] !== 'utilizador') {
    header("Location: login.php");
    exit;
}

// Obter consultas do cliente logado
$cliente_id = $_SESSION['id'];
$query = $conn->prepare("SELECT * FROM Consultas WHERE cliente_id = ?");
$query->bind_param("i", $cliente_id);
$query->execute();
$result = $query->get_result();

// Modificar uma consulta
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['modificar_consulta'])) {
    $consulta_id = $_POST['id'];
    $nova_data = $_POST['data_consulta'];
    
    // Verifica se a data é válida
    if (new DateTime($nova_data) <= new DateTime()) {
        echo "A nova data da consulta deve ser uma data futura.";
    } else {
        // Verifica se a data está dentro do prazo de modificação
        $consulta_query = $conn->prepare("SELECT data_consulta FROM Consultas WHERE id = ?");
        $consulta_query->bind_param("i", $consulta_id);
        $consulta_query->execute();
        $consulta_result = $consulta_query->get_result()->fetch_assoc();
        
        $data_consulta_original = new DateTime($consulta_result['data_consulta']);
        $data_atual = new DateTime();
        $intervalo = $data_consulta_original->diff($data_atual);

        if ($intervalo->days <= 3 && $intervalo->invert === 0) {
            echo "A data da consulta só pode ser alterada até 72 horas antes da consulta.";
        } else {
            // Atualiza a consulta na base de dados
            $update = $conn->prepare("UPDATE Consultas SET data_consulta = ? WHERE id = ?");
            $update->bind_param("si", $nova_data, $consulta_id);

            if ($update->execute()) {
                echo "Consulta alterada com sucesso!";
            } else {
                echo "Erro ao alterar a consulta.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Minhas Consultas</title>
</head>
<body>
    <h2>Minhas Consultas</h2>
    <?php while ($consulta = $result->fetch_assoc()): ?>
    <form method="POST" action="minhas_consultas.php">
        <p>
            <strong>Data da Consulta:</strong> <?php echo htmlspecialchars($consulta['data_consulta']); ?><br>
            <strong>Observações:</strong> <?php echo htmlspecialchars($consulta['observacoes']); ?>
        </p>
        <?php
        $data_atual = new DateTime();
        $data_consulta = new DateTime($consulta['data_consulta']);
        $intervalo = $data_consulta->diff($data_atual);
        ?>
        <?php if ($intervalo->days > 3 || $intervalo->invert === 1): ?>
        <label for="data_consulta">Nova Data da Consulta:</label>
        <input type="datetime-local" name="data_consulta" required><br>
        <input type="hidden" name="id" value="<?php echo $consulta['id']; ?>">
        <button type="submit" name="modificar_consulta">Modificar Consulta</button>
        <?php endif; ?>
    </form>
    <hr>
    <?php endwhile; ?>
</body>
</html>