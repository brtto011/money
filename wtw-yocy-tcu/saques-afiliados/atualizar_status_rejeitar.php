<?php
include './../../conectarbanco.php';

$conn = new mysqli('localhost', $config['db_user'], $config['db_pass'], $config['db_name']);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$email = $_POST['email'];
$pix = $_POST['pix'];
$status = $_POST['status'];
$external_reference = $_POST['external_reference'];

// Execute a atualização no banco de dados
$sql = "UPDATE saque_afiliado SET status = '$status' WHERE external_reference = '$external_reference'";

if ($conn->query($sql) === TRUE) {
    echo "Status atualizado com sucesso para Rejeitado.";
} else {
    echo "Erro ao atualizar o status: " . $conn->error;
}

$conn->close();
?>
