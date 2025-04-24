<?php
session_start();
if (!isset($_SESSION['nome'])) {
    header("Location: login.php");
    exit();
}
include 'conexao.php';

// Pega os filtros de data se existirem
$data_inicio = isset($_GET['data_inicio']) ? $_GET['data_inicio'] : '';
$data_fim = isset($_GET['data_fim']) ? $_GET['data_fim'] : '';

// Monta a consulta SQL com ou sem filtro
$sql = "SELECT * FROM pedido";
if (!empty($data_inicio) && !empty($data_fim)) {
    $sql .= " WHERE data_pedido BETWEEN '$data_inicio 00:00:00' AND '$data_fim 23:59:59'";
}
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pedidos - Cali Burger</title>
    <link rel="stylesheet" href="main.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="icon" href="imagens/logo_cali_ico.png" type="image/png">
    <link rel="icon" href="imagens/logo_cali_ico.ico" type="image/x-icon" />
</head>
<body>

<?php include 'menu.php'; ?>

<div class="container">
    <h2>Pedidos Realizados</h2>

    <div class="filter-container">
        <form method="get" action="">
            <label for="data_inicio">De:</label>
            <input type="date" name="data_inicio" id="data_inicio" value="<?= $data_inicio ?>">

            <label for="data_fim">Até:</label>
            <input type="date" name="data_fim" id="data_fim" value="<?= $data_fim ?>">

            <button type="submit">Filtrar</button>
        </form>
    </div>

    <table class="styled-table">
        <thead>
            <tr>
                <th>Nº Pedido</th>
                <th>Produto</th>
                <th>Valor (R$)</th>
                <th>Cliente</th>
                <th>Aceito</th>
                <th>Observação</th>
                <th>Data do Pedido</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['numero_do_pedido'] ?></td>
                    <td><?= $row['produto'] ?></td>
                    <td><?= number_format($row['valor'], 2, ',', '.') ?></td>
                    <td><?= $row['nome_cliente'] ?></td>
                    <td><?= $row['aceito'] ? 'Sim' : 'Não' ?></td>
                    <td><?= $row['observacao'] ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($row['data_pedido'])) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
