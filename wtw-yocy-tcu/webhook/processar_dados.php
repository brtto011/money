<?php
include './../conectarbanco.php';

$conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$urlCadastro = $_POST['url_cadastro'];
$urlPixGerado = $_POST['url_gerado'];
$urlPixPago = $_POST['url_pago'];

// Adicionando verificação para garantir que as variáveis não estejam vazias
if (empty($urlCadastro) || empty($urlPixGerado) || empty($urlPixPago)) {
    die("Erro: Algumas variáveis estão vazias.");
}

$sql = "UPDATE app SET url_cadastro = ?, url_gerado = ?, url_pago = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Erro na preparação da consulta: " . $conn->error);
}

$stmt->bind_param("sss", $urlCadastro, $urlPixGerado, $urlPixPago);
$result = $stmt->execute();

if (!$result) {
    die("Erro na execução da consulta: " . $stmt->error);
}

$stmt->close();
$conn->close();

echo "Dados atualizados com sucesso!";
?>
