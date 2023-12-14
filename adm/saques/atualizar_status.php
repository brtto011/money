<?php
include './../../conectarbanco.php';

$conn = new mysqli('localhost', $config['db_user'], $config['db_pass'], $config['db_name']);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Receba os dados da solicitação AJAX
$external_reference = $_POST['external_reference'];
$status = $_POST['status'];
$email = $_POST['email'];
$valor = $_POST['valor'];

// Consulta para obter o saldo atual
$saldoConsulta = "SELECT saldo FROM app_config WHERE email = '$email' LIMIT 1";
$resultadoSaldo = $conn->query($saldoConsulta);

if ($resultadoSaldo && $resultadoSaldo->num_rows > 0) {
    $rowSaldo = $resultadoSaldo->fetch_assoc();
    $saldoAtual = $rowSaldo['saldo'];

    // Verificar se há saldo suficiente antes de atualizar o status
    if ($saldoAtual >= $valor) {
        // Atualizar o saldo subtraindo o valor sacado
        $novoSaldo = $saldoAtual - $valor;
        $atualizarSaldo = "UPDATE app_config SET saldo = '$novoSaldo' WHERE email = '$email'";

        // Executar a atualização do saldo
        if ($conn->query($atualizarSaldo) === TRUE) {
            // Atualizar o status na tabela de saques
            $atualizarStatus = "UPDATE saques SET status = '$status' WHERE externalreference = '$external_reference'";

            if ($conn->query($atualizarStatus) === TRUE) {
                echo "Status atualizado com sucesso e saldo deduzido.";
            } else {
                echo "Erro ao atualizar o status: " . $conn->error;
            }
        } else {
            echo "Erro ao deduzir o valor do saldo: " . $conn->error;
        }
    } else {
        echo "Saldo insuficiente para completar a transação.";
    }
} else {
    echo "Erro ao obter o saldo: " . $conn->error;
}

$conn->close();
?>
