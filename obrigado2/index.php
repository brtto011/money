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
        
<!-- Event snippet for Purchase conversion page
In your html page, add the snippet and call gtag_report_conversion when someone clicks on the chosen link or button. -->
<script>
function gtag_report_conversion(url) {
  var callback = function () {
    if (typeof(url) != 'undefined') {
      window.location = url;
    }
  };
  gtag('event', 'conversion', {
      'send_to': 'AW-11050549561/bDTVCMLA5IAZELmCqJUp',
      'value': 20.0,
      'currency': 'BRL',
      'transaction_id': '',
      'event_callback': callback
  });
  return false;
}
</script>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-NCGMVTG');</script>
<!-- End Google Tag Manager -->
<!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '1247145085988880');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=1247145085988880&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->
</head>

<body>


<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NCGMVTG"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

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