
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
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="keywords" content="Admin Dashboard" />
  <meta name="description" content="Admin Dashboard" />
  <meta name="robots" content="noindex,nofollow" />
  <title>Admin Dashboard</title>

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

  <!-- ============================================================== -->
  <!-- Main wrapper - style you can find in pages.scss -->
  <!-- ============================================================== -->
  <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
    data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <header class="topbar" data-navbarbg="skin5">
      <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <div class="navbar-header" data-logobg="skin5">
          <!-- ============================================================== -->
          <!-- Logo -->
          <!-- ============================================================== -->
          <a class="navbar-brand" href="../">
            <!-- Logo icon -->
            <b class="logo-icon ps-2">
              <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
              <!-- Dark Logo icon -->
              <img src="../assets/images/logo-icon.png " alt="homepage" class="light-logo" width="25" />
            </b>
            <!--End Logo icon -->
            <!-- Logo text -->
            <span class="logo-text ms-2">
              <!-- dark Logo text -->
              <img src="../assets/images/logo-text.png" width="150" height="50" alt="homepage" class="light-logo" />
            </span>

          </a>

          <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
              class="ti-menu ti-close"></i></a>
        </div>

        <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">

          <ul class="navbar-nav float-start me-auto">
            <li class="nav-item d-none d-lg-block">
              <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)"
                data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a>
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
          <h5 class="card-title">Configurações de Notificaçães</h5>
        </div>
        <h2 style="margin-left: 25px;">Recebimento de Notificaçães no Telegram</h1>

      
        
       
      
      <form id="notificacao-form">
       <div class="card">
                <div class="card-body">
              
                  <div class="form-group row">
                    <label class="col-md-3 mt-3">ESTADO:</label>
                    <div class="col-md-9">
                      <select
                        class="select2 form-select shadow-none"
                        style="width: 100%; height: 36px"
                      >
                        <option>ATIVADO</option>
                        <optgroup label="">
                          <option value="ativado">ATIVADO</option>
                          <option value="desativado">DESATIVADO</option>
                        </optgroup>
                    
                     
                     
                      </select>
                    </div>
                  </div>
                
                 
                  <div class="form-group row">
                    <label class="col-md-3">Disparos de Notificações </label>
                    <div class="col-md-9">
                      <div class="form-check mr-sm-2">
                        <input
                          type="checkbox"
                          class="form-check-input"
                          id="customControlAutosizing1"
                           checked
                        />
                        <label
                          class="form-check-label mb-0"
                          for="customControlAutosizing1"
                          >Cadastro</label
                        >
                      </div>
                      <div class="form-check mr-sm-2">
                        <input
                          type="checkbox"
                          class="form-check-input"
                          id="customControlAutosizing2"
                          checked
                        />
                        <label
                          class="form-check-label mb-0"
                          for="customControlAutosizing2"
                          >PIX Gerado</label
                        >
                      </div>
                      <div class="form-check mr-sm-2">
                        <input
                          type="checkbox"
                          class="form-check-input"
                          id="customControlAutosizing3"
                          checked
                        />
                        <label
                          class="form-check-label mb-0"
                          for="customControlAutosizing3"
                          >Pix Pago</label
                        >
                      </div>
                    </div>
                  </div>
                  
                    <div class="form-group row">
                    <label class="col-md-3" for="disabledTextInput"
                      >ID do Canal Atual: </label
                    >
                    <div class="col-md-9">
                      <input
                        type="text"
                        id="disabledTextInput"
                        class="form-control"
                        placeholder="<?php echo $canal_id; ?>"
                        disabled
                      />
                    </div>
                  </div>
                  
                
                  <div class="form-group row">
                    <label class="col-md-3" 
                      >Inserir novo ID : </label
                    >
                    <div class="col-md-9">
                      <input
                        type="text"
                       id="canal-id"
                        class="form-control"
                        placeholder="Insira seu novo ID"
                      
                      />
                    </div>
                  </div>
                  
            

                    <button type="submit" class="btn btn-primary">
                      Salvar Alterações 
                    </button>
                  </div>
                </div>
           
                  </form>
              


        

                  
        
        
        
                  <!-- ============================================================== -->

 <!-- card new -->
 <div class="card">
  <div class="card-body">
    <h4 class="card-title mb-0">Observacoes:</h4>
  </div>
  <ul class="list-style-none">
    <li class="d-flex no-block card-body">
    
      <div>
        <a href="#" class="mb-0 font-medium p-0"
          >Para receber as notificações deve adicionar o bot @tki_bot no seu canal e dar todas as permissões de ADM</a
        >
        <span class="text-muted"
          >Sistema em atualização</span
        >
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








    <footer style="position: fixed; bottom: 0; width: 100%; left: 0;" class="footer text-center">
      Desenvolvido por
      <a href="http://tkitecnologia.com/">TKI TECNOLOGIA</a>.
    </footer>
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