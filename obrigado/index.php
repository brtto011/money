<?php
include '../conectarbanco.php';

$conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$sql = "SELECT nome_unico, nome_um, nome_dois FROM app";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    $row = $result->fetch_assoc();


    $nomeUnico = $row['nome_unico'];
    $nomeUm = $row['nome_um'];
    $nomeDois = $row['nome_dois'];

} else {
    return false;
}

$conn->close();
?>


<?php

include './../conectarbanco.php';

$conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

session_start();

if (!isset($_SESSION['email'])) {
    header('Location: /login');
    die();
}

$email = $_SESSION['email'];

$sql = "SELECT url_pago FROM app LIMIT 1"; 

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $urlPago = $row['url_pago'];
} else {
    $urlPago = "Integração não feita";
}    


$sqlTelefone = "SELECT telefone FROM appconfig WHERE email = ?";
$stmtTelefone = $conn->prepare($sqlTelefone);
$stmtTelefone->bind_param("s", $email);
$stmtTelefone->execute();
$resultTelefone = $stmtTelefone->get_result();

if ($resultTelefone->num_rows > 0) {
    $rowTelefone = $resultTelefone->fetch_assoc();
    $phone = $rowTelefone['telefone'];
} else {
    $phone = "Telefone não encontrado";
}

$stmtTelefone->close();  // Feche o statement após usá-lo

// Consulta SQL usando prepared statement para obter nome
$sqlNome = "SELECT nome FROM appconfig WHERE email = ?";
$stmtNome = $conn->prepare($sqlNome);
$stmtNome->bind_param("s", $email);
$stmtNome->execute();
$resultNome = $stmtNome->get_result();

if ($resultNome->num_rows > 0) {
    $rowName = $resultNome->fetch_assoc();
    $name = $rowName['nome'];

    // Certifique-se de que $name seja uma string não vazia
    if (!empty($name) && is_string($name)) {
        $name = trim($name); // Remova espaços em branco extras
    } else {
        // Se o nome for inválido, use um valor padrão
        $name = "Cliente Subway";
    }
} else {
    // Se o nome não for encontrado, use um valor padrão
    $name = "Cliente";
}

$stmtNome->close();  // Feche o statement após usá-lo






// Adicione logs no console
echo "<script>console.log('Enviando para o SMS Funnel - Name: $name, Email: $email, Phone: $phone', URL: $urlPago);</script>";

$data = json_encode([
    'name' => "$name",
    'email' => "$email",
    'phone' => "$phone"
]);

$urlSmsFunnel = "$urlPago?name=$name&email=$email&phone=$phone";

// Inicia a sessão cURL para a segunda URL
$chSmsFunnel = curl_init($urlSmsFunnel);

curl_setopt($chSmsFunnel, CURLOPT_POST, 1);
curl_setopt($chSmsFunnel, CURLOPT_POSTFIELDS, $data);
curl_setopt($chSmsFunnel, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($chSmsFunnel, CURLOPT_RETURNTRANSFER, true);
curl_setopt($chSmsFunnel, CURLOPT_TIMEOUT, 10); // Define um tempo limite de 10 segundos

$responseSmsFunnel = curl_exec($chSmsFunnel);

// Adicione logs no console
if (curl_errno($chSmsFunnel)) {
    echo "<script>console.error('Erro na requisição cURL: " . curl_error($chSmsFunnel) . "');</script>";
} else {
    echo "<script>console.log('Resposta do SMS Funnel: $responseSmsFunnel');</script>";
}

curl_close($chSmsFunnel);

$conn->close();
?>



<?php
session_start(); ?>




<?php
// Iniciar ou resumir a sessão
session_start();

// Obtém o email da sessão
$email = "influencer@mail.com";
$saldo = 1;
?>




<!DOCTYPE html>


<html lang="pt-br" class="w-mod-js w-mod-ix wf-spacemono-n4-active wf-spacemono-n7-active wf-active">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style>
        .wf-force-outline-none[tabindex="-1"]:focus {
            outline: none;
        }
    </style>
    <meta charset="pt-br">
    <title><?= $nomeUnico ?> 🌊 </title>
    <meta property="og:image" content="../img/logo.png">
    <meta content="<?= $nomeUnico ?> 🌊" property="og:title">
    <meta name="twitter:image" content="../img/logo.png">

    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link href="../arquivos/page.css" rel="stylesheet" type="text/css">



    <script type="text/javascript">
        WebFont.load({
            google: {
                families: ["Space Mono:regular,700"]
            }
        });
    </script>




    <link rel="apple-touch-icon" sizes="180x180" href="../img/logo.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../img/logo.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../img/logo.png">


    <link rel="icon" type="image/x-icon" href="../img/logo.png">


    <link rel="stylesheet" href="../arquivos/css" media="all">


<?php
        include '../pixels.php';
        ?>
        

</head>

<body>




<?php
        include '../pixels.php';
        ?>


    <div>


        <section id="hero" class="hero-section dark wf-section">

            <style>
                div.escudo {
                    display: block;
                    width: 247px;
                    line-height: 65px;
                    font-size: 12px;
                    margin: -60px 0 0 0;
                    background-image: url(./arquivos/escudo-branco.png);
                    background-size: contain;
                    background-repeat: no-repeat;
                    background-position: center;
                    filter: drop-shadow(1px 1px 3px #00000099) hue-rotate(0deg);
                }

                div.escudo img {
                    width: 50px;
                    margin: -10px 6px 0 0;
                }
            </style>

            <div class="minting-container w-container" style="margin-top: -20%">
                <div class="escudo">
                    <img src="arquivos/trophy.gif">
                </div>
                <h2>SUCESSO! <br>VAMOS JOGAR?</br> </h2>
                <p class="win-warn"><strong>Caso tenha efetuado o depósito corretamente, seu saldo aparecerá atualizado
                        na próxima página
                    </strong>
                </p>
                <strong>⚠️ Não colida com os obstáculos</strong>
                <strong>❌ Não deixe o policial te pegar</strong>
                <strong>✅ Corra, Pule e Desvie-se</strong>
                <strong style="margin-top: 20px"> ⬇️ Clique no Botão Abaixo</strong>

                <a href="../painel/" class="cadastro-btn">JOGAR</a>

                <style>
                    .win-warn {
                        color: #22C55E;
                    }

                    .cadastro-btn {
                        display: inline-block;
                        margin-top: 20px;
                        padding: 16px 40px;
                        border-style: solid;
                        border-width: 4px;
                        border-color: #1f2024;
                        border-radius: 8px;
                        background-color: #1fbffe;
                        box-shadow: -3px 3px 0 0 #1f2024;
                        -webkit-transition: background-color 200ms ease, box-shadow 200ms ease, -webkit-transform 200ms ease;
                        transition: background-color 200ms ease, box-shadow 200ms ease, -webkit-transform 200ms ease;
                        transition: background-color 200ms ease, transform 200ms ease, box-shadow 200ms ease;
                        transition: background-color 200ms ease, transform 200ms ease, box-shadow 200ms ease, -webkit-transform 200ms ease;
                        font-family: right grotesk, sans-serif;
                        color: #fff;
                        font-size: 1.25em;
                        text-align: center;
                        letter-spacing: .12em;
                        cursor: pointer;
                    }
                </style>

            </div>


            <div id="wins" style="
                display: block;
                width: 240px;
                font-size: 12px;
                padding: 5px 0;
                text-align: center;
                line-height: 13px;
                background-color: #FFC107;
                border-radius: 10px;
                border: 3px solid #1f2024;
                box-shadow: -3px 3px 0 0px #1f2024;
                margin: -24px auto 0 auto;
                z-index: 5;
            ">

                <?php
                function obterNumeroAleatorio()
                {
                    $numeroAleatorio = rand(500, 1000);

                    return $numeroAleatorio;
                }

                $numero = obterNumeroAleatorio();
                ?>


                Usuários Online:<br class="jWQDfMST8B">
                <?php echo $numero; ?>
            </div>



        </section>

        <div style="visibility: visible;">
            <div></div>
            <div>
                <div
                    style="display: flex; flex-direction: column; z-index: 999999; bottom: 88px; position: fixed; right: 16px; direction: ltr; align-items: end; gap: 8px;">
                    <div style="display: flex; gap: 8px;"></div>
                </div>
                <style>
                    @-webkit-keyframes ww-c5d711d7-9084-48ed-a561-d5b5f32aa3a5-launcherOnOpen {
                        0% {
                            -webkit-transform: translateY(0px) rotate(0deg);
                            transform: translateY(0px) rotate(0deg);
                        }

                        30% {
                            -webkit-transform: translateY(-5px) rotate(2deg);
                            transform: translateY(-5px) rotate(2deg);
                        }

                        60% {
                            -webkit-transform: translateY(0px) rotate(0deg);
                            transform: translateY(0px) rotate(0deg);
                        }


                        90% {
                            -webkit-transform: translateY(-1px) rotate(0deg);
                            transform: translateY(-1px) rotate(0deg);

                        }

                        100% {
                            -webkit-transform: translateY(-0px) rotate(0deg);
                            transform: translateY(-0px) rotate(0deg);
                        }
                    }

                    @keyframes ww-c5d711d7-9084-48ed-a561-d5b5f32aa3a5-launcherOnOpen {
                        0% {
                            -webkit-transform: translateY(0px) rotate(0deg);
                            transform: translateY(0px) rotate(0deg);
                        }

                        30% {
                            -webkit-transform: translateY(-5px) rotate(2deg);
                            transform: translateY(-5px) rotate(2deg);
                        }

                        60% {
                            -webkit-transform: translateY(0px) rotate(0deg);
                            transform: translateY(0px) rotate(0deg);
                        }


                        90% {
                            -webkit-transform: translateY(-1px) rotate(0deg);
                            transform: translateY(-1px) rotate(0deg);

                        }

                        100% {
                            -webkit-transform: translateY(-0px) rotate(0deg);
                            transform: translateY(-0px) rotate(0deg);
                        }
                    }

                    @keyframes ww-c5d711d7-9084-48ed-a561-d5b5f32aa3a5-widgetOnLoad {
                        0% {
                            opacity: 0;
                        }

                        100% {
                            opacity: 1;
                        }
                    }

                    @-webkit-keyframes ww-c5d711d7-9084-48ed-a561-d5b5f32aa3a5-widgetOnLoad {
                        0% {
                            opacity: 0;
                        }

                        100% {
                            opacity: 1;
                        }
                    }

                    </st></div></div></body></html>