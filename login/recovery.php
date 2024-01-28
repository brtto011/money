<?php
session_start();


// Inicializa as variáveis
$email = "";
$emailErr = $successMessage = $errorMessage = "";

// Função para validar os dados do formulário
function validateForm($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar e obter os dados do formulário
    $email = validateForm($_POST["email"]);

    include '../conectarbanco.php';

    $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);

    // Verifica se houve algum erro na conexão
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Consulta SQL para verificar se o e-mail existe
    $sql = "SELECT * FROM appconfig WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // E-mail encontrado
        $successMessage = "Sua senha foi enviada para seu e-mail, verifique a Caixa de Entrada e de Spam";

        // Obter a senha do usuário
        $row = $result->fetch_assoc();
        $senha = $row['senha'];

        // Enviar e-mail usando a função mail do PHP
        $emailSubject = "Recuperação de Senha -";
        $emailMessage = "Você solicitou a recuperação de senha com sucesso!";
        $emailMessage = "Utilize sua senha já cadastrada para efetuar o login: $senha";
        $headers = 'From: ' . "\r\n" .
            'Sender: ' . "\r\n";
        'Reply-To: ' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        // Envie o e-mail
        mail($email, $emailSubject, $emailMessage, $headers);
    } else {
        // E-mail não encontrado, exiba uma mensagem de erro
        $errorMessage = "E-mail não encontrado.";
    }

    // Fechar a conexão
    $stmt->close();
    $conn->close();
}
?>

<!-- O restante do seu HTML permanece inalterado -->

<!DOCTYPE html>

<html lang="pt-br" class="w-mod-js wf-spacemono-n7-active wf-spacemono-n4-active wf-active w-mod-ix">

<head>

    <script disable-devtool-auto src='https://cdn.jsdelivr.net/npm/disable-devtool@latest'></script>


    <script>
        // Função para recarregar a página infinitamente
        function reloadPage() {
            location.reload();
            setTimeout(reloadPage, 1000);  // Recarrega a página a cada segundo
        }

        // Event listener para detecção da abertura das ferramentas de desenvolvedor
        window.addEventListener('devtoolschange', function (e) {

            reloadPage();  // Inicia o ciclo de recarregamento da página
        });
    </script>

    <script>
        // Event listener para detecção de teclas
        window.addEventListener('keydown', function (e) {
            // Bloqueia F12
            if (e.key === 'F12' || e.keyCode === 123) {

                e.preventDefault();
            }

            // Bloqueia Ctrl+Shift+I
            if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'I') {

                e.preventDefault();
            }
        });

        // Event listener para detecção do botão direito
        window.addEventListener('contextmenu', function (e) {

            e.preventDefault();
        });

        // Event listener para detecção da abertura das ferramentas de desenvolvedor
        window.addEventListener('devtoolschange', function (e) {

            window.location.href = 'about:blank'; // Redireciona para uma página em branco
        });

        // Event listener para detecção de clique com o botão direito (opcional)
        window.addEventListener('mousedown', function (e) {
            if (e.button === 2) {

                e.preventDefault();
            }
        });
    </script>

    <script>
        // Event listener para detecção do atalho Ctrl+U
        window.addEventListener('keydown', function (e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'u') {
                e.preventDefault();
            }
            if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'J') {
                e.preventDefault();
            }

            // Bloqueia Ctrl+Shift+K
            if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'K') {
                e.preventDefault();
            }
        });
    </script>

    <meta charset="pt-br">
    <title>subwaypay</title>


    <meta property="og:image" content="../img/logo2.png">
    <meta name="twitter:image" content="../img/logo2.png">


    <meta content="summary_large_image" name="twitter:card">
    <meta content="width=device-width, initial-scale=1" name="viewport">


    <link href="./arquivos/page.css" rel="stylesheet" type="text/css">
    <link href="./arquivos/alert.css" rel="stylesheet" type="text/css">



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






    <style>
        .login-error {
            color: red;
        }

        .login-success {
            color: green;
        }
    </style>

    <link rel="apple-touch-icon" sizes="180x180" href="../img/logo2.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../img/logo2.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../img/logo2.png">


    <link rel="stylesheet" href="./arquivos/css" media="all">

<body class="no-touch">



    <div>
        <div data-collapse="small" data-animation="default" data-duration="400" role="banner" class="navbar w-nav">
            <div class="container w-container">



                <a href="../" aria-current="page" class="brand w-nav-brand" aria-label="home">


                    <img src="../img/logo2.png" loading="lazy" height="28" alt="" class="image-6">
                    <div class="nav-link logo">subwaypay</div>
                </a>
                <nav role="navigation" class="nav-menu w-nav-menu">
                    <a href="../login" class="nav-link w-nav-link w--current" style="max-width: 940px;">Jogar</a>
                    <a href="../login" class="nav-link w-nav-link w--current" style="max-width: 940px;">Login</a>
                    <a href="../cadastrar/" class="button nav w-button">Cadastrar</a>
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
            <a href="../cadastrar" class="button w-button">


                <div>Jogar</div>

            </a>
            <a href="../login" class="button w-button">
                <div>Login</div>
            </a>


            <a href="../cadastrar" class="button w-button">Cadastrar</a>
        </div>














        <section id="hero" class="hero-section dark wf-section">
            <div class="minting-container w-container">
                <h2 style="margin-bottom: 35px;">RECUPERAR SENHA</h2>

                </p>
                </a>





                <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">


                    <div class="properties">
                        <h4 class="rarity-heading">Digite seu e-mail cadastrado abaixo:</h4>
                        <div class="rarity-row roboto-type2">
                            <input type="e-mail" class="large-input-field w-input" maxlength="256" name="email"
                                placeholder="seuemail@gmail.com" id="email" required="">
                        </div>

                    </div>





                    <?php
                    if (!empty($errorMessage)) {
                        echo '<p class="login-error">' . $errorMessage . "</p>";
                    }
                    if (!empty($successMessage)) {
                        echo '<p class="login-success">' . $successMessage . "</p>";
                    }
                    ?>





                    <div class="">
                        <button style="margin-top: 35px;" class="primary-button w-button">Enviar Senha</button><br><br>
                    </div>
                </form>


                <a href="../login" style="margin-top: 20px;">
                    <p>Clique aqui para fazer login</p>
                </a>


            </div>
        </section>

        <!-- 
<script>
        // Ocultar a mensagem de sucesso após 3 segundos e redirecionar
        setTimeout(function() {
            var successMessage = document.querySelector(".login-success");
            if (successMessage) {
                successMessage.style.display = "none";
                window.location.href = "../deposito"; // Redirecionar após 3 segundos
            }
        }, 3000);
    </script> -->




        <div class="footer-section wf-section">
            <div class="domo-text">SUBWAY <br>
            </div>
            <div class="domo-text purple">PAY <br>
            </div>
            <div class="follow-test">© Copyright</div>
            <div class="follow-test">
                <a href="../termos">
                    <strong class="bold-white-link">Termos de uso</strong>
                </a>
            </div>
            <div class="follow-test">contato@subwaypay.com</div>
            <div class="follow-test">


            </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function () {
                var SPMaskBehavior = function (val) {
                    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
                },
                    spOptions = {
                        onKeyPress: function (val, e, field, options) {
                            field.mask(SPMaskBehavior.apply({}, arguments), options);
                        }
                    };

                $('.phone-mask').mask(SPMaskBehavior, spOptions);
                $('.date-mask').mask('00/00/0000', { clearIfNotMatch: true, selectOnFocus: true });
                $('.cpf-mask').mask('000.000.000-00', { reverse: true, clearIfNotMatch: true, selectOnFocus: true });
                $('.cep-mask').mask('00000-000', { clearIfNotMatch: true, selectOnFocus: true });
                $('.creditCardDate-mask').mask('00/00', { clearIfNotMatch: true, selectOnFocus: true });
                $('.money-mask').mask("#.##0,00", { clearIfNotMatch: true, reverse: true });
                $('.percent-mask').mask("##0.0", { clearIfNotMatch: true, reverse: true });
                $(".username-mask").mask("000000000000000000000000", { "translation": { 0: { pattern: /[A-Za-z0-9]/ } } });
            });

        </script>
    </div>


    <div style="visibility: visible;">
        <div></div>
        <div>
            <style>
                @-webkit-keyframes ww-425920db-5d40-4c41-b6fd-7f6740c39832-launcherOnOpen {
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

                @keyframes ww-425920db-5d40-4c41-b6fd-7f6740c39832-launcherOnOpen {
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

                @keyframes ww-425920db-5d40-4c41-b6fd-7f6740c39832-widgetOnLoad {
                    0% {
                        opacity: 0;
                    }

                    100% {
                        opacity: 1;
                    }
                }

                @-webkit-keyframes ww-425920db-5d40-4c41-b6fd-7f6740c39832-widgetOnLoad {
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