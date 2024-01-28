<?php
include './../../conectarbanco.php';

$conn = new mysqli('localhost', $config['db_user'], $config['db_pass'], $config['db_name']);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Receba os dados da solicitação AJAX
$external_reference = $_POST['external_reference'];
$status = $_POST['status'];

$atualizarStatus = "UPDATE saques SET status = '$status' WHERE externalreference = '$external_reference'";

if ($conn->query($atualizarStatus) === TRUE) {
    echo "Status atualizado com sucesso e saldo deduzido.";
} else {
    echo "Erro ao atualizar o status: " . $conn->error;
}

$conn->close();
