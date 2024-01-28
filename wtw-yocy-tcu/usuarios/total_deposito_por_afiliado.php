<?php
// Conectar ao seu banco de dados
include './../../conectarbanco.php';

$conn = new mysqli('localhost', $config['db_user'], $config['db_pass'], $config['db_name']);

// Verificar a conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Obter o número do afiliado do parâmetro
$numeroAfiliado = $_POST['numeroAfiliado'];

// Consulta SQL para somar a coluna 'depositou' para o número do afiliado especificado
$sql = "SELECT SUM(depositou) as totalDepositos FROM appconfig WHERE afiliado = '$numeroAfiliado'";

$result = $conn->query($sql);

if ($result) {
    // Retornar o resultado diretamente
    $row = $result->fetch_assoc();
    $totalDepositos = $row['totalDepositos'];

    echo $totalDepositos;
} else {
    // Tratar erros de consulta, se necessário
    echo 'Erro na consulta SQL';
}

$conn->close();

