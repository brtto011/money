<?php
include './../../conectarbanco.php';

// Verificar a conexão
$conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);

if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Receber os dados do AJAX
$afiliadoPix = $_POST['pix'];
$email = $_POST['email'];
$valor = $_POST['valor'];
$nome = $_POST['nome'];
$data = $_POST['data'];
$status = $_POST['status'];
$externalreference = $_POST['externalreference'];

// Preparar e executar a instrução SQL para inserir dados
$sql = "INSERT INTO extrato_saque_afiliado (email, nome, pix, valor, status, externalreference, data) 
        VALUES ('$email', '$nome', '$afiliadoPix', '$valor', '$status', '$externalreference', '$data')";

if ($conn->query($sql) === TRUE) {
    echo "Extrato inserido com sucesso!";
} else {
    echo "PHP Erro ao inserir registro: " . $conn->error;
}

// Fechar a conexão
$conn->close();
?>
