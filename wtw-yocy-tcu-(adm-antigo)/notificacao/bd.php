<?php
include './../../conectarbanco.php';

$conn = new mysqli('localhost', $config['db_user'], $config['db_pass'], $config['db_name']);

// Verificar a conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $canalID = $_POST["canalID"];
   

    // Verificar se já existe uma linha na tabela
    $checkSql = "SELECT * FROM notificacao LIMIT 1";
    $result = $conn->query($checkSql);

    if ($result->num_rows > 0) {
        // Se existe, atualizar os valores
        $updateSql = "UPDATE notificacao SET canal_id = '$canalID' LIMIT 1";

        if ($conn->query($updateSql) === TRUE) {
            echo "Sucesso: Valores atualizados com sucesso!";
        } else {
            echo "Erro ao atualizar: " . $conn->error;
        }
    } else {
        // Se não existe, inserir uma nova linha
        $insertSql = "INSERT INTO notificacao (canal_id) VALUES ('$canalID')";

        if ($conn->query($insertSql) === TRUE) {
            echo "Sucesso: Nova linha adicionada!";
        } else {
            echo "Erro ao inserir: " . $conn->error;
        }
    }
}

$canal_id = '';

// Consulta SQL para obter client_id e client_secret da tabela notificacao
$sql = "SELECT canal_id FROM notificacao LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Obter o resultado como um array associativo
    $row = $result->fetch_assoc();

    // Atribuir os valores a variáveis
    $canal_id = $row['canal_id'];

}

$conn->close();
?>
