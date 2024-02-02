<?php

function apagarRegistro($conn, $slug)
{
    $email = $_SESSION['email'];
    $sqlDelete = "DELETE FROM deposito_gerado WHERE email = '$email' AND slug = '$slug'";
    $conn->query($sqlDelete);
}

try {
    include './../conectarbanco.php';

    $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }
    session_start();

    $email = $_SESSION['email'];
    $brtTimeZone = new DateTimeZone('America/Sao_Paulo');
    $sqlSelect = "SELECT slug, data, email FROM deposito_gerado WHERE email = '$email'";
    $result = $conn->query($sqlSelect);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            apagarRegistro($conn, $row['slug']);
        }

        // Enviar resposta JSON indicando sucesso
        $response = ['success' => true];
        echo json_encode($response);
    } else {
        // Enviar resposta JSON indicando falha (se necessário)
        $response = ['success' => false, 'error' => 'Nenhum registro encontrado'];
        echo json_encode($response);
    }

    $conn->close();
} catch (Exception $ex) {
    // Enviar resposta JSON indicando falha em caso de exceção
    $response = ['success' => false, 'error' => $ex->getMessage()];
    echo json_encode($response);

    http_response_code(200);
    exit;
}
?>
