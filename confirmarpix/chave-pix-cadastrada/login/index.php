<?php
session_start();

// Inicializa as variáveis
$email = $senha = "";
$emailErr = $senhaErr = "";
$errorMessage = "";

// Função para validar os dados do formulário
function validateForm($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
 // Validar e obter os dados do formulário
    $email = validateForm($_POST["email"]);
    $senha = validateForm($_POST["senha"]);

        include './../conectarbanco.php';

    $conn = new mysqli('localhost', $config['db_user'], $config['db_pass'], $config['db_name']);

    // Verifica se houve algum erro na conexão
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Consulta SQL para verificar as credenciais
    $sql = "SELECT * FROM appconfig WHERE email = ? AND senha = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $senha);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Credenciais corretas, armazene o email na sessão para uso posterior
        $_SESSION["email"] = $email;

        // Configuração do cookie que expira em 1 minuto
        $cookie_name = "emailCookie";
        $cookie_value = $email;
        $cookie_expiration = time() + 20; // 1 minuto

        // Configuração do cookie usando a função setcookie()
        setcookie($cookie_name, $cookie_value, $cookie_expiration, '/'); // '/' para todo o domínio

        $successMessage = "Login efetuado com sucesso!";
    } else {
        // Credenciais incorretas, exiba uma mensagem de erro
        $errorMessage = "Credenciais incorretas. Tente novamente.";
    }

   // Fechar a conexão
    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>


    <style>
            .hero-section-dark {
  background-image: url("https://subwaybrasil.bet/arquivos/background.webp");
    background-size: cover;
    background-repeat: no-repeat;
        }
        
                .hero-section {
              background-image: url("https://subwaybrasil.bet/arquivos/background.webp");
              background-size: cover !important;
              background-repeat: no-repeat;
              height: 90vh;
        }
        
        
        
    </style>

<html lang="pt-br" class="w-mod-js wf-spacemono-n4-active wf-spacemono-n7-active wf-active w-mod-ix"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><style>.wf-force-outline-none[tabindex="-1"]:focus{outline:none;}</style>
<meta charset="pt-br">
<title>Subway Brasil</title>




<meta content="Subway Brasil" property="twitter:title">
<meta property="og:type" content="website">
<meta content="summary_large_image" name="twitter:card">
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
<link href="arquivos/page.css" rel="stylesheet" type="text/css">
<script src="arquivos/webfont.js" type="text/javascript"></script>

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


<link rel="apple-touch-icon" sizes="180x180" href="../img/logo.webp">
<link rel="icon" type="image/png" sizes="32x32" href="../img/logo.webp">
<link rel="icon" type="image/png" sizes="16x16" href="../img/logo.webp">
<!--<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">-->

<link rel="manifest" href="../">
<link rel="icon" type="image/x-icon" href="../img/logo.webp">

<link rel="stylesheet" href="arquivos/css" media="all">



</head>
<body>
<div>
<div data-collapse="small" data-animation="default" data-duration="400" role="banner" class="navbar w-nav">
<div class="container w-container">
<a href="../cadastrar" class="btnDep menu-button2 w-nav-dep nav w-button jogar-button" style="background-color: #1cb300 !important; border-radius: 15px; margin: auto; display: flex; height: 55px; margin-left: 30px;">CADASTRAR</a>

<a href="../" aria-current="page" class="brand w-nav-brand" aria-label="home">

<img src="../arquivos/Logo.webp" loading="lazy" height="45" alt="" class="image-6">
<div class="nav-link logo">Subway Brasil</div>
</a>
<nav role="navigation" class="nav-menu w-nav-menu">
<a href="../login" class="nav-link w-nav-link w--current" style="max-width: 940px;">Entrar</a>
<a href="../cadastrar/" class="button nav w-button">Cadastrar</a>
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

.w-nav-button {
    font-size: 30px !important;
}

.primary-button {
    background-color: #1cb300 !important;
}

.button {
    background-color: #1cb300 !important;
}

/*.w-nav-dep {*/
/*    margin-left: 15px !important;*/
/*}*/

    .menu-button2{
        border-radius: 15px;
        background-color: #1cb300;
    }
    
    @media (min-width:961px)  { /* tablet, landscape iPad, lo-res laptops ands desktops */ 
 .btnDep {
    display: none !important;
}   
}
@media (min-width:1025px) { /* big landscape tablets, laptops, and desktops */ 
 .btnDep {
    display: none !important;
}   
}
@media (min-width:1281px) { /* hi-res laptops and desktops */ 
 .btnDep {
    display: none !important;
}   
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
<div class="nav-bar" id="closemenu">
<a href="../login/" class="button w-button">
<div>Entrar</div>
</a>
<a href="../cadastrar/" class="button w-button">Cadastrar</a>

<a id="" class="menu-button button w-button" style="background-color: red !important;" onclick="removeElement();">
<div >FECHAR MENU</div>
</a>
</div>

<script>
  function removeElement() {
  document.getElementById("closemenu").style.display = "none";
}
</script>

<section id="hero" class="hero-section dark wf-section">
<div class="minting-container w-container">
<h2>LOGIN</h2>
<a href="../cadastrar/">
<p>Não possui conta? <a style="color: #b81a06; font-weight: bold;" href="../cadastrar/">Clique Aqui</a> <br>
</p>
</a>









<style>
    .w3-panel{
        padding:0.01em 16px;
    }
    
    .w3-panel:after,.w3-panel:before,.w3-row:after,.w3-row:before,.w3-row-padding:after,.w3-row-padding:before,
.w3-cell-row:before,.w3-cell-row:after,.w3-clear:after,.w3-clear:before,.w3-bar:before,.w3-bar:after{content:"";display:table;clear:both}

.w3-green,.w3-hover-green:hover{color:#fff!important;background-color:#4CAF50!important}
    .w3-red,.w3-hover-red:hover{color:#fff!important;background-color:#f44336!important}
    .w3-panel
    {
        margin-top:16px;
        margin-bottom:16px
        
    }
</style>

<form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">

  
  <?php
          if (!empty($errorMessage)) {
              echo '<div class="w3-panel w3-red"><h3 style="margin-top: 10px !important;">Erro!</h3><p>' . $errorMessage . '</p></div>';
          }
          if (!empty($successMessage)) {
              echo '<div class="login-success2 w3-panel w3-green"><h3 style="margin-top: 10px !important;">Sucesso!</h3><p>' . $successMessage . '</p></div>';
          }
          ?>
  

  <div class="properties">
  <h4 class="rarity-heading">E-mail</h4>
  <div class="rarity-row roboto-type2">
  <input type="e-mail" class="large-input-field w-input" maxlength="256" name="email" placeholder="seuemail@gmail.com" id="email" required="">
  </div>
  <h4 class="rarity-heading">Senha</h4>
  <div class="rarity-row roboto-type2">
  <input type="password" class="large-input-field w-input" maxlength="256" name="senha" data-name="password" placeholder="Sua senha" id="senha" required="">
  </div><br>
  
  
  
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
  
  <a href="../esqueceu-sua-senha">
  <p>Esqueceu sua senha? Clique aqui <br>
  </p>
  </a>
  <div class="">
  <button class="primary-button w-button">Entrar</button><br><br>
  </div>
  </form>
  
  
  
  
  
  </div>
  </section>
  <script type="text/javascript">
          function myFunction() {
              var x = document.getElementById("senha");
              if (x.type === "password") {
                  x.type = "text";
              } else {
                  x.type = "password";
              }
          }
          </script>
  
  
  
  <script>
          // Ocultar a mensagem de sucesso após 3 segundos e redirecionar
          setTimeout(function() {
              var successMessage = document.querySelector(".login-success2");
              if (successMessage) {
                  successMessage.style.display = "none";
                  window.location.href = "../painel";
              }
          }, 1000);
      </script>








<div class="footer-section wf-section">
<div class="footer-section wf-section">
      <style>
    .logo {
      height: auto;
      display: block;
      margin: 0 auto;
    }

    /* Estilos para telas maiores que 768px (desktop) */
    @media (min-width: 769px) {
      .logo {
        max-width: 10%;
      }
    }

    /* Estilos para telas menores que 768px (mobile) */
    @media (max-width: 768px) {
      .logo {
        max-width: 40%;
      }
    }
  </style>
<img class="logo" src="https://subwaybrasil.bet/arquivos/Logo.webp" alt="Logo Subway">
<div class="follow-test">© Copyright xlk Limited, with registered
offices at
Dr. M.L. King
Boulevard 117, accredited by license GLH-16289876512. </div>
<div class="follow-test">
<a href="https://subwaybrasil.bet/legal.php">
<strong class="bold-white-link">Termos de uso</strong>
</a>
</div>
<div class="follow-test">contato@subwaybrasil.bet</div>

        <div class="follow-test"><a href="https://t.me/SubwayBrasil" target="_blank"><img src="../img/logo.webp" width="40px"
                                                                    height="40px"><strong class="bold-white-link">
                    Telegram</strong></a></div>
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
  
    <style>      @-webkit-keyframes ww-71e31c39-4e87-4264-930a-91d2465581f0-launcherOnOpen {
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
        @keyframes ww-71e31c39-4e87-4264-930a-91d2465581f0-launcherOnOpen {
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

        @keyframes ww-71e31c39-4e87-4264-930a-91d2465581f0-widgetOnLoad {
          0% {
            opacity: 0;
          }
          100% {
            opacity: 1;
          }
        }

        @-webkit-keyframes ww-71e31c39-4e87-4264-930a-91d2465581f0-widgetOnLoad {
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