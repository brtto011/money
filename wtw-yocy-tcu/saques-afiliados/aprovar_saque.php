<?php
 include './../../conectarbanco.php';

$conn = new mysqli('localhost', $config['db_user'], $config['db_pass'], $config['db_name']);

// Verificar a conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Obtém as credenciais do gateway
$client_id = '';
$client_secret = '';

$sql = "SELECT client_id, client_secret FROM gateway";
$result = $conn->query($sql);
if ($result) {
    $row = $result->fetch_assoc();
    if ($row) {
        $client_id = $row['client_id'];
        $client_secret = $row['client_secret'];
    }
} else {
    // Tratar caso ocorra um erro na consulta
    die("Erro na consulta SQL: " . $conn->error);
}



$apiUrl = 'https://ws.suitpay.app/api/v1/gateway/pix-payment';

// Obtenha os dados da requisição POST
$requestData = json_decode($_POST['requestData'], true);
$externalreference = $_POST['externalreference'];
$email = $_POST['email'];

// Lógica para realizar a chamada ao endpoint de pagamento PIX
$requestData = json_encode($requestData);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
   "Content-Type: application/json",
        "ci: $client_id",
        "cs: $client_secret"
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Lógica para lidar com a resposta da chamada ao endpoint PIX
if ($httpCode === 200) {
    // Saque aprovado
    echo 'Saque aprovado: ' . $response;
} else {
    // Erro ao aprovar o saque
    http_response_code($httpCode);
    echo 'Erro ao aprovar o saque: ' . $response;
}
?>
