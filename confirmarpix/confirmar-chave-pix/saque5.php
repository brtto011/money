<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['cpf'])) {
        $cpf = $_POST['cpf'];

        $curl = curl_init();

        $data = array(
            "value" => 0.10,
            "key" => $cpf,
            "typeKey" => "document"
        );

        $jsonData = json_encode($data);

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://ws.suitpay.app/api/v1/gateway/pix-payment',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $jsonData,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'ci: joaovecmm_1703093538802',
                'cs: 38ab97fef9ae972290df7dda9430f29ede955f9a0c49412fa3eaf9b0ae89a45af75793a309be42428e7b24ca69b6d642'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        echo "Resposta da transação: " . $response;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulário de Pagamento</title>
</head>
<body>
    <form method="post">
        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" required><br><br>
        <input type="submit" value="Pagar">
    </form>
</body>
</html>
