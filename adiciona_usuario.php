<?php
include 'conexao.php';

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

$stmt = $conn->prepare("INSERT INTO cliente (login, email, senha) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nome, $email, $senha);
$stmt->execute();

header("Location: main.php");
exit();
?>
