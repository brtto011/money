<?php
session_start();

// Função para validar os dados do formulário
function validateForm($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

include './../conectarbanco.php';

$conn = new mysqli('localhost', $config['db_user'], $config['db_pass'], $config['db_name']);

// Verifica se houve algum erro na conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar e obter os dados do formulário
    $email = validateForm($_POST["email"]);
    $senha = validateForm($_POST["senha"]);
    $telefone = validateForm($_POST["telefone_confirmation"]);
    $leadAff = isset($_POST['lead_aff']) ? validateForm($_POST['lead_aff']) : '';
    $utmSource = isset($_POST['utm_source']) ? validateForm($_POST['utm_source']) : '';
    $utmMedium = isset($_POST['utm_medium']) ? validateForm($_POST['utm_medium']) : '';
    $utmCampaign = isset($_POST['utm_campaign']) ? validateForm($_POST['utm_campaign']) : '';
    

    if (emailExists($email, $conn)) {
        $errorMessage = "Já existe uma conta com esse e-mail.";
    } else {
        $saldo = 0;
        $jogo_demo = 2;
        $plano = 20; // Valor fixo para a coluna plano
        $saldo_comissao = 0; // Valor fixo para a coluna saldo_comissao

        // Construir o link de afiliado
        $linkAfiliado = "../cadastrar/?aff=";

        $dataCadastro = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
        $dataCadastroFormatada = $dataCadastro->format('d-m-Y H:i');

        // Obter um ID único
        $nextId = uniqid();

        // Inserir dados no banco de dados
        $insertQuery = "INSERT INTO appconfig (id, email, senha, telefone, saldo, jogo_demo, lead_aff, linkafiliado, indicados, plano, saldo_comissao, data_cadastro, utm_source, utm_medium, utm_campaign) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("ssssissiisssss", $nextId, $email, $senha, $telefone, $saldo, $jogo_demo, $leadAff, $linkAfiliado, $plano, $saldo_comissao, $dataCadastroFormatada, $utmSource,$utmMedium, $utmCampaign);

        if ($stmt->execute()) {
            // Definir o email como uma variável de sessão
            $_SESSION['email'] = $email;

            // Redirecionar para a página com o número na URL
            header("Location: /deposito");
            exit();
        } else {
            $errorMessage = "Erro ao inserir dados na tabela 'appconfig': " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();

// Função para verificar se um e-mail já existe na tabela
function emailExists($email, $conn) {
    $checkEmailQuery = "SELECT email FROM appconfig WHERE email = ?";
    $checkEmailStmt = $conn->prepare($checkEmailQuery);
    $checkEmailStmt->bind_param("s", $email);
    $checkEmailStmt->execute();
    $checkEmailStmt->store_result();
    $exists = $checkEmailStmt->num_rows > 0;
    $checkEmailStmt->close();
    return $exists;
}
?>



<!DOCTYPE html>

<html lang="pt-br" class="w-mod-js wf-spacemono-n4-active wf-spacemono-n7-active wf-active w-mod-ix"><head>
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
fbq('init', '2731501603665645');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=2731501603665645&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->

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
fbq('init', '689791573256217');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=689791573256217&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><style>.wf-force-outline-none[tabindex="-1"]:focus{outline:none;}</style>
<meta charset="pt-br">
<title>SubwayPay 🌊</title>
<meta property="og:image" content="../img/logo.png">

<meta content="SubwayPay 🌊" property="og:title">

<meta name="twitter:image" content="../img/logo.png">
<meta content="SubwayPay 🌊" property="twitter:title">

<meta property="og:type" content="website">
<meta content="summary_large_image" name="twitter:card">
<meta content="width=device-width, initial-scale=1" name="viewport">
<link href="arquivos/page.css" rel="stylesheet" type="text/css">
<script src="arquivos/webfont.js" type="text/javascript"></script>

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
fbq('init', '311189245234114');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=311189245234114&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->

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
fbq('init', '895000851961790');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=895000851961790&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->


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
fbq('init', '852624766643006');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=852624766643006&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->








</head>
<body>
<div>



<div data-collapse="small" data-animation="default" data-duration="400" role="banner" class="navbar w-nav">
<div class="container w-container">



<a href="../" aria-current="page" class="brand w-nav-brand" aria-label="home">
<img src="arquivos/l2.png" loading="lazy" height="28" alt="" class="image-6">

<div class="nav-link logo">SubwayPay</div>
</a>
<nav role="navigation" class="nav-menu w-nav-menu">
<a href="../login/" class="nav-link w-nav-link" style="max-width: 940px;">Jogar</a>
<a href="../login/" class="nav-link w-nav-link" style="max-width: 940px;">Login</a>
<a href="../cadastrar/" class="button nav w-button w--current">Cadastrar</a>
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
<a href="../login/" class="button w-button w--current">
<div>Jogar</div>
</a>
<a href="../login/" class="button w-button w--current">
<div >Login</div>
</a>
<a href="../cadastrar/" class="button w-button w--current">Cadastrar</a>
</div>
<section id="hero" class="hero-section dark wf-section">
<div class="minting-container w-container">




<img src="arquivos/Kcykfsq.png" loading="lazy" width="240" data-w-id="6449f730-ebd9-23f2-b6ad-c6fbce8937f7" alt="Roboto #6340" class="mint-card-image">
<h2>CADASTRO</h2>
<p>É rapidinho, menos de 1 minuto. <br>Vai perder a oportunidade de faturar com o jogo do surfista?
<br>
</p>



<?php
// Exibir a notificação de sucesso ou erro
if (!empty($errorMessage)) {
    echo '<div class="notification-container error-message">' . $errorMessage . '</div>';
} elseif (!empty($successMessage)) {
    echo '<div class="notification-container success-message">' . $successMessage . '</div>';
}
?>



<form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
  



  <div class="properties">
  <h4 class="rarity-heading">E-mail</h4>
  <div class="rarity-row roboto-type2">
  <input type="e-mail" class="large-input-field w-input" maxlength="256" name="email" placeholder="seuemail@gmail.com" id="email" required>
  </div>
  <h4 class="rarity-heading">Telefone</h4>
  <div class="rarity-row roboto-type2">
      <input type="tel" class="large-input-field w-input" maxlength="20" name="telefone_confirmation" placeholder="Telefone" id="telefone_confirmation" required>
  </div>
  <h4 class="rarity-heading">Senha</h4>
  <div class="rarity-row roboto-type2">
  <input type="password" class="large-input-field w-input" maxlength="256" name="senha" data-name="password" placeholder="Uma senha segura" id="senha" required>
  </div>
  <h4 class="rarity-heading">Confirme sua Senha</h4>
  <div class="rarity-row roboto-type2">
  <input type="password" class="large-input-field w-input" maxlength="256" name="password_confirmation" data-name="password" placeholder="Confirme sua senha" id="myInput" required>
  
   <input type="hidden" name="lead_aff" id="lead_aff" value="">
   <input type="hidden" name="utm_source" id="utm_source" value="">
   <input type="hidden" name="utm_medium" id="utm_medium" value="">
   <input type="hidden" name="utm_campaign" id="utm_campaign" value="">
  </div>
  <br>
  
  
  
  
  
      <input type="checkbox" onclick="mostrarSenha()"> Mostrar senha
  </div>
  
  
  <script>
      function mostrarSenha() {
          var senhaInput = document.getElementById('senha');
          if (senhaInput.type === 'password') {
              senhaInput.type = 'text';
          } else {
              senhaInput.type = 'password';
          }
      }
  </script>
  
  
  <script>
      
    document.addEventListener('DOMContentLoaded', function () {
        // Obtenha os parâmetros da URL
        const urlParams = new URLSearchParams(window.location.search);
        const leadAff = urlParams.get('aff');
        const utmSource = urlParams.get('utm_source');
        const utmMedium = urlParams.get('utm_medium');
        const utmCampaign = urlParams.get('utm_campaign');
    
        // Ajuste dos valores de UTM conforme o modelo do Facebook
        const facebookUTMSource = utmSource ? `{{${utmSource}}}` : '';
        const facebookUTMMedium = utmMedium ? `{{${utmMedium}}}` : '';
        const facebookUTMCampaign = utmCampaign ? `{{${utmCampaign}}}` : '';
    
        // Atualize os valores dos campos ocultos
        document.getElementById('lead_aff').value = leadAff;
        document.getElementById('utm_source').value = facebookUTMSource;
        document.getElementById('utm_medium').value = facebookUTMMedium;
        document.getElementById('utm_campaign').value = facebookUTMCampaign;
    });
  
  
  </script>
  
  
  
  <div class="">
  <button type="submit" class="primary-button w-button">
  <i class="fa fa-check fa-fw"></i>
  Criar Conta
  </button><br>
  
  
  <p class="medium-paragraph _3-2vw-margin">Ao registrar você concorda com os
  
  
  
  
  
  <a href="../terms">termos de serviço</a> e que possui pelo menos 18 anos.
  </p>
  </div>
  </form>
  </div>
  </section>
<div class="intermission wf-section"></div>
<div id="rarity" class="rarity-section wf-section">
<div class="minting-container left w-container">
<div class="w-layout-grid grid-2">
<div>
<h2>💸 Tudo via PIX &amp; na hora. 🔥</h2>
<p>Seu dinheiro cai na hora na sua conta bancária, sem burocracia e sem taxas.</p>
</div>
</div>
</div>
</div>

<script>

  document.addEventListener('DOMContentLoaded', function () {
      var notificationContainer = document.querySelector('.notification-container');
      var loadingGif = document.querySelector('carregando.gif');
  
      // Exibir notificação após o envio do formulário
      <?php if (!empty($successMessage) || !empty($errorMessage)) { ?>
      notificationContainer.style.display = 'block';
      <?php } ?>
  
 
      <?php if (empty($successMessage) && empty($errorMessage)) { ?>
      loadingGif.style.display = 'block';
      setTimeout(function () {
          loadingGif.style.display = 'none';
          notificationContainer.style.display = 'block';
      }, 2000); 
      <?php } ?>
  });
  </script>

<div class="footer-section wf-section">
<div class="domo-text">SUBWAY <br>
</div>
<div class="domo-text purple">PAY <br>
</div>
<div class="follow-test">© Copyright xlk Limited, with registered
offices at
Dr. M.L. King
Boulevard 117, accredited by license GLH-16289876512. </div>
<div class="follow-test">
<a href="../legal">
<strong class="bold-white-link">Termos de uso</strong>
</a>
</div>
<div class="follow-test">contato@subwaypay.cloud</div>
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

    <style>    @-webkit-keyframes ww-51fbc3b8-5830-4bee-ad15-8955338512d0-launcherOnOpen {
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
        @keyframes ww-51fbc3b8-5830-4bee-ad15-8955338512d0-launcherOnOpen {
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

        @keyframes ww-51fbc3b8-5830-4bee-ad15-8955338512d0-widgetOnLoad {
          0% {
            opacity: 0;
          }
          100% {
            opacity: 1;
          }
        }

        @-webkit-keyframes ww-51fbc3b8-5830-4bee-ad15-8955338512d0-widgetOnLoad {
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