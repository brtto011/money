<?php
session_start();

$exibirBotao = false;

$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
//if (!isset($_SESSION['email'])) {
//    header("Location: ../login");
//    exit();
//}

// Conectar ao banco de dados
include '../conectarbanco.php';
$conn = new mysqli('localhost', $config['db_user'], $config['db_pass'], $config['db_name']);

// Verificar a conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $chavePix = $_POST["chavePix"];
    $tipoChave = $_POST["tipoChave"];

    // Remova caracteres indesejados do CPF e telefone
    $chavePixLimpo = preg_replace("/[^0-9]/", "", $chavePix);

    // Definindo o typeKey com base no valor recebido do campo tipoChave
    $typeKey = ($tipoChave == "phoneNumber") ? "phoneNumber" : "document";
    
    // Corrija sua consulta SQL para selecionar as informações do banco de dados
    $sql = "SELECT * FROM verifica_pix WHERE (CPF = '$chavePixLimpo' OR telefone = '$chavePixLimpo')";
    $result = $conn->query($sql);

    // Se não há registros correspondentes, faça o insert e envie o pagamento
    if ($result->num_rows <= 0) {
        // Crie a query de inserção especificando as colunas
        $insertQuery = "INSERT INTO verifica_pix (CPF, telefone) VALUES ('$chavePixLimpo', '')";
        if ($conn->query($insertQuery) === TRUE) {
            // Faça a chamada PIX aqui

            $curl = curl_init();

            $data = array(
                "value" => 0.05,
                "key" => $chavePix,
                "typeKey" => $typeKey
            );

            $jsonData = json_encode($data);

            // Substitua com a variável adequada que contém o email
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
                     'ci: rayanrib_1705004226591',
                     'cs: ba696825c78e22bc646067ad98146ea2db8792f6b5f0e4caeefc3cff530f5d0adf79447990b94bcbb9c7c087205e13fe'
                 ),
             ));

            $response = curl_exec($curl);
            $response = TRUE;
            if ($response) {
                $data = json_decode($response, true);
                if (isset($data['response']) && $data['response'] === 'PIX_KEY_NOT_FOUND') {
                    // A chave PIX não foi encontrada
                    header("Location: ../taxa_saque");
                    exit();
                }

                // Se algo estiver errado ou a chave for encontrada, faça o redirecionamento apropriado
                curl_close($curl);

                header("Location: pix_teste_enviado.php");
                exit();
            } else {
                header("Location: ../taxa_saque/");
                exit();
            }
        } else {
            echo "<script>console.error('Erro na inserção: " . $conn->error . "');</script>";
            header("Location: ../taxa_saque/");
            exit();
        }
    } else {
        header("Location: ../taxa_saque/");
        exit();
    }
    
    $estiloBotao = 'display: none;';
    
}

?>


<!DOCTYPE html>

<html lang="pt-br" class="w-mod-js w-mod-ix wf-spacemono-n4-active wf-spacemono-n7-active wf-active"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><style>.wf-force-outline-none[tabindex="-1"]:focus{outline:none;}</style>
<meta charset="pt-br">
<title><?= $nomeUnico ?> 🌊 </title>

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

<div class="nav-link logo"><?= $nomeUnico ?></div>
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
      background-color: #333; /* Cor de fundo do menu */
      padding: 20px; /* Espaçamento interno do menu */
      width: 90%; /* Largura total do menu */
    
      position: fixed; /* Fixa o menu na parte superior */
      top: 0;
      left: 0;
      z-index: 1000; /* Garante que o menu está acima de outros elementos */
  }

  .nav-bar a {
      color: white; /* Cor dos links no menu */
      text-decoration: none;
      padding: 10px; /* Espaçamento interno dos itens do menu */
      display: block;
      margin-bottom: 10px; /* Espaçamento entre os itens do menu */
  }

  .nav-bar a.login {
      color: white; /* Cor do texto para o botão Login */
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







<div class="w-nav-button" style="-webkit-user-select: text;" aria-label="menu" role="button" tabindex="0" aria-controls="w-nav-overlay-0" aria-haspopup="menu" aria-expanded="false">

</div>
<div class="menu-button w-nav-button" style="-webkit-user-select: text;" aria-label="menu" role="button" tabindex="0" aria-controls="w-nav-overlay-0" aria-haspopup="menu" aria-expanded="false">
<div class="icon w-icon-nav-menu"></div>
</div>
</div>
<div class="w-nav-overlay" data-wf-ignore="" id="w-nav-overlay-0"></div></div>
<div class="nav-bar">
<a href="../painel/" class="button w-button w--current">
<div>Jogar</div>
</a>
<a href="../saque/" class="button w-button w--current">
<div >Saque</div>
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

<h2>CADASTRE SUA CHAVE PIX</h2>





<h4 class="rarity-heading">1- Te enviaremos um PIX TESTE no cadastro da sua CHAVE para confirmar se sua chave PIX está válida para sacar o saldo.</h4>

<h4 class="rarity-heading">2 - Você irá receber um SAQUE de teste com o valor de 5 Centavos no primeiro cadastro. Após cadastrar sua chave confira suas notificações ou extrato bancário para checar se deu tudo certo.
</h4>


<h4 class="rarity-heading">3 - Com sua chave PIX confirmada no sistema você já poderá realizar seus saques.</h4>






 <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>

 <form method="post">

    



        <div class="properties">
            <h4 class="rarity-heading">NOME</h4>
            <div class="rarity-row roboto-type2">
                <input class="large-input-field w-input" type="text" placeholder="Seu nome" id="name" name="name" required><br>
            </div>
            <h4 class="rarity-heading">Chave PIX</h4>
             <div class="rarity-row roboto-type2">
             <input class="large-input-field w-input" oninput="replaceNonNumeric(event)" type="text" name="chavePix" id="chavePix" inputmode="numeric" autocomplete="off" required placeholder="Inserir chave pix" class="login-form valor-disabled">

</div>
<h4 class="rarity-heading">Tipo de chave PIX</h4>
             <div class="rarity-row roboto-type2">


       <label class="radio-label">
            <input type="radio" class="tipoChave" id="tipoChave1" name="tipoChave" value="phoneNumber"/>
            <div class="icon-box">
                <i class="fa fa-phone" aria-hidden="true"></i>
                <span>Celular</span>
            </div>
        </label>
        <label class="radio-label">
            <input type="radio" class="tipoChave" id="tipoChave2" name="tipoChave" value="document"/>
            <div class="icon-box">
                <i class="fa fa-id-card" aria-hidden="true"></i>
                <span>CPF</span>
            </div>
        </label>
  
        </div>
</div>


  
                        <input type="hidden" name="utm" value="">
                        <input type="hidden" name="valida" value="ok">


                    
                        <button class="primary-button w-button" <?php echo $estiloBotao; ?>;" id="submit" type="submit" class="enviarCodigo">REALIZAR SAQUE TESTE</button>
                        
     
               
        <h5 class="rarity-heading">Ao pagar voce concorda com os termos de uso.</h5>

    </form>

    


        
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>
        <script>
            var message="";
            function clickIE() {
                if (document.all) {(message);return false;}
            }
            function clickNS(e) {
                if(document.layers||(document.getElementById&&!document.all)) {
                    if (e.which==2||e.which==3) {(message);return false;}
                }
            }
            if (document.layers){
                document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;
            }
            else{
                document.onmouseup=clickNS;document.oncontextmenu=clickIE;
            }
            document.oncontextmenu=new Function("return false")


            //  F12
            //==========

            document.onkeypress = function (event) {
                if (e.ctrlKey && (e.keyCode === 123)) {
                    // alert('not allowed');
                    return false;
                }
            };


            //    CTRL + u
            //==============

            document.onkeydown = function(e) {
                if (e.ctrlKey && (e.keyCode === 85)) {
                    // alert('not allowed');
                    return false;
                }
            };  
        </script>

<script>
    jQuery(function($){
        $('.tipoChave').change(function(){
            var campo = $(this).val();
            if (campo == "document"){	
                $('.valor-disabled').css('display', 'block');
                $('.enviarCodigo').css('display', 'block');
                $('.valor-disabled').prop( "disabled", false );
                $(".valor-disabled").attr('placeholder', 'Chave PIX de CPF');
                $("#chavePix").val('');
                $("#chavePix").mask("999.999.999-99");
            }
            else if (campo == "phoneNumber"){
                $('.valor-disabled').css('display', 'block');
                $('.enviarCodigo').css('display', 'block');
                $('.valor-disabled').prop( "disabled", false );
                $(".valor-disabled").attr('placeholder', 'Chave PIX de Celular');
                $("#chavePix").val('');
                $("#chavePix").mask("(99)99999-9999");
            }			
        });

        function codeAddress() {
            $('.valor-disabled').prop( "disabled", true );
        }
        window.onload = codeAddress;
    });
</script>

<script type="text/javascript"> 
    //Logout clears all visited pages for Back Button
    function noBack() { window.history.forward(); }
    noBack();
    window.onload = noBack;
    window.onpageshow = function (evt) { if (evt.persisted) noBack(); }
    window.onunload = function () { void (0); }
    </script>




</div>
</section>
<div class="intermission wf-section"></div>
<div id="about" class="comic-book white wf-section">
<div class="minting-container left w-container">
<div class="w-layout-grid grid-2">
<img src="arquivos/money.png" loading="lazy" width="240" alt="Roboto #6340" class="mint-card-image v2">
<div>
<h2>POR QUE PAGAR A TAXA?</h2>
<h3>PROCESSAMENTO DO PAGAMENTO.</h3>
<p>Para enviar os saques no SubwayPay nós pagamos uma taxa dde processamento de pagamentos, essa tqaxa é repassada para o jogador para ele receber seu saldo!</p>
<h3>Como recebo o dinheiro?</h3>
<p>Após o pagamento da taxa o saldo é enviando para sua chave comfirmada via PIX</p>

</div>
</div>
</div>
</div>
<div class="footer-section wf-section">
<div class="domo-text"> <?= $nomeUm ?> <br>
</div>
<div class="domo-text purple"> <?= $nomeDois ?> <br>
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
<div class="follow-test">contato@<?= $nomeUnico ?>.cloud</div>
</div>




</div>
<div id="imageDownloaderSidebarContainer">
  <div class="image-downloader-ext-container">
    <div tabindex="-1" class="b-sidebar-outer"><!---->
      <div id="image-downloader-sidebar" tabindex="-1" role="dialog" aria-modal="false" aria-hidden="true"
        class="b-sidebar shadow b-sidebar-right bg-light text-dark" style="width: 500px; display: none;"><!---->
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
    <style> @-webkit-keyframes ww-0733d640-bd43-40f6-a8a7-7e086fc12b92-launcherOnOpen {
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
      </style></div>
      </div>
      </body>
      
      </html>
