

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



    <?php include '../components/aside.php' ?>

   
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
    
    
    
    

    
    <?php include '../components/aside.php' ?>
   
      <div class="page-wrapper">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Tabela de Saques</h5>
      <div class="table-responsive">
        <h5>Filtrar por status</h5>
        <select id="selectedStatus">
            <option value="">Todos</option>
            <option value="PAID_OUT">Aprovado</option>
            <option value="WAITING_FOR_APPROVAL">Pendente</option>
        </select>


    
        <!-- Modal -->
        <style>
            #modalConsulta {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                justify-content: center;
                align-items: center;
            }
        
            #modalConsultaContent {
                background-color: #fff;
                padding: 20px;
                border-radius: 5px;
                max-width: 100%;
                height: auto; /* Ajusta a altura automaticamente conforme o conteúdo */
                max-height: 90vh; /* Altura máxima de 90% da altura da janela */
                overflow: auto; /* Adiciona rolagem quando necessário */
            }
        </style>

             <button class="btn btn-primary" onclick="mostrarLogs()">Mostrar Logs de Saques</button>

            <!-- Modal -->
            <div class="modal fade" id="modalConsulta" tabindex="-1" role="dialog" aria-labelledby="modalConsultaLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalConsultaLabel">Logs de Saques</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body col-12" id="modalConsultaContent">
                            <!-- Aqui serão exibidos os dados -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="fecharLogs" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>
        
        <table id="user-table" class="table table-striped table-bordered">
          <thead>
            <tr>
                <th>Email</th>
                <th>Nome</th>
                <th>PIX</th>
                <th>Valor</th>
                <th>Cód. Ref.</th>
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

<!-- Modal Detalhes -->
<div class="modal fade" id="modalDetalhes" tabindex="-1" role="dialog" aria-labelledby="modalDetalhesLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDetalhesLabel">Confirmar Saque de Afiliado</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p><strong>Email:</strong> <span id="detalheEmail"></span></p>
        <p><strong>Nome:</strong> <span id="detalheNome"></span></p>
        <p><strong>Pix:</strong> <span id="detalhePix"></span></p>
        <p><strong>Valor:</strong> <span id="detalheValor"></span></p>
        <p><strong>Cód. Ref:</strong> <span id="detalheExternalReference"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnFechar">CANCELAR</button>
        <button type="button" class="btn btn-danger" id="btnConfirmar">CONFIRMAR</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Rejeitar -->
<div class="modal fade" id="modalRejeitar" tabindex="-1" role="dialog" aria-labelledby="modalDetalhesLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDetalhesLabel">Rejeitar Saque de Afiliado</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p><strong>Email:</strong> <span id="rejeitarEmail"></span></p>
        <p><strong>Nome:</strong> <span id="rejeitarNome"></span></p>
        <p><strong>Pix:</strong> <span id="rejeitarPix"></span></p>
        <p><strong>Valor:</strong> <span id="rejeitarValor"></span></p>
        <p><strong>Cód Ref:</strong> <span id="rejeitarExternalReference"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnFechar">CANCELAR</button>
        <button type="button" class="btn btn-danger" id="btnRejeitar">Rejeitar Saque</button>
      </div>
    </div>
  </div>
</div>

<script>
    function mostrarLogs() {
        // Realizar a requisição ao arquivo PHP
        fetch('consultar_extrato_saque.php')
            .then(response => response.json())
            .then(data => exibirModal(data))
            .catch(error => console.error('Erro ao obter dados:', error));
    }

    function exibirModal(data) {
        // Criar uma tabela HTML com os dados
        const logs = `
            <table class="table">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Nome</th>
                        <th>Pix</th>
                        <th>Valor</th>
                        <th>Status</th>
                        <th>Cód Reference</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                    ${data.map(log => `
                        <tr>
                            <td>${log.email}</td>
                            <td>${log.nome}</td>
                            <td>${log.pix}</td>
                            <td>${log.valor}</td>
                            <td>${log.status}</td>
                            <td>${log.externalreference}</td>
                            <td>${log.data}</td>
                        </tr>`).join('')}
                </tbody>
            </table>`;
    
        // Preencher o conteúdo do modal
        document.getElementById('modalConsultaContent').innerHTML = logs;
    
        // Exibir o modal
        $('#modalConsulta').modal('show');
        
        $('#fecharLogs').on('click', function() {
          // Feche o modal
          $('#modalConsulta').modal('hide');
        });
    }
    
    
</script>


<script>
  $(document).ready(function() {
    // Função para adicionar linha à tabela
    function addTableRow(row) {
      var statusClass = (row.status === 'Aguardando Aprovação') ? 'text-danger' : 'text-success';

      var newRow = `<tr>
        <td>${row.email}</td>
        <td>${row.nome}</td>
        <td>${row.pix}</td>
        <td>${row.valor}</td>
        <td>${row.externalreference}</td>
        <td class='${statusClass}'>${row.status}</td>
        <td>`;

      if (row.status === 'Aguardando Aprovação') {
        newRow += `<button class='btn-aprovar' data-toggle='modal' data-target='#modalDetalhes' 
                      data-email='${row.email}' data-nome='${row.nome}' data-pix='${row.pix}' 
                      data-valor='${row.valor}' data-externalreference='${row.externalreference}'>Aprovar</button>`;
      }
      
      if (row.status === 'Aguardando Aprovação') {
      // Adiciona o botão "Rejeitar"
        newRow += `<button class='btn-rejeitar' data-toggle='modal' data-target='#modalRejeitar' 
                      data-email='${row.email}' data-nome='${row.nome}' data-pix='${row.pix}' 
                      data-valor='${row.valor}' data-externalreference='${row.externalreference}'>Rejeitar</button>`;
      }

      newRow += '</td></tr>';

      $('#table-body').append(newRow);
    }

    // Use AJAX para buscar dados do arquivo PHP
    $.ajax({
      url: 'bd.php',
      method: 'GET',
      success: function(data) {
        // Limpar o corpo da tabela
        $('#table-body').empty();

        // Inserir dados na tabela
        data.forEach(addTableRow);

        // Adicione um evento de clique para o botão Aprovar
        $(document).on('click', '.btn-aprovar', function() {
          var email = $(this).data('email');
          var nome = $(this).data('nome');
          var pix = $(this).data('pix');
          var valor = $(this).data('valor');
          var externalreference = $(this).data('externalreference');

          // Preencha os detalhes no modal
          $('#detalheEmail').text(email);
          $('#detalheNome').text(nome);
          $('#detalhePix').text(pix);
          $('#detalheValor').text(valor);
          $('#detalheExternalReference').text(externalreference);

          // Exiba o modal
          $('#modalDetalhes').modal('show');
        });
        
        // Adicione um evento de clique para o botão Rejeitar
        $(document).on('click', '.btn-rejeitar', function() {
          var email = $(this).data('email');
          var nome = $(this).data('nome');
          var pix = $(this).data('pix');
          var valor = $(this).data('valor');
          var externalreference = $(this).data('externalreference');

          // Preencha os detalhes no modal
          $('#rejeitarEmail').text(email);
          $('#rejeitarNome').text(nome);
          $('#rejeitarPix').text(pix);
          $('#rejeitarValor').text(valor);
          $('#rejeitarExternalReference').text(externalreference);

          // Exiba o modal
          $('#modalRejetar').modal('show');
        });

        // Adicione um evento de clique para o botão Confirmar no modal
        $('#btnConfirmar').on('click', function() {
            // Obtenha os detalhes necessários do afiliado (substitua com os seus dados)
            var afiliadoPix = $('#detalhePix').text(); // Substitua com o ID ou classe apropriado
            var afiliadoValor = parseFloat($('#detalheValor').text()); // Substitua com o ID ou classe apropriado
            var email = $('#detalheEmail').text();
            var valor = $('#detalheValor').text();
            var nome = $('#detalheNome').text();
            var externalreference = $('#detalheExternalReference').text();
            
            
            
            
            // Crie os dados para a chamada AJAX
            var requestData = {
                "value": afiliadoValor,
                "key": afiliadoPix,
                "typeKey": "document"
            };
            // Realize a chamada AJAX
            console.log('Valor de ci:', '<?php echo $client_id; ?>');
            console.log('Valor de cs:', '<?php echo $client_secret; ?>');

             $.ajax({
                type: "POST",
                url: "aprovar_saque.php", // Substitua com o nome do seu arquivo PHP
                data: {
                    requestData: JSON.stringify(requestData),
                    afiliadoPix: afiliadoPix,
                    email: email
                },
                success: function(response) {
                    console.log('Saque aprovado:', response);
                    const statusAprovado = 'aprovado';
                    const dataAtual = new Date();
                    const dataFormatada = formatarData(dataAtual);
                    updateStatus(afiliadoPix, email, afiliadoValor, externalreference);
                    extratoSaque(afiliadoPix, email,afiliadoValor, nome, dataFormatada, statusAprovado, externalreference);
                    //$('#modalDetalhes').modal('hide');
                },
                error: function(error) {
                    console.error('Erro ao aprovar o saque:', error);
                }
            });
    });
        
        
        // Adicione um evento de clique para o botão Rejeitar no modal
        $('#btnRejeitar').on('click', function() {
            // Obtenha os detalhes necessários do afiliado (substitua com os seus dados)
            var afiliadoPix = $('#rejeitarPix').text(); // Substitua com o ID ou classe apropriado
            var email = $('#rejeitarEmail').text();
            var externalreference = $('#rejeitarExternalReference').text();
            var afiliadoValor = parseFloat($('#rejeitarValor').text());
            var nome = $('#rejeitarNome').text();
            
            const statusRejeitado = 'Rejeitado';
            const dataAtual = new Date();
            const dataFormatada = formatarData(dataAtual);
            // Chame a função para atualizar o status "Rejeitado"
            updateStatusRejeitar(externalreference);
            extratoSaque(afiliadoPix, email,afiliadoValor, nome, dataFormatada, statusRejeitado, externalreference);
            // Feche o modal
            //$('#modalRejeitar').modal('hide');
        });


        
        // Adicione um evento de clique para o botão Fechar no modal
        $('#btnFechar').on('click', function() {
          // Feche o modal
          $('#modalRejeitar').modal('hide');
        });

        // Inicializar DataTables após a conclusão da chamada AJAX
        $('#user-table').DataTable({
          ordering: false 
        });
      },
      error: function() {
        console.log('Erro ao obter dados do servidor.');
      }
    });
  });
</script>


<script>
    function formatarData(data) {
        const dia = (data.getDate() < 10 ? '0' : '') + data.getDate();
        const mes = ((data.getMonth() + 1) < 10 ? '0' : '') + (data.getMonth() + 1);
        const ano = data.getFullYear();
        
        const horas = (data.getHours() < 10 ? '0' : '') + data.getHours();
        const minutos = (data.getMinutes() < 10 ? '0' : '') + data.getMinutes();
        const segundos = (data.getSeconds() < 10 ? '0' : '') + data.getSeconds();
    
        return `${dia}/${mes}/${ano} ${horas}:${minutos}:${segundos}`;
    }

</script>


<script>
    function updateStatus(afiliadoPix, email, valor, external_reference) {
        // Realize uma nova solicitação ao servidor para executar uma atualização no banco de dados
        console.log('update status', email, valor, afiliadoPix, external_reference)
        $.ajax({
            type: "POST",
            url: "atualizar_status.php", // Substitua pelo caminho correto
            data: { pix: afiliadoPix, status: 'Aprovado', email: email, valor: valor, externalreference:external_reference },
            success: function(response) {
                console.log('Status atualizado:', response);
                
            },
            error: function(error) {
                console.error('Erro ao atualizar o status:', error);
                // Adicione lógica para lidar com o erro (exibir mensagem de erro, etc.)
            }
        });
    }
</script>


<script>
    function updateStatusRejeitar(external_reference) {
        // Realize uma nova solicitação ao servidor para executar uma atualização no banco de dados
        console.log('entrou rejeitado',external_reference)
        $.ajax({
            type: "POST",
            url: "atualizar_status_rejeitar.php", // Substitua pelo caminho correto
            data: { status: 'Rejeitado',  externalreference:external_reference },
            success: function(response) {
                console.log('Status atualizado:', response);
                
                
            },
            error: function(error) {
                console.error('Erro ao atualizar o status:', error);
                // Adicione lógica para lidar com o erro (exibir mensagem de erro, etc.)
            }
        });
    }
</script>

<script>
    function extratoSaque(afiliadoPix, email, valor, nome, data, status, external_reference) {
        console.log('extrato saque', afiliadoPix, email, valor, nome, data, status, external_reference)
        $.ajax({
            type: "POST",
            url: "extrato_saque.php", // Substitua pelo caminho correto
            data: { pix: afiliadoPix, status: status, email: email, valor: valor, nome: nome, data: data, status: status, externalreference:external_reference },
            success: function(response) {
                console.log('Extrato gerado com sucesso:', response);
                window.location.reload();
            },
            error: function(error) {
                console.error('Erro ao gerar extrato:', error);
            },
        });
    }
</script>



<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>



    <script>

    </script>


    <script>
      $(document).ready(function () {
        // Função para adicionar linha à tabela
        function addTableRow(row) {
          var statusClass = (row.status === 'Aguardando Aprovação') ? 'text-danger' : 'text-success';
        
          var newRow = `<tr>
            <td>${row.email}</td>
            <td>${row.nome}</td>
            <td>${row.pix}</td>
            <td>${row.valor}</td>
            <td>${row.externalreference}</td>
            <td class='${statusClass}'>${row.status}</td>
            <td>`;
        
          if (row.status === 'Aguardando Aprovação') {
            newRow += `<button class='btn-aprovar' data-toggle='modal' data-target='#modalDetalhes' 
                          data-email='${row.email}' data-nome='${row.nome}' data-pix='${row.pix}' 
                          data-valor='${row.valor}' data-externalreference='${row.externalreference}'>Aprovar</button> `;
        
            
          }
          
          if (row.status === 'Aguardando Aprovação') {
          // Adiciona o botão "Rejeitar"
            newRow += `<button class='btn-rejeitar' data-toggle='modal' data-target='#modalRejeitar' 
                          data-email='${row.email}' data-nome='${row.nome}' data-pix='${row.pix}' 
                          data-valor='${row.valor}' data-externalreference='${row.externalreference}'>Rejeitar</button>`;
          }
          
          newRow += '</td></tr>';
        
          $('#table-body').append(newRow);
        }


        // Use AJAX para buscar dados do arquivo PHP
        $.ajax({
          url: 'bd.php',
          method: 'GET',
          success: function (data) {
            // Limpar o corpo da tabela
            $('#table-body').empty();

            // Inserir dados na tabela
            data.forEach(addTableRow);

            // Adicione um evento de clique para o botão Aprovar
            $(document).on('click', '.btn-aprovar', function () {
              var email = $(this).data('email');
              var nome = $(this).data('nome');
              var pix = $(this).data('pix');
              var valor = $(this).data('valor');
              var externalreference = $(this).data('externalreference');

              // Preencha os detalhes no modal
              $('#detalheEmail').text(email);
              $('#detalheNome').text(nome);
              $('#detalhePix').text(pix);
              $('#detalheValor').text(valor);
              $('#detalheExternalReference').text(externalreference);

              // Exiba o modal
              $('#modalDetalhes').modal('show');
            });
            
            // Adicione um evento de clique para o botão Rejeitar
            $(document).on('click', '.btn-rejeitar', function () {
              var email = $(this).data('email');
              var nome = $(this).data('nome');
              var pix = $(this).data('pix');
              var valor = $(this).data('valor');
              var externalreference = $(this).data('externalreference');

              // Preencha os detalhes no modal
              $('#rejeitarEmail').text(email);
              $('#rejeitarNome').text(nome);
              $('#rejeitarPix').text(pix);
              $('#rejeitarValor').text(valor);
              $('#rejeitarExternalReference').text(externalreference);

              // Exiba o modal
              $('#modalRejeitar').modal('show');
            });


            // Adicione um evento de clique para o botão Confirmar no modal
            $('#btnConfirmar').on('click', function () {
              // Obtenha os detalhes necessários do afiliado (substitua com os seus dados)
              var afiliadoEmail = $('#detalheEmail').text();
              var afiliadoPix = $('#detalhePix').text();
              var afiliadoValor = parseFloat($('#detalheValor').text());

              // Exemplo de envio de solicitação AJAX para o servidor PHP
              $.ajax({
                url: 'bd.php',
                method: 'POST',
                data: {
                  afiliadoEmail: afiliadoEmail,
                  afiliadoPix: afiliadoPix,
                  afiliadoValor: afiliadoValor
                },
                success: function (response) {
                  console.log('Resposta do servidor:', response);
                  // Faça algo com a resposta se necessário
                },
                error: function (error) {
                  console.log('Erro ao enviar solicitação ao servidor PHP.');
                }
              });
                
              // Feche o modal após o envio da solicitação
              $('#modalDetalhes').modal('hide');
            });
            
            
            // Adicione um evento de clique para o botão Confirmar no modal
            $('#btnRejeitar').on('click', function () {
              // Obtenha os detalhes necessários do afiliado (substitua com os seus dados)
              var afiliadoEmail = $('#detalheEmail').text();
              var afiliadoPix = $('#detalhePix').text();
              var afiliadoValor = parseFloat($('#detalheValor').text());

              // Exemplo de envio de solicitação AJAX para o servidor PHP
              $.ajax({
                url: 'bd.php',
                method: 'POST',
                data: {
                  afiliadoEmail: afiliadoEmail,
                  afiliadoPix: afiliadoPix,
                  afiliadoValor: afiliadoValor
                },
                success: function (response) {
                  console.log('Resposta do servidor:', response);
                  // Faça algo com a resposta se necessário
                },
                error: function (error) {
                  console.log('Erro ao enviar solicitação ao servidor PHP.');
                }
              });
                
              // Feche o modal após o envio da solicitação
              $('#modalRejeitar').modal('hide');
            });
            

            // Adicione um evento de clique para o botão Fechar no modal
            $('#btnFechar').on('click', function () {
              // Feche o modal
              $('#modalDetalhes').modal('hide');
            });
            
            // Adicione um evento de clique para o botão Fechar no modal
            $('#btnFechar').on('click', function () {
              // Feche o modal
              $('#modalRejeitar').modal('hide');
            });

            // Inicializar DataTables após a conclusão da chamada AJAX
            // $('#user-table').DataTable({
            //   ordering: false
            // });
          },
          error: function () {
            console.log('Erro ao obter dados do servidor.');
          }
        });
      });
    </script>



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