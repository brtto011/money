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
$baseUrl = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$baseUrl .= "://" . $_SERVER['HTTP_HOST'];


$staticPart = '/cadastrar/?aff=';

$callbackUrl = $baseUrl . $staticPart;



echo '<script>';
echo 'console.log("Callback URL:", ' . json_encode($callbackUrl) . ');';
echo 'var callbackUrl = ' . json_encode($callbackUrl) . ';';
echo '</script>';
?>



<?php

session_start();

// Função para validar os dados do formulário
function validateForm($input)
{
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

function getParamFromUrl($url, $paramName)
{
  parse_str(parse_url($url, PHP_URL_QUERY), $op);
  return array_key_exists($paramName, $op) ? $op[$paramName] : '';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Validar e obter os dados do formulário
  $nome = validateForm($_POST["nome"]);
  $email = validateForm($_POST["email"]);
  $senha = validateForm($_POST["senha"]);
  $telefone = validateForm($_POST["telefone_confirmation"]);
  $leadAff = isset($_POST['lead_aff']) ? validateForm($_POST['lead_aff']) : '';

  // Verificar se o e-mail já existe
  if (emailExists($email, $conn)) {
    $errorMessage = "Já existe uma conta com esse e-mail.";
  } else {
    // Obter o próximo ID aleatório de 8 dígitos
    $nextId = generateRandomId(8);

    $saldo = 0;
    $plano = 20; // Valor fixo para a coluna plano
    $saldo_comissao = 0; // Valor fixo para a coluna saldo_comissao
    $cpa = 0; // Valor fixo para o cpa único

    // Construir o link de afiliado
    $linkAfiliado = $callbackUrl . $nextId;

    // Obter a data e hora atual no fuso horário de São Paulo
    $dataCadastro = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
    $dataCadastroFormatada = $dataCadastro->format('d-m-Y H:i');

    $afiliado = isset($_GET['aff']) ? $_GET['aff'] : '';

    // Inserir dados no banco de dados
    $insertQuery = "INSERT INTO appconfig (id,cpa,nome, email, senha, telefone, saldo, lead_aff, linkafiliado, indicados, plano, saldo_comissao, data_cadastro, afiliado) 
                        VALUES (?,0, ?, ?, ?, ?, ?, ?, ?, 0, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("issssissiiss", $nextId, $nome, $email, $senha, $telefone, $saldo, $leadAff, $linkAfiliado, $plano, $saldo_comissao, $dataCadastroFormatada, $afiliado);

    if ($stmt->execute()) {
      // Definir o email como uma variável de sessão
      $_SESSION['email'] = $email;

      $canal_id = '';


      // Redirecionar para a página com o número na URL
      header("Location: /confirmado");
      exit();
    } else {
      $errorMessage = "Erro ao inserir dados na tabela 'appconfig': " . $stmt->error;
    }

    $stmt->close();
  }
}

// Função para verificar se um e-mail já existe na tabela
function emailExists($email, $conn)
{
  $checkEmailQuery = "SELECT email FROM appconfig WHERE email = ?";
  $checkEmailStmt = $conn->prepare($checkEmailQuery);
  $checkEmailStmt->bind_param("s", $email);
  $checkEmailStmt->execute();
  $checkEmailStmt->store_result();
  $exists = $checkEmailStmt->num_rows > 0;
  $checkEmailStmt->close();
  return $exists;
}

function generateRandomId($length)
{
  $characters = '0123456789';
  $randomId = '';

  for ($i = 0; $i < $length; $i++) {
    $randomId .= $characters[random_int(0, strlen($characters) - 1)];
  }

  return $randomId;
}

$conn->close();
?>



<!DOCTYPE html>

<html lang="pt-br" class="w-mod-js wf-spacemono-n4-active wf-spacemono-n7-active wf-active w-mod-ix">

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

  <?php
  include '../pixels.php';
  ?>










</head>

<body>


  <div>






    <div>



      <div data-collapse="small" data-animation="default" data-duration="400" role="banner" class="navbar w-nav">
        <div class="container w-container">



          <a href="../" aria-current="page" class="brand w-nav-brand" aria-label="home">
            <img src="arquivos/l2.png" loading="lazy" height="28" alt="" class="image-6">

            <div class="nav-link logo">
              <?= $nomeUnico ?>
            </div>
          </a>
          <nav role="navigation" class="nav-menu w-nav-menu">
            <a href="../login/" class="nav-link w-nav-link" style="max-width: 940px;">Jogar</a>
            <a href="../login/" class="nav-link w-nav-link" style="max-width: 940px;">Login</a>
            <a href="../cadastrar/" class="button nav w-button w--current">Cadastrar</a>
          </nav>





          <style>
            body {
              user-select: none;
            }

            .all {

              filter: blur(0px);
              transition: filter 0.3s ease;
            }
          </style>




          <style>
            .nav-bar {

              margin-top: 80px;
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
              z-index: 9999;
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
              var All = document.querySelector('.all');

              menuButton.addEventListener('click', function () {
                // Toggle the visibility of the navigation bar
                if (navBar.style.display === 'block') {
                  navBar.style.display = 'none';
                  All.style.filter = 'blur(0px)';
                  document.body.style.overflow = ''; /* Restaurar a rolagem após fechar o menu */
                } else {
                  navBar.style.display = 'block';
                  All.style.filter = 'blur(3px)';
                  navBar.style.filter = 'blur(0px)';
                  document.body.style.overflow = 'hidden'; /* Remover a rolagem enquanto o menu está aberto */
                }
              });
            });
          </script>










          <div class="w-nav-button" style="-webkit-user-select: text;" aria-label="menu" role="button" tabindex="0"
            aria-controls="w-nav-overlay-0" aria-haspopup="menu" aria-expanded="false">
          </div>
          <div class="menu-button w-nav-button" style="-webkit-user-select: text;" aria-label="menu" role="button"
            tabindex="0" aria-controls="w-nav-overlay-0" aria-haspopup="menu" aria-expanded="false">
            <div class="icon w-icon-nav-menu"></div>
          </div>
        </div>
        <div class="w-nav-overlay" data-wf-ignore="" id="w-nav-overlay-0"></div>
      </div>
      <div class="nav-bar">
        <a href="../login/" class="button w-button w--current">
          <div>Jogar</div>
        </a>
        <a href="../login/" class="button w-button w--current">
          <div>Login</div>
        </a>
        <a href="../cadastrar/" class="button w-button w--current">Cadastrar</a>
      </div>

      <div class="all">

        <section id="hero" class="hero-section dark wf-section">
          <div class="minting-container w-container">




            <img src="arquivos/jake.gif" loading="lazy" width="240" data-w-id="6449f730-ebd9-23f2-b6ad-c6fbce8937f7"
              alt="Roboto #6340" class="mint-card-image">
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

            <script>
              function validarTelefone() {
                // Obtém o valor do campo de telefone
                var telefoneInput = document.getElementById("telefone_confirmation");
                var telefone = telefoneInput.value;

                // Remove qualquer caractere que não seja número
                telefone = telefone.replace(/\D/g, '');

                // Atualiza o valor do campo apenas com números
                telefoneInput.value = telefone;

                // Verifica se o telefone possui 11 dígitos (considerando o DDD)
                if (telefone.length !== 11) {
                  alert("Por favor, insira um número de telefone válido com DDD.");
                  return false;
                }

                // Se a validação passar, o formulário pode ser enviado
                return true;
              }

              // Adiciona um ouvinte de evento para permitir apenas números no campo de telefone
              document.getElementById("telefone_confirmation").addEventListener("input", function (event) {
                event.target.value = event.target.value.replace(/\D/g, '');
              });
            </script>
            <form method="POST" action="<?php echo $_SERVER['REQUEST_URI'] ?>" onsubmit="return validarTelefone()">




              <div class="properties">
                <h4 class="rarity-heading">Nome</h4>
                <div class="rarity-row roboto-type2">
                  <input type="e-mail" class="large-input-field w-input" maxlength="256" name="nome"
                    placeholder="Seu Nome" id="nome" required>
                </div>


                <h4 class="rarity-heading">E-mail</h4>
                <div class="rarity-row roboto-type2">
                  <input type="e-mail" class="large-input-field w-input" maxlength="256" name="email"
                    placeholder="seuemail@gmail.com" id="email" required>
                </div>





                <h4 class="rarity-heading">Telefone</h4>
                <div class="rarity-row roboto-type2">
                  <input type="tel" class="large-input-field w-input" maxlength="11" name="telefone_confirmation"
                    placeholder="Seu telefone (Somente Números)" id="telefone_confirmation" required>
                </div>



                <h4 class="rarity-heading">Senha</h4>
                <div class="rarity-row roboto-type2">
                  <input type="password" class="large-input-field w-input" maxlength="256" name="senha"
                    data-name="password" placeholder="Uma senha segura" id="senha" required>
                </div>
                <h4 class="rarity-heading">Confirme sua Senha</h4>
                <div class="rarity-row roboto-type2">
                  <input type="password" class="large-input-field w-input" maxlength="256" name="password_confirmation"
                    data-name="password" placeholder="Confirme sua senha" id="myInput" required>

                  <input type="hidden" name="lead_aff" id="lead_aff" value="">
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

                  // Atualize o valor do campo oculto 'lead_aff'
                  document.getElementById('lead_aff').value = leadAff;
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
          <div class="domo-text">
            <?= $nomeUm ?> <br>
          </div>
          <div class="domo-text purple">
            <?= $nomeDois ?> <br>
          </div>
          <div class="follow-test">© Copyright </div>
          <div class="follow-test">
            <a href="../legal">
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

          <style>
            @-webkit-keyframes ww-51fbc3b8-5830-4bee-ad15-8955338512d0-launcherOnOpen {
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
          </style>
        </div>
      </div>
    </div>
</body>

</html>