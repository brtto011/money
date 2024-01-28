<?php
session_start();

// Verificar se a sessão existe
if (!isset($_SESSION['emailadm-378287423bkdfjhbb71ihudb'])) {
  // Sessão não existe, redirecionar para outra página
  header("Location: ../login");
  exit();
}

?>


<?php
include './bd.php'; ?>

<!DOCTYPE html>
<html dir="ltr" lang="en">

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

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="keywords" content="Admin Dashboard" />
  <meta name="description" content="Admin Dashboard" />
  <meta name="robots" content="noindex,nofollow" />
  <title>TKI Admin - Dashboard</title>

  <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png" />
  <!-- Custom CSS -->
  <link href="../assets/libs/flot/css/float-chart.css" rel="stylesheet" />
  <!-- Custom CSS -->
  <link href="../dist/css/style.min.css" rel="stylesheet" />

  <script>
    $(document).ready(function () {
      $("#notificacao-form").submit(function (event) {
        event.preventDefault(); // Evita que o formulário seja enviado normalmente

        var canalID = $("#canal-id").val();

        $.ajax({
          url: "bd.php",
          type: "POST",
          data: { canalID: canalID },
          success: function (response) {
            console.log(response);
            alert(response);
          },
          error: function (error) {
            console.log(error);
            alert("Erro. Verifique o console");
          }
        });
      });
    });
  </script>
</head>

<body>
  <!-- ============================================================== -->
  <!-- Preloader - style you can find in spinners.css -->
  <!-- ============================================================== -->
  <div class="preloader">
    <div class="lds-ripple">
      <div class="lds-pos"></div>
      <div class="lds-pos"></div>
    </div>
  </div>
  <!-- ============================================================== -->
  <!-- Main wrapper - style you can find in pages.scss -->
  <!-- ============================================================== -->
  <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
    data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->

    <style>
      .topbar .nav-toggler,
      .topbar .topbartoggler {
        color: #343a40;
        padding: 0 15px;
        font-size: 25px;
      }
    </style>

    <header class="topbar">
      <nav class="navbar top-navbar navbar-expand-md">
        <div class="navbar-header">
          <!-- ============================================================== -->
          <!-- Logo -->
          <!-- ============================================================== -->
          <a class="navbar-brand" href="#" style="background-color: #fff;">
            <!-- Logo icon -->
            <b class="logo-icon ps-2">
              <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
              <!-- Dark Logo icon -->
              <img src="../assets/images/logo-icon.png " alt="homepage" class="light-logo" width="50"
                style="margin-right: -10px; margin-left: -10px;" />
            </b>
            <!--End Logo icon -->
            <!-- Logo text -->
            <span class="logo-text ms-2" style="color: #343a40; font-weight: 700; margin-left: -35px;">
              TKI Tecnologia
            </span>
            <!-- Logo icon -->
            <!-- <b class="logo-icon"> -->
            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
            <!-- Dark Logo icon -->
            <!-- <img src="../assets/images/logo-text.png" alt="homepage" class="light-logo" /> -->

            <!-- </b> -->
            <!--End Logo icon -->
          </a>
          <!-- ============================================================== -->
          <!-- End Logo -->
          <!-- ============================================================== -->
          <!-- ============================================================== -->
          <!-- Toggle which is visible on mobile only -->
          <!-- ============================================================== -->
          <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
              class="ti-menu ti-close"></i></a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse collapse" style="background-color: #fff;">
          <!-- ============================================================== -->
          <!-- toggle and nav items -->
          <!-- ============================================================== -->
          <ul class="navbar-nav float-start me-auto">
            <li class="nav-item d-none d-lg-block">
              <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)"
                data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24" style="color: #333;"></i></a>
            </li>



          </ul>
        </div>
      </nav>
    </header>
    <!-- ==========    MENU    =================== -->
    <?php include '../components/aside.php' ?>

    <div class="page-wrapper">



      <div class="card" style="margin-bottom: 100px;">
        <div class="card-body">

        </div>
        <h2 style="margin-left: 25px;">Recebimento de Notificaçães no Telegram</h1>





          <form id="notificacao-form">
            <div class="card">
              <div class="card-body">

                <div class="form-group row">
                  <label class="col-md-3 mt-3">ESTADO:</label>
                  <div class="col-md-9">
                    <select class="select2 form-select shadow-none"
                      style="width: 200px; text-align: center; height: 36px; border-radius: 10px;">
                      <option>ATIVADO</option>
                      <option value="desativado">DESATIVADO</option>




                    </select>
                  </div>
                </div>


                <div class="form-group row" style="margin-top: 50px;">
                  <label class="col-md-3">Disparos de Notificações </label>
                  <div class="col-md-9">
                    <div class="form-check mr-sm-2">
                      <input type="checkbox" class="form-check-input" id="customControlAutosizing1" checked />
                      <label class="form-check-label mb-0" for="customControlAutosizing1">Cadastro</label>
                    </div>
                    <div class="form-check mr-sm-2">
                      <input type="checkbox" class="form-check-input" id="customControlAutosizing2" checked />
                      <label class="form-check-label mb-0" for="customControlAutosizing2">PIX Gerado</label>
                    </div>
                    <div class="form-check mr-sm-2">
                      <input type="checkbox" class="form-check-input" id="customControlAutosizing3" checked />
                      <label class="form-check-label mb-0" for="customControlAutosizing3">Pix Pago</label>
                    </div>
                  </div>
                </div>

                <div class="form-group row" style="margin-top: 50px;">
                  <label class="col-md-3" for="disabledTextInput">ID do Canal Atual: </label>
                  <div class="col-md-9">
                    <input style="border-radius: 5px; width: 300px;" type="text" id="disabledTextInput"
                      class="form-control" placeholder="<?php echo $canal_id; ?>" disabled />
                  </div>
                </div>


                <div class="form-group row">
                  <label class="col-md-3">Inserir novo ID : </label>
                  <div class="col-md-9">
                    <input style="border-radius: 5px; width: 300px" type="text" id="canal-id" class="form-control"
                      placeholder="Insira seu novo ID" />
                  </div>
                </div>



                <button type="submit" class="btn btn-primary" style="margin-top: 50px; border-radius: 5px;">
                  Salvar Alterações
                </button>
              </div>
            </div>

          </form>









          <!-- ============================================================== -->

          <!-- card new -->
          <div class="card">
            <div class="card-body">
              <h4 class="card-title mb-0">Observações:</h4>
            </div>
            <ul class="list-style-none">
              <li class="d-flex no-block card-body">

                <div>

                  <span class="text-muted">Sistema de notificações em atualização!</span>

                  <a href="#" class="mb-0 font-medium p-0">Para receber as notificações deve adicionar o bot @tki_bot no
                    seu canal e dar todas as permissões de Administrador.</a>

                </div>
                <div class="ms-auto">

                </div>
              </li>


            </ul>
          </div>


          <!-- ============================================================== -->



      </div>




      <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
      <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>









      <!-- ============================================================== -->
      <!-- End footer -->
      <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- ============================================================== -->
  </div>
  <!-- ============================================================== -->
  <!-- End Wrapper -->
  <!-- ============================================================== -->
  <!-- ============================================================== -->
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap tether Core JavaScript -->
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!-- slimscrollbar scrollbar JavaScript -->
  <script src="../assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
  <script src="../assets/extra-libs/sparkline/sparkline.js"></script>
  <!--Wave Effects -->
  <script src="../dist/js/waves.js"></script>
  <!--Menu sidebar -->
  <script src="../dist/js/sidebarmenu.js"></script>
  <!--Custom JavaScript -->
  <script src="../dist/js/custom.min.js"></script>
  <!-- this page js -->
  <script src="../assets/extra-libs/multicheck/datatable-checkbox-init.js"></script>
  <script src="../assets/extra-libs/multicheck/jquery.multicheck.js"></script>
  <script src="../assets/extra-libs/DataTables/datatables.min.js"></script>
  <script>
    /****************************************
     *       Basic Table                   *
     ****************************************/
    $("#zero_config").DataTable();
  </script>
</body>

</html>