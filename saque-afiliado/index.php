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
session_start();

// Verifique se o email está definido na sessão
if (!isset($_SESSION['email'])) {
  header("Location: ../");
  exit();
}

// Inicie a conexão com o banco de dados
include './../conectarbanco.php';

$conn = new mysqli('localhost', $config['db_user'], $config['db_pass'], $config['db_name']);

// Verificar a conexão
if ($conn->connect_error) {
  die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Inicialize as mensagens
$mensagem_saque_ok = "";
$mensagem_saque_erro = "";

// Recupere o email da sessão
if (isset($_SESSION['email'])) {
  $email = $_SESSION['email'];



  $getLinkQuery = "SELECT saque_min_afiliado FROM app";
  $stmt = $conn->prepare($getLinkQuery);
  $stmt->execute();
  $stmt->bind_result($saque_min_afiliado);
  $stmt->fetch();
  $stmt->close();

  $getLinkQuery = "SELECT rollover_saque FROM app";
  $stmt = $conn->prepare($getLinkQuery);
  $stmt->execute();
  $stmt->bind_result($rollover_saque);
  $stmt->fetch();
  $stmt->close();

  $getLinkQuery = "SELECT depositou FROM appconfig WHERE email = ?";
  $stmt = $conn->prepare($getLinkQuery);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->bind_result($depositou);
  $stmt->fetch();
  $stmt->close();


  $rollover_atual = floatval($depositou) * floatval($rollover_saque);







  // Consulta para obter o saldo de comissão associado ao email na tabela appconfig
  $consulta_saldo = "SELECT saldo_comissao FROM appconfig WHERE email = '$email'";
  $consulta_status = "SELECT status FROM saque_afiliado WHERE email = '$email' ORDER BY data_solicitacao DESC LIMIT 1";
  $resultado_status = $conn->query($consulta_status);
  // Execute a consulta
  $resultado_saldo = $conn->query($consulta_saldo);
  //soma total
  $soma_dos_aprovados = "SELECT SUM(valor) as total_saque
        FROM saque_afiliado
        WHERE email = '$email'
        AND status = 'APROVADO'";
  $resultado_soma_dos_aprovados = $conn->query($soma_dos_aprovados);

  // Verifique se a consulta foi bem-sucedida
  if (!$resultado_soma_dos_aprovados) {
    die("Erro na consulta: " . $conn->error);
  }

  // Obtenha os resultados da consulta
  $row_soma_total_aprovados = $resultado_soma_dos_aprovados->fetch_assoc();


  // Verifique se a consulta foi bem-sucedida
  if ($resultado_saldo) {
    if ($resultado_saldo->num_rows > 0) {
      // Obtenha o saldo da primeira linha
      $row = $resultado_saldo->fetch_assoc();
      $saldo = $row['saldo_comissao'];

      $nome_destinatario = $_POST['withdrawName']; // Supondo que os dados sejam enviados por um formulário POST
      $pix = $_POST['withdrawCPF']; // Supondo que os dados sejam enviados por um formulário POST
      $valor_disponivel = $saldo;
      // Consulta de inserção
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($nome_destinatario) && !empty($pix)) {
          // Verifique se o valor do saque é maior que zero e menor ou igual ao saldo disponível
          $valor_saque = floatval($valor_disponivel);
          $row_status = $resultado_status->fetch_assoc();
          $status = trim($row_status['status']);
          $external_reference = uniqid();

          if ($status == 'Aguardando Aprovação') {
            echo "<script>alert('Existe saque solicitado na fila. Por favor, aguarde');</script>";
          } else {
            if ($valor_saque > 0 && $valor_saque <= $saldo && $saldo >= $saque_min_afiliado) {
              $status = 'Aguardando Aprovação';
              $consulta_inserir_saque = "INSERT INTO saque_afiliado (email, nome, pix, valor, status, externalreference, data_solicitacao)
                            VALUES ('$email', '$nome_destinatario', '$pix', $valor_saque, 'Aguardando Aprovação', '$external_reference', CURRENT_TIMESTAMP)";

              // Execute a consulta de inserção e verifique se há erros
              if ($conn->query($consulta_inserir_saque)) {
                echo "<script>window.location.reload();</script>";
              } else {
                echo "Erro ao inserir o saque: " . $conn->error;
              }
            } else {

              $mensagem_saque_erro = "Valor de saque inválido, saldo insuficiente ou abaixo do limite mínimo de saque.";

            }
          }
        } else {
          $mensagem_saque_erro = "Campos nome_destinatario e pix são obrigatórios.";
        }

      }
    }
  }
}

// Feche a conexão com o banco de dados
$conn->close();
?>




<!DOCTYPE html>

<html lang="pt-br" class="w-mod-js w-mod-ix wf-spacemono-n4-active wf-spacemono-n7-active wf-active">

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
  <meta name="twitter:site" content="@<?= $nomeUnico ?>">
  <meta name="twitter:image" content="../img/logo.png">
  <meta property="og:type" content="website">

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

</head>

<body>
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
          <a href="../painel/" class="nav-link w-nav-link" style="max-width: 940px;">Jogar</a>
          <a href="../saque/" class="nav-link w-nav-link" style="max-width: 940px;">Saque</a>

          <a href="../afiliate" class="nav-link w-nav-link w--current" style="max-width: 940px;">Indique e Ganhe</a>

          <a href="../logout.php" class="nav-link w-nav-link" style="max-width: 940px;">Sair</a>
          <a href="../deposito/" class="button nav w-button">Depositar</a>
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







        <style>
          .menu-button2 {
            border-radius: 15px;
            background-color: #000;
          }
        </style>




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
      <a href="../painel/" class="button w-button">
        <div>Jogar</div>
      </a>
      <a href="../saque/" class="button w-button">
        <div>Saque</div>
      </a>

      <a href="../afiliate/" class="button w-button">
        <div>Indique & ganhe</div>
      </a>
      <a href="../logout.php" class="button w-button">
        <div>Sair</div>
      </a>
      <a href="../deposito/" class="button w-button">Depositar</a>
    </div>



    <div class="all">

      <section id="hero" class="hero-section dark wf-section">
        <div class="minting-container w-container">
          <img src="arquivos/with.gif" loading="lazy" width="240" data-w-id="6449f730-ebd9-23f2-b6ad-c6fbce8937f7"
            alt="Roboto #6340" class="mint-card-image">
          <h2>Saque</h2>
          <p>PIX: saques instantâneos com muita praticidade. <br>
          </p>





          <form data-name="" id="payment_pix" name="payment_pix" method="post" aria-label="Form">
            <div class="properties">
              <h4 class="rarity-heading">Seu e-mail:</h4>
              <div class="rarity-row roboto-type2">
                <input type="text"
                  class="large-input-field w-node-_050dfc36-93a8-d840-d215-4fca9adfe60d-9adfe605 w-input"
                  maxlength="256" placeholder="<?= $email ?>" disabled>
              </div>
              <h4 class="rarity-heading">Nome do destinatário:</h4>
              <div class="rarity-row roboto-type2">
                <input type="text"
                  class="large-input-field w-node-_050dfc36-93a8-d840-d215-4fca9adfe60d-9adfe605 w-input"
                  maxlength="256" name="withdrawName" placeholder="Nome do Destinatario" id="withdrawName" required="">
              </div>
              <h4 class="rarity-heading">Chave PIX CPF:</h4>
              <div class="rarity-row roboto-type2">
                <input type="text"
                  class="large-input-field w-node-_050dfc36-93a8-d840-d215-4fca9adfe60d-9adfe605 w-input"
                  maxlength="256" name="withdrawCPF" placeholder="Seu número de CPF" id="withdrawCPF" required="">
              </div>
              <h4 class=" rarity-heading">Valor disponível para saque:</h4>
              <div class="rarity-row roboto-type2">
                <input type="number" data-name="Valor de saque" placeholder="R$<?= $saldo ?>" disabled="">
              </div>
            </div>
            <div class="">

              <p id="saque-ok" style="color: green; display: <?php echo $mensagem_saque_ok ? 'block' : 'none'; ?>">
                <?php echo $mensagem_saque_ok; ?>
              </p>
              <p id="saque-error" style="color: red; display: <?php echo $mensagem_saque_erro ? 'block' : 'none'; ?>">
                <?php echo $mensagem_saque_erro; ?>
              </p>

              <input type="submit" value="Sacar" id="sacarpix" class="primary-button w-button"><br><br>

              </p>
            </div>


            <h4>Saque Mínimo: R$
              <?= $saque_min_afiliado ?> <br>
            </h4>










          </form>








        </div>
      </section>
      <!-- <div class="intermission wf-section"></div>
    <div id="rarity" class="rarity-section wf-section">
      <div class="minting-container w-container">
        <img src="arquivos/money-cash.gif" loading="lazy" width="240" alt="Robopet 6340" class="mint-card-image">
        <h2>Histórico financeiro</h2>
        <p class="paragraph">As retiradas para sua conta bancária são processadas pelo setor financeiro.
          <br>
        </p>
        <div class="properties">
          <h3 class="rarity-heading">Saques realizados</h3>
        </div>
      </div> -->
    </div>
    <div class="intermission wf-section"></div>
    <div id="about" class="comic-book white wf-section">
      <div class="minting-container left w-container">
        <div class="w-layout-grid grid-2">
          <img src="arquivos/money.png" loading="lazy" width="240" alt="Roboto #6340" class="mint-card-image v2">
          <div>
            <h2>Indique um amigo e ganhe no PIX</h2>
            <h3>Como funciona?</h3>
            <p>Convide seus amigos que ainda não estão na plataforma. Não há limite para quantos amigos você pode
              convidar. Isso
              significa que também não há limite para quanto você pode ganhar!</p>
            <h3>Como recebo o dinheiro?</h3>
            <p>O saldo é adicionado diretamente ao seu saldo no painel abaixo, com o qual você pode sacar
              via
              PIX.</p>
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
        <a href="#">
          <strong class="bold-white-link">Termos de uso</strong>
        </a>
      </div>
      <div class="follow-test">contato@
        <?= $nomeUnico ?>.net
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
      <div
        style="display: flex; flex-direction: column; z-index: 999999; bottom: 88px; position: fixed; right: 16px; direction: ltr; align-items: end; gap: 8px;">
        <div style="display: flex; gap: 8px;"></div>
      </div>
      <style>
        @-webkit-keyframes ww-1d3e1845-0974-4ce9-92ae-64548dac571e-launcherOnOpen {
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

        @keyframes ww-1d3e1845-0974-4ce9-92ae-64548dac571e-launcherOnOpen {
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

        @keyframes ww-1d3e1845-0974-4ce9-92ae-64548dac571e-widgetOnLoad {
          0% {
            opacity: 0;
          }

          100% {
            opacity: 1;
          }
        }

        @-webkit-keyframes ww-1d3e1845-0974-4ce9-92ae-64548dac571e-widgetOnLoad {
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