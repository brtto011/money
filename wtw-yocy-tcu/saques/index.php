<?php
session_start();

// Verificar se a sessão existe
if (!isset($_SESSION['emailadm-378287423bkdfjhbb71ihudb'])) {
  // Sessão não existe, redirecionar para outra página
  header("Location: ../login");
  exit();
}

?>


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
    <?php
    session_start();

    function make_request($url, $payload, $method = 'POST')
    {
      global $client_id, $client_secret;

      $headers = array(
        "Content-Type: application/json",
        "ci: $client_id",
        "cs: $client_secret"
      );

      $ch = curl_init($url);

      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      $result = curl_exec($ch);
      curl_close($ch);
      return $result;
    }
    ?>
    <?php
    // Conectar ao banco de dados
    include './../../conectarbanco.php';

    $conn = new mysqli('localhost', $config['db_user'], $config['db_pass'], $config['db_name']);

    // Verificar a conexão
    if ($conn->connect_error) {
      die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Obtém as credenciais do gateway
    $client_id = '';
    $client_secret = '';

    $sql = "SELECT client_id, client_secret FROM gateway";
    $result = $conn->query($sql);
    if ($result) {
      $row = $result->fetch_assoc();
      if ($row) {
        $client_id = $row['client_id'];
        $client_secret = $row['client_secret'];
      }
    } else {
      // Tratar caso ocorra um erro na consulta
    }

    $conn->close();

    ?>

    <!-- ==========    MENU    =================== -->
    <?php include '../components/aside.php' ?>

    <div class="page-wrapper">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Tabela de Saques</h5>
          <div class="table-responsive">
            <table id="user-table" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>Email</th>
                  <th>Cod. Referencia</th>
                  <th>Chave PIX</th>
                  <th>Valor</th>
                  <th>Status</th>
                  <th>Ações</th>

                </tr>
              </thead>
              <tbody id="table-body">
                <!-- Dados da tabela serão inseridos aqui -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal Detalhes -->
    <div class="modal fade" id="modalDetalhes" tabindex="-1" role="dialog" aria-labelledby="modalDetalhesLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalDetalhesLabel">Confirmar Saque </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p><strong>Cód. Referência:</strong> <span id="detalheExternalReference"></span></p>
            <p><strong>Email:</strong> <span id="detalheEmail"></span></p>
            <p><strong>Pix:</strong> <span id="detalheCPF"></span></p>
            <p><strong>Valor:</strong> <span id="detalheValor"></span></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnFechar">CANCELAR</button>
            <button type="button" class="btn btn-danger" id="btnConfirmar">CONFIRMAR</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modalDetalhesRejeitar" tabindex="-1" role="dialog" aria-labelledby="modalDetalhesLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalDetalhesLabel">Rejeitar Saque </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p><strong>Cód. Referência:</strong> <span id="detalheExternalReferenceRejeitar"></span></p>
            <p><strong>Email:</strong> <span id="detalheEmailRejeitar"></span></p>
            <p><strong>Pix:</strong> <span id="detalheCPFRejeitar"></span></p>
            <p><strong>Valor:</strong> <span id="detalheValorRejeitar"></span></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"
              id="btnFecharRejeitar">CANCELAR</button>
            <button type="button" class="btn btn-danger" id="btnRejeitar">CONFIRMAR</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Inclua o jQuery antes do seu código JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
      $(document).ready(function () {
        // Use AJAX para buscar dados do arquivo PHP
        $.ajax({
          url: 'bd.php',
          method: 'GET',
          success: function (data) {
            // Limpar o corpo da tabela
            $('#table-body').empty();

            // Inserir dados na tabela
            data.forEach(function (row) {
              var statusClass = row.status === 'Aprovado' ? 'text-success' : 'text-danger';
              var buttons = '';

              if (row.status === 'Aguardando Aprovação') {
                buttons += `<button class='aprovar-btn' data-toggle='modal' data-target='#aprovarModal' 
                                  data-email='${row.email}' data-externalreference='${row.externalreference}' 
                                  data-nome='${row.nome}' data-cpf='${row.cpf}' data-valor='${row.valor}'>Aprovar</button>`;
              }

              if (row.status === 'Aguardando Aprovação') {
                buttons += `<button class='rejeitar-btn' data-toggle='modal' data-target='#rejeitarModal' 
                                  data-email='${row.email}' data-externalreference='${row.externalreference}' 
                                  data-nome='${row.nome}' data-cpf='${row.cpf}' data-valor='${row.valor}'>Rejeitar</button>`;
              }

              var newRow = `<tr>
                                <td>${row.email}</td>
                                <td>${row.externalreference}</td>
                                <td>${row.cpf}</td>
                                <td>${row.valor}</td>
                                <td class='${statusClass}'>${row.status}</td>
                                <td>${buttons}</td>
                              </tr>`;

              $('#table-body').append(newRow);
            });

            // Inicializar DataTables após a conclusão da chamada AJAX
            $('#user-table').DataTable({
              ordering: false // Desativa a ordenação automática
            });

            // Adicionar evento de clique para o botão "Aprovar"
            $('.aprovar-btn').click(function () {
              // Preencher os detalhes no modal
              $('#detalheEmail').text($(this).data('email'));
              $('#detalheExternalReference').text($(this).data('externalreference'));
              $('#detalheNome').text($(this).data('nome'));
              $('#detalheCPF').text($(this).data('cpf'));
              $('#detalheValor').text($(this).data('valor'));

              // Abrir o modal
              $('#modalDetalhes').modal('show');
            });
            $('.rejeitar-btn').click(function () {
              // Preencher os detalhes no modal
              $('#detalheEmailRejeitar').text($(this).data('email'));
              $('#detalheExternalReferenceRejeitar').text($(this).data('externalreference'));
              $('#detalheNomeRejeitar').text($(this).data('nome'));
              $('#detalheCPFRejeitar').text($(this).data('cpf'));
              $('#detalheValorRejeitar').text($(this).data('valor'));

              // Abrir o modal
              $('#modalDetalhesRejeitar').modal('show');
            });
          },
          error: function () {
            console.log('Erro ao obter dados do servidor.');
          }
        });

        // Adicionar evento de clique para o botão "Confirmar" no modal
        $('#btnConfirmar').on('click', function () {
          // Obtenha os detalhes necessários do afiliado (substitua com os seus dados)
          var chavePix = $('#detalheCPF').text(); // Substitua com o ID ou classe apropriado
          var saqueValor = parseFloat($('#detalheValor').text()); // Substitua com o ID ou classe apropriado
          var external_reference = $('#detalheExternalReference').text();
          var email = $('#detalheEmail').text();

          // Crie os dados para a chamada AJAX
          var requestData = {
            "value": saqueValor,
            "key": chavePix,
            "typeKey": "document"
          };

          // Realize a chamada AJAX para aprovar o saque no arquivo PHP
          $.ajax({
            type: "POST",
            url: "aprovar_saque.php", // Substitua com o nome do seu arquivo PHP
            data: {
              requestData: JSON.stringify(requestData),
              external_reference: external_reference,
              email: email
            },
            success: function (response) {
              console.log('Saque aprovado:', response);
              updateStatus(external_reference, email, saqueValor);
              // Feche o modal
              $('#modalDetalhes').modal('hide');
            },
            error: function (error) {
              console.error('Erro ao aprovar o saque:', error);
              // Adicione lógica para lidar com o erro (exibir mensagem de erro, etc.)
            }
          });
        });

        // Adicionar evento de clique para o botão "Rejeitar" no modal
        $('#btnRejeitar').on('click', function () {
          var external_reference = $('#detalheExternalReferenceRejeitar').text();

          updateStatusRejeitar(external_reference);

        });

        $('#btnFechar').on('click', function () {
          // Feche o modal
          $('#modalDetalhes').modal('hide');
        });

        function updateStatus(external_reference, email, saqueValor) {
          status = 'Aprovado'
          console.log('datas', external_reference, email, saqueValor, status);
          // Realize uma nova solicitação ao servidor para executar uma atualização no banco de dados
          $.ajax({
            type: "POST",
            url: "atualizar_status.php", // Substitua pelo caminho correto
            data: { external_reference: external_reference, status: status, email: email, valor: saqueValor, },

            success: function (response) {
              console.log('Status atualizado:', response);
              window.location.reload();
            },
            error: function (error) {
              console.error('Erro ao atualizar o status:', error);
              // Adicione lógica para lidar com o erro (exibir mensagem de erro, etc.)
            }
          });
        };

        function updateStatusRejeitar(external_reference) {
          status = 'Rejeitado'
          // Realize uma nova solicitação ao servidor para executar uma atualização no banco de dados
          $.ajax({
            type: "POST",
            url: "rejeitar_saque.php", // Substitua pelo caminho correto
            data: { external_reference: external_reference, status: status },

            success: function (response) {
              console.log('Status atualizado:', response);
              window.location.reload();
            },
            error: function (error) {
              console.error('Erro ao atualizar o status:', error);
              // Adicione lógica para lidar com o erro (exibir mensagem de erro, etc.)
            }
          });
        }
      });
    </script>






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