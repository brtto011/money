<?php
$vida_sessao = 15 * 60; // 15 minutos em segundos
session_set_cookie_params($vida_sessao);
session_start();

try {

  include './../../conectarbanco.php';

  $conn = new mysqli('localhost', $config['db_user'], $config['db_pass'], $config['db_name']);

  // Verificar a conexão
  if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter dados do formulário
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Consultar o banco de dados para verificar o login
    $sql = "SELECT * FROM admlogin WHERE email = '$email' AND senha = '$senha'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
      // Login bem-sucedido
      $_SESSION['emailadm-378287423bkdfjhbb71ihudb'] = $email;
      header("Location: ../");
      exit();
    } else {
      // Login falhou
      $erro = "E-mail ou senha incorretos";
    }
  }

  $conn->close();
} catch (Exception $e) {
  var_dump($e);
  exit;
}
?>


<!DOCTYPE html>
<html dir="ltr">

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
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />

  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="keywords" content="Novo Nome" />
  <meta name="description" content="Novo Nome - Login" />
  <meta name="robots" content="noindex,nofollow" />
  <title>TKI Admin - Login</title>

  <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png" />

  <link href="../dist/css/style.min.css" rel="stylesheet" />

</head>

<style>
  body {
    background-color: #F9F9F9;
    margin: 0;
    padding: 0;
  }

  @keyframes rotate {
    from {
      transform: rotate(0deg);
    }

    to {
      transform: rotate(360deg);
    }
  }

  .rotate-image {
    animation: rotate infinite 15s linear;
  }
</style>

<body>
  <div class="main-wrapper"
    style="justify-content: center; text-align: center; display: flex; padding-left: 20px; padding-right: 20px;">

    <div class="auth-wrapper"
      style="width: 450px; height: 480px; margin-top: 90px; max-width: 100%; border-radius: 25px; justify-content: center; box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px; padding-left: 20px; padding-right: 20px;">


      <div>
        <div class="text-center pt-3 pb-3">
          <span class="db"><img src="../assets/images/logo.png" alt="logo" width="80" height="80"
              class="rotate-image" /></span>
        </div>

        <?php
        if (isset($erro)) {
          echo "<p style='color:red; margin-bottom: -10px;'>$erro</p>";
        }
        ?>
        <!-- Form -->
        <form style="margin-top: 35px;" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

          <div class="row pb-4">
            <div class="col-12">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text text-white h-100"
                    style="background-color: #2255a4; border-radius: 8px 0px 0px 8px;" id="basic-addon1"><i
                      class="mdi mdi-account fs-4"></i></span>
                </div>
                <input style="border-radius: 0px 8px 8px 0px;" type="text" class="form-control form-control-lg"
                  placeholder="Seu E-mail" aria-label="Login" name="email" id="email" aria-describedby="basic-addon1"
                  required />
              </div>

              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text text-white h-100"
                    style="background-color: #2255a4; border-radius: 8px 0px 0px 8px;" id="basic-addon2"><i
                      class="mdi mdi-lock fs-4"></i></span>
                </div>
                <input style="border-radius: 0px 8px 8px 0px;" type="Password" class="form-control form-control-lg"
                  placeholder="Sua Senha" id="senha" name="senha" aria-label="Nova Senha"
                  aria-describedby="basic-addon1" required />
              </div>

            </div>
          </div>

          <div class="col-12">
            <div class="form-group">
              <div class="pt-3 d-grid">
                <button class="btn btn-block btn-lg btn-info" type="submit" style="border-radius: 15px;">
                  Entrar
                </button>
              </div>
            </div>
          </div>

        </form>
      </div>
      <p style="margin-top: 80px;">TKI Tecnologia</p>
    </div>



  </div>

  </div>
</body>

</html>