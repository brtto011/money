<?php
include './../../conectarbanco.php';

$conn = new mysqli('localhost', $config['db_user'], $config['db_pass'], $config['db_name']);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$email = $_POST['email'];
$valor = $_POST['valor'];
// Receba os dados da solicitação AJAX
$pix = $_POST['pix'];
$status = $_POST['status'];

// Consulta para obter o saldo atual
$saldoConsulta = "SELECT saldo_comissao FROM appconfig WHERE email = '$email'";
$resultadoSaldo = $conn->query($saldoConsulta);

if ($resultadoSaldo > 0) {
    $rowSaldo = $resultadoSaldo->fetch_assoc();
    $saldoAtual = $rowSaldo['saldo_comissao'];
    // Verificar se há saldo suficiente antes de atualizar o status
    if ($saldoAtual >= $valor){
        
        $novoSaldo = $saldoAtual - $valor;
        $atualizarSaldo = "UPDATE appconfig SET saldo_comissao = '$novoSaldo' WHERE email = '$email'";
        
        // Executar a atualização do saldo
        if ($conn->query($atualizarSaldo) === TRUE) {
            // Execute a atualização no banco de dados
            $sql = "UPDATE saque_afiliado SET status = '$status' WHERE pix = '$pix'";
            
            if ($conn->query($sql) === TRUE) {
                echo "Status atualizado com sucesso";
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
