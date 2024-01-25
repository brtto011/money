<?php
include './../conectarbanco.php';

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
// Conectar ao banco de dados
include './../conectarbanco.php';

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
}

$conn->close();
?>



<?php
// Obter a URL
$baseUrl = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$baseUrl .= "://" . $_SERVER['HTTP_HOST'];


$staticPart = '/webhook_taxa_saque/pix.php';

$callbackUrl = $baseUrl . $staticPart;



echo '<script>';
echo 'console.log("Callback URL:", ' . json_encode($callbackUrl) . ');'; // Adicione esta linha para depurar
echo 'var callbackUrl = ' . json_encode($callbackUrl) . ';';
echo '</script>';
?>





<?php
// Conectar ao banco de dados
include './../conectarbanco.php';

$conn = new mysqli('localhost', $config['db_user'], $config['db_pass'], $config['db_name']);

// Verificar a conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}



// Iniciar a sessão
session_start();

// Obter o email e jogoteste da sessão
$email = $_SESSION['email'];  // ajuste conforme a sua lógica de sessão
$jogoteste = $_SESSION['jogoteste'];  // ajuste conforme a sua lógica de sessão

$sql = "SELECT * FROM appconfig WHERE email = '$email' AND (jogoteste IS NULL OR jogoteste != 1)";
$result = $conn->query($sql);

if ($result->num_rows > 0) {


    // Atualizar a coluna jogoteste para 1
    $updateSql = "UPDATE appconfig SET jogoteste = 1 WHERE email = '$email'";
    $conn->query($updateSql);
} else {
    // Se jogoteste já for 1, não fazer nada
}


$conn->close();
?>




<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../login");
    echo 'não logado';
    exit();
}

$email = $_SESSION['email'];

function get_conn()
{
    include './../conectarbanco.php';

    return new mysqli('localhost', $config['db_user'], $config['db_pass'], $config['db_name']);
}

function get_form()
{
    return array(
        'name' => $_POST['name'],
        'cpf' => $_POST['document'],
        'value' => $_POST['valor_transacao'],
    );
}

function validate_form($form)
{
    global $depositoMinimo;

    $errors = array();

    if (empty($form['name'])) {
        $errors['name'] = 'O nome é obrigatório';
    }

    if (empty($form['cpf'])) {
        $errors['cpf'] = 'O CPF é obrigatório';
    }

    if (empty($form['value'])) {
        $errors['value'] = 'O valor é obrigatório';
    } else if ($form['value'] < $depositoMinimo) {
        $errors['value'] = 'O valor mínimo é de R$ ' . $depositoMinimo;
    }

    return $errors;
}
function make_request($url, $payload, $method = 'POST')
{
    global $client_id, $client_secret;

    $headers = array(
        "Content-Type: application/json",
        "ci: $client_id",
        "cs: $client_secret"
    );

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function make_rand_num($length = 15)
{
    $result = '';
    for ($i = 0; $i < $length; $i++) {
        $result .= mt_rand(0, 9);
    }
    return $result;
}

function make_pix($name, $cpf, $value)
{

    $baseUrl = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $baseUrl .= "://" . $_SERVER['HTTP_HOST'];


    $staticPart = '/webhook_taxa_saque/pix.php';

    $callbackUrl = $baseUrl . $staticPart;



    $dueDate = date('Y-m-d', strtotime('+1 day'));
    $email = 'cliente@email.com';

    $payload = array(
        'requestNumber' => '12356',
        'dueDate' => $dueDate,
        'amount' => floatval($value),
        'client' => array(
            'name' => $name,
            'email' => $email,
            'document' => $cpf,
        ),


        'callbackUrl' => $callbackUrl
    );

    $url = 'https://ws.suitpay.app/api/v1/gateway/request-qrcode';
    $method = 'POST';

    $response = make_request($url, $payload, $method);

    return json_decode($response, true);
}

# check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $form = get_form();
    $errors = validate_form($form);

    if (count($errors) > 0) {
        http_redirect('../taxa_saque', $errors);
        exit;
    }

    $res = make_pix(
        $form['name'],
        $form['cpf'],
        $form['value']
    );

    if ($res['response'] === 'OK') {
        $conn = get_conn();

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        try {

            // Adiciona a coluna 'data' e obtém a data atual no formato dd/mm/aaaa hh:mm:ss, no horário de Brasília
            $brtTimeZone = new DateTimeZone('America/Sao_Paulo');
            $dateTime = new DateTime('now', $brtTimeZone);
            $userDate = $dateTime->format('d/m/Y H:i');

            $sql = sprintf(
                "INSERT INTO confirmar_deposito (email, valor, externalreference, status, data) VALUES ('%s', '%s', '%s', '%s', '%s')",
                $email,
                $form['value'],
                $res['idTransaction'],
                'WAITING_FOR_APPROVAL',
                $userDate
            );

            $conn->query($sql);
            $conn->close();
        } catch (Exception $ex) {
            var_dump($ex);
            http_response_code(200);
            exit;
        }

        $paymentCode = $res['paymentCode'];
        // Send QR Code to another page
        // var qrCodeUrl = 'pix.php?pix_key=' + encodeURIComponent(data.paymentCode);
        header("Location: ../taxa_saque/pix.php?pix_key=" . $paymentCode . '&token=' . $res['idTransaction']);

    } else {
        header('Location: ../taxa_saque');
    }
    exit;
}
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
    <title>
        <?= $nomeUnico ?> 🌊
    </title>

    <meta property="og:image" content="../img/logo.png">

    <meta content="<?= $nomeUnico ?> 🌊" property="og:title">


    <meta name="twitter:image" content="../img/logo.png">
    <meta content="<?= $nomeUnico ?> 🌊" property="twitter:title">
    <meta property="og:type" content="website">
    <meta content="summary_large_image" name="twitter:card">
    <meta content="width=device-width, initial-scale=1" name="viewport">



    <link href="arquivos/page.css" rel="stylesheet" type="text/css">




    <script type="text/javascript">
        WebFont.load({
            google: {
                families: ["Space Mono:regular,700"]
            }
        });
    </script>


    <script type="text/javascript">
        ! function (o, c) {
            var n = c.documentElement,
                t = " w-mod-";
            n.className += t + "js", ("ontouchstart" in o || o.DocumentTouch && c instanceof DocumentTouch) && (n
                .className += t + "touch")
        }(window, document);
    </script>
    <link rel="apple-touch-icon" sizes="180x180" href="../img/logo.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../img/logo.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../img/logo.png">

    <link rel="icon" type="image/x-icon" href="../img/logo.png">



    <link rel="stylesheet" href="arquivos/css" media="all">

    <?php
    include '../pixels.php';
    ?>


</head>

<body>


    <?php
    include '../pixels.php';
    ?>
    <div>
        <div data-collapse="small" data-animation="default" data-duration="400" role="banner" class="navbar w-nav">
            <div class="container w-container">

                <a href="/painel" aria-current="page" class="brand w-nav-brand" aria-label="home">

                    <img src="arquivos/l2.png" loading="lazy" height="28" alt="" class="image-6">

                    <div class="nav-link logo">
                        <?= $nomeUnico ?>
                    </div>
                </a>
                <nav role="navigation" class="nav-menu w-nav-menu">
                    <a href="../painel" class="nav-link w-nav-link" style="max-width: 940px;">Jogar</a>

                    <a href="../saque/" class="nav-link w-nav-link" style="max-width: 940px;">Saque</a>

                    <a href="../afiliate/" class="nav-link w-nav-link" style="max-width: 940px;">Indique e Ganhe</a>

                    <a href="../logout.php" class="nav-link w-nav-link" style="max-width: 940px;">Sair</a>
                    <a href="../deposito/" class="button nav w-button w--current">Depositar</a>
                </nav>



                <style>
                    .nav-bar {
                        display: none;
                        background-color: #333;
                        /* Cor de fundo do menu */
                        padding: 20px;
                        /* Espaçamento interno do menu */
                        width: 90%;
                        /* Largura total do menu */

                        position: fixed;
                        /* Fixa o menu na parte superior */
                        top: 0;
                        left: 0;
                        z-index: 1000;
                        /* Garante que o menu está acima de outros elementos */
                    }

                    .nav-bar a {
                        color: white;
                        /* Cor dos links no menu */
                        text-decoration: none;
                        padding: 10px;
                        /* Espaçamento interno dos itens do menu */
                        display: block;
                        margin-bottom: 10px;
                        /* Espaçamento entre os itens do menu */
                    }

                    .nav-bar a.login {
                        color: white;
                        /* Cor do texto para o botão Login */
                    }

                    .button.w-button {
                        text-align: center;
                    }
                </style>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        var menuButton = document.querySelector('.menu-button');
                        var navBar = document.querySelector('.nav-bar');

                        menuButton.addEventListener('click', function () {
                            // Toggle the visibility of the navigation bar
                            if (navBar.style.display === 'block') {
                                navBar.style.display = 'none';
                            } else {
                                navBar.style.display = 'block';
                            }
                        });
                    });
                </script>







                <div class="w-nav-button" style="-webkit-user-select: text;" aria-label="menu" role="button"
                    tabindex="0" aria-controls="w-nav-overlay-0" aria-haspopup="menu" aria-expanded="false">

                </div>
                <div class="menu-button w-nav-button" style="-webkit-user-select: text;" aria-label="menu" role="button"
                    tabindex="0" aria-controls="w-nav-overlay-0" aria-haspopup="menu" aria-expanded="false">
                    <div class="icon w-icon-nav-menu"></div>
                </div>
            </div>
            <div class="w-nav-overlay" data-wf-ignore="" id="w-nav-overlay-0"></div>
        </div>
        <div class="nav-bar">
            <a href="../painel/" class="button w-button w--current">
                <div>Jogar</div>
            </a>
            <a href="../saque/" class="button w-button w--current">
                <div>Saque</div>
            </a>

            </a>
            <a href="../afiliate/" class="button w-button w--current">
                <div>Indique & Ganhe</div>
            </a>
            <a href="../logout.php" class="button w-button w--current">
                <div>Sair</div>
            </a>
            <a href="../deposito/" class="button w-button w--current">Depositar</a>
        </div>

        <section id="hero" class="hero-section dark wf-section">
            <div class="minting-container w-container">


                <h2>TAXA DE SAQUE</h2>









                <?php
                include './../conectarbanco.php';

                $conn = new mysqli('localhost', $config['db_user'], $config['db_pass'], $config['db_name']);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT deposito_min FROM app LIMIT 1";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $depositoMinimo = $row["deposito_min"];
                } else {
                    $depositoMinimo = 2; // Valor padrão caso não seja encontrado no banco
                }

                $conn->close();
                ?>




                <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>


                <form action="/taxa_saque/index.php" method="POST">
                    <div class="properties">
                        <h4 class="rarity-heading">NOME</h4>
                        <div class="rarity-row roboto-type2">
                            <input class="large-input-field w-input" type="text" placeholder="Seu nome" id="name"
                                name="name" required><br>
                        </div>
                        <h4 class="rarity-heading">CPF</h4>
                        <div class="rarity-row roboto-type2">
                            <input class="large-input-field w-input" maxlength="11" placeholder="Seu número de CPF"
                                type="text" id="document" name="document" oninput="formatarCPF(this)" required><br>
                        </div>














                        <style>
                            .expandable-content {
                                max-height: 0;
                                overflow: hidden;
                                transition: max-height 0.3s ease-out;
                                margin-top: 10px;
                            }

                            .arrow-icon {
                                cursor: pointer;
                                display: inline-block;
                                margin-left: 5px;
                                transition: transform 0.3s ease-in-out;
                                user-select: none;
                            }

                            .expanded {
                                transform: rotate(90deg);
                            }

                            /* Adicionando cursor pointer e cor diferente ao hover da rarity-row */
                            .rarity-row {
                                cursor: pointer;
                                user-select: none;
                            }

                            .rarity-row:hover {
                                background-color: #f5f5f5;
                            }
                        </style>


                        <script>
                            document.addEventListener("DOMContentLoaded", function () {
                                var rarityRows = document.querySelectorAll('.rarity-row');
                                var taxaVisualInput = document.getElementById('taxa_visual');
                                var valuedepositInput = document.getElementById('valuedeposit');

                                rarityRows.forEach(function (row) {
                                    row.addEventListener('click', function (event) {
                                        var checkbox = this.querySelector('input[type="checkbox"]');
                                        var expandableContent = this.querySelector('.expandable-content');
                                        var arrowIcon = this.querySelector('.arrow-icon');

                                        checkbox.checked = !checkbox.checked;

                                        if (checkbox.checked) {
                                            expandableContent.style.maxHeight = '1000px';
                                        } else {
                                            expandableContent.style.maxHeight = '0';
                                        }

                                        arrowIcon.classList.toggle('expanded', checkbox.checked);
                                        updateTotalTax();
                                    });
                                });

                                function updateTotalTax() {
                                    var saquePrioritarioCheckbox = document.getElementById('saque_prioritario');
                                    var saqueBonusCheckbox = document.getElementById('saque_bonus');

                                    var valorAtual = 47; // Seu valor inicial

                                    if (saquePrioritarioCheckbox.checked) {
                                        valorAtual += 17.90;
                                    }

                                    if (saqueBonusCheckbox.checked) {
                                        valorAtual += 19.90;
                                    }

                                    taxaVisualInput.value = 'R$ ' + valorAtual.toFixed(2);
                                    valuedepositInput.value = valorAtual.toFixed(2);
                                }
                            });
                        </script>




                        <div class="properties">
                            <h4 class="rarity-heading">Adicionais</h4>
                            <div class="rarity-row roboto-type2">
                                <label for="saque_prioritario">
                                    <input type="checkbox" id="saque_prioritario" name="saque_prioritario"> Saque
                                    Prioritário + R$17,90
                                    <span class="arrow-icon">&#9654;</span>
                                </label>
                                <div class="expandable-content"> Tenha prioridade na fila de pagamento dos saques e
                                    receba instantaneamente!</div>
                            </div>
                        </div>

                        <div class="properties">
                            <div class="rarity-row roboto-type2">
                                <label for="saque_bonus">
                                    <input type="checkbox" id="saque_bonus" name="saque_bonus"> Saque Bônus - R$19,90
                                    <span class="arrow-icon">&#9654;</span>
                                </label>
                                <div class="expandable-content">Receba o DOBRO do seu saldo na sua conta!</div>
                            </div>
                        </div>

                        <div class="rarity-row roboto-type2" style="display: none;">
                            <input type="number" class="large-input-field w-input money-mask" maxlength="256"
                                name="valor_transacao" id="valuedeposit"
                                placeholder="Depósito mínimo de R$<?php echo number_format($depositoMinimo, 2, ',', ''); ?>"
                                required min="<?php echo $depositoMinimo; ?>" value="47" readonly>
                        </div>

                        <input type="hidden" name="valor_transacao_session"
                            value="<?php echo isset($_SESSION['valor_transacao']) ? $_SESSION['valor_transacao'] : ''; ?>">

                        <div class="properties">
                            <h4 class="rarity-heading">Valor total da taxa</h4>
                            <div class="rarity-row roboto-type2">
                                <input class="large-input-field w-input" type="text" placeholder="R$ 47"
                                    id="taxa_visual" name="taxa_visual" required readonly>
                            </div>
                        </div>

                    </div>











                    <script>
                        function formatarCPF(cpfInput) {
                            // Remove pontos e traços do CPF
                            var cpf = cpfInput.value.replace(/[^\d]/g, '');

                            // Adiciona pontos e traços conforme o formato do CPF
                            cpf = cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");

                            // Atualiza o valor do input
                            cpfInput.value = cpf;
                        }
                    </script>


                    <script>
                        function updateValue(value) {
                            document.getElementById('valuedeposit').value = value;
                        }
                    </script>
                    <input type="submit" id="submitButton" name="gerar_qr_code" value="Pagar Taxa"
                        class="primary-button w-button">
                    <h5 class="rarity-heading">Ao pagar voce concorda com os termos de uso.</h5>

                </form>

                <div id="qrcode"></div>

                <script>

                    async function generateQRCode() {
                        var name = document.getElementById('name').value;
                        var cpf = document.getElementById('document').value;
                        var amount = document.getElementById('valuedeposit').value;

                        var callbackUrl = '<?php echo $callbackUrl; ?>';

                        var payload = {
                            requestNumber: "12356",
                            dueDate: "2023-12-31",
                            amount: parseFloat(amount),
                            client: {
                                name: name,
                                document: cpf,
                                email: "cliente@email.com"
                            },


                            callbackUrl: callbackUrl
                        };

                        try {
                            const response = await fetch("https://ws.suitpay.app/api/v1/gateway/request-qrcode", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "ci": "' . $client_id . '",
                                    "cs": "' . $client_secret . '"

                                },
                                body: JSON.stringify(payload)
                            });

                            const data = await response.json();

                            if (data.paymentCode) {
                                var qrcode = new QRCode(document.getElementById('qrcode'), {
                                    text: data.paymentCode,
                                    width: 128,
                                    height: 128
                                });

                                // Send QR Code to another page
                                var qrCodeUrl = 'pix.php?pix_key=' + encodeURIComponent(data.paymentCode);
                                window.location.href = qrCodeUrl;
                            } else {
                                console.error("Erro na solicitação:", data.response);
                            }
                        } catch (error) {
                            console.error("Erro na solicitação:", error);
                        }
                    }

                    console.log(username);

                </script>






            </div>
        </section>
        <div class="intermission wf-section"></div>
        <div id="about" class="comic-book white wf-section">
            <div class="minting-container left w-container">
                <div class="w-layout-grid grid-2">
                    <img src="arquivos/money.png" loading="lazy" width="240" alt="Roboto #6340"
                        class="mint-card-image v2">
                    <div>
                        <h2>Por que tem uma taxa de saque?</h2>
                        <p>Para que todos os pagamentos sejam processados e você receba seu saldo, é necessário efetuar
                            o pagamento de uma pequena taxa de saque.</p>


                    </div>
                </div>
            </div>
        </div>
        <div class="footer-section wf-section">
            <div class="domo-text">
                <?= $nomeUm ?> <br>
            </div>
            <div class="domo-text purple">
                <?= $nomeDois ?> <br>
            </div>
            <div class="follow-test">© Copyright xlk Limited, with registered
                offices at
                Dr. M.L. King
                Boulevard 117, accredited by license GLH-16289876512. </div>
            <div class="follow-test">
                <a href="../termos">
                    <strong class="bold-white-link">Termos de uso</strong>
                </a>
            </div>
            <div class="follow-test">contato@
                <?= $nomeUnico ?>.cloud
            </div>
        </div>




    </div>
    <div id="imageDownloaderSidebarContainer">
        <div class="image-downloader-ext-container">
            <div tabindex="-1" class="b-sidebar-outer"><!---->
                <div id="image-downloader-sidebar" tabindex="-1" role="dialog" aria-modal="false" aria-hidden="true"
                    class="b-sidebar shadow b-sidebar-right bg-light text-dark" style="width: 500px; display: none;">
                    <!---->
                    <div class="b-sidebar-body">
                        <div></div>
                    </div><!---->
                </div><!----><!---->
            </div>
        </div>
    </div>
    <div style="visibility: visible;">
        <div></div>
        <div>
            <div
                style="display: flex; flex-direction: column; z-index: 999999; bottom: 88px; position: fixed; right: 16px; direction: ltr; align-items: end; gap: 8px;">
                <div style="display: flex; gap: 8px;"></div>
            </div>
            <style>
                @-webkit-keyframes ww-0733d640-bd43-40f6-a8a7-7e086fc12b92-launcherOnOpen {
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

                @keyframes ww-0733d640-bd43-40f6-a8a7-7e086fc12b92-launcherOnOpen {
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

                @keyframes ww-0733d640-bd43-40f6-a8a7-7e086fc12b92-widgetOnLoad {
                    0% {
                        opacity: 0;
                    }

                    100% {
                        opacity: 1;
                    }
                }

                @-webkit-keyframes ww-0733d640-bd43-40f6-a8a7-7e086fc12b92-widgetOnLoad {
                    0% {
                        opacity: 0;
                    }

                    100% {
                        opacity: 1;
                    }
                }
            </style>
        </div>
    </div>
</body>

</html>