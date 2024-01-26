<?php
include './../../conectarbanco.php';

$conn = new mysqli('localhost', $config['db_user'], $config['db_pass'], $config['db_name']);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$status = $_POST['status'];
$externalreference = $_POST['externalreference'];

// Execute a atualização no banco de dados
$sql = "UPDATE saque_afiliado SET status = '$status' WHERE externalreference = '$externalreference'";

if ($conn->query($sql) === TRUE) {
    echo "Status atualizado com sucesso para Rejeitado.";
} else {
    echo "PHP Erro ao atualizar o status: " . $conn->error;
}

$conn->close();
?>
