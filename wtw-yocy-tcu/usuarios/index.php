<?php
session_start();

// Verificar se a sessão existe
if (!isset($_SESSION['emailadm-378287423bkdfjhbb71ihudb'])) {
    // Sessão não existe, redirecionar para outra página
    header("Location: ../login");
    exit();
}

// O restante do código da sua página continua aqui
// ...

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
      <style>
    * {
        transition: all 0.3s ease;
    }
</style>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">




<!-- Adicione essas linhas ao cabeçalho do seu HTML -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>








    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta
      name="keywords"
      content="Admin Dashboard"
    />
    <meta
      name="description"
      content="Admin Dashboard"
    />
    <meta name="robots" content="noindex,nofollow" />
    <title>Admin Dashboard</title>
 
    <link
      rel="icon"
      type="image/png"
      sizes="16x16"
      href="../assets/images/favicon.png"
    />
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
        .topbar .nav-toggler, .topbar .topbartoggler {
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
              <img src="../assets/images/logo-icon.png " alt="homepage" class="light-logo" width="50" style="margin-right: -10px; margin-left: -10px;"/>
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
                data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24" style="color: #333; "></i></a>
            </li>



          </ul>
        </div>
      </nav>
    </header>
        <!-- ==========    MENU    =================== -->
    
    <?php include '../components/aside.php' ?>
   
<div class="page-wrapper">
    
    
    
    
</div> 
<div class="page-wrapper">
  <div class="card">
    <div class="card-body">
     
       <!-- Column -->
        <div class="row" style="justify-content: center;">
            <div class="col-md-12 col-lg-4 col-xlg-3">
                <div class="card card-hover" style="border-radius: 15px;">
                    <div class="box bg-info text-center" style="border-radius: 15px;">
                        <h1 class="font-light text-white" id="valorUsuarios1">0</h1>
                        <h4 class="text-white">Total de cadastros</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4 col-xlg-3">
                <div class="card card-hover" style="border-radius: 15px;">
                    <div class="box bg-info text-center" style="border-radius: 15px;">
                        <h1 class="font-light text-white" id="valorUsuarios2">0</h1>
                        <h4 class="text-white">Últimas 24 Horas</h4>
                    </div>
                </div>
            </div>
        </div>

       <div class="row align-items-center text-center">
    <div class=" mb-3">
        <button class="btn btn-info" style="border-radius: 10px" id="exportCsvBtn">Exportar CSV</button>
    </div>
    <div class=" mb-3">
        <button class="btn btn-info" style="border-radius: 10px" id="modalTotalAff">Total de Depósitos por Afiliado</button>
    </div>
</div>

</div>

<!-- Modal -->
<div class="modal" tabindex="-1" role="dialog" id="inputModal" >
    <div class="modal-dialog" role="document" >
        <div class="modal-content" style="border-radius: 10px;">
            <div class="modal-header">
                <h5 class="modal-title">Digite o Número do Afiliado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control" id="afiliadoInput" placeholder="Número do Afiliado">
                <h5 class="text-danger" id="resultadoDeposito"></h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="consultarBtn" style="border-radius: 5px;">Consultar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 5px;">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Quando o botão for clicado, exibe o modal
    $('#modalTotalAff').on('click', function() {
        $('#inputModal').modal('show');
    });

    // Quando o botão de consultar dentro do modal for clicado
    $('#consultarBtn').on('click', function() {
        // Obtenha o valor do input
        var numeroAfiliado = $('#afiliadoInput').val();

        // Faça a requisição ao arquivo PHP aqui
        $.ajax({
            type: 'POST',
            url: 'total_deposito_por_afiliado.php',
            data: { numeroAfiliado: numeroAfiliado },
            success: function(response) {
                // Processar a resposta do PHP, se necessário
                console.log('Resposta do PHP:', response);
    
                // Exibir o resultado abaixo do input
                $('#resultadoDeposito').text('Total depositado pelo link de afiliado  R$: ' + response);
            },
            error: function(error) {
                console.error('Erro na requisição:', error);
            }
        });

        // Feche o modal
        //$('#inputModal').modal('hide');
    });
</script>

<script>
function escapeCsvValue(value) {
    // Se o valor contiver vírgulas, aspas ou quebras de linha, envolva-o entre aspas
    if (/[",\n\r]/.test(value)) {
        return '"' + value.replace(/"/g, '""') + '"';
    }
    return value;
}

$('#exportCsvBtn').on('click', function () {
    exportTable('user-table', 'user-table.csv', ';', true);
});

$('#exportExcelBtn').on('click', function () {
    exportTable('user-table', 'user-table.xlsx', ',', true);
});

function exportTable(tableId, filename, delimiter, excludeEditColumn) {
    var data = [];
    var headers = [];

    // Adicione os cabeçalhos da tabela
    $('#' + tableId + ' thead th').each(function () {
        // Exclua a coluna de edição se necessário
        if (excludeEditColumn && $(this).text().trim().toLowerCase() === 'editar') {
            return;
        }
        headers.push(escapeCsvValue($(this).text().trim()));
    });
    data.push(headers);

    // Use a API do DataTables para obter todos os dados
    var table = $('#' + tableId).DataTable();
    table.rows().data().each(function (row) {
        var rowData = [];

        row.forEach(function (value, index) {
            // Exclua a coluna de edição se necessário
            if (excludeEditColumn && $('#' + tableId + ' thead th').eq(index).text().trim().toLowerCase() === 'editar') {
                return;
            }
            rowData.push(escapeCsvValue(value));
        });

        data.push(rowData);
    });

    // Crie uma planilha em formato CSV ou Excel, dependendo da extensão do arquivo
    if (filename.endsWith('.csv')) {
        var csvContent = data.map(row => row.join(delimiter)).join('\n');
        var blob = new Blob(["\ufeff" + csvContent], { type: 'text/csv;charset=utf-8;' });
        saveFile(blob, filename);
    } else if (filename.endsWith('.xlsx')) {
        var ws = XLSX.utils.aoa_to_sheet(data);
        var wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
        var blob = XLSX.write(wb, { bookType: 'xlsx', type: 'blob' });
        saveFile(blob, filename);
    }
}

function saveFile(blob, filename) {
    var link = document.createElement('a');
    if (link.download !== undefined) {
        var url = URL.createObjectURL(blob);
        link.setAttribute('href', url);
        link.setAttribute('download', filename);
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
}
</script>


        <div class="row">
      <div class="table-responsive" style="justify-content: center; text-align: center; font-weight: 700;">

  <div class="input-aff" style="height: 90px; width: 300px; box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px; margin: 0 auto; border-radius: 15px; margin-bottom: 25px; margin-top: 25px; padding-top: 15px">
    <h5>Filtrar leads linkados a afiliado</h5>
    <input type="text" style="border-radius: 5px; border: 1px solid #333; padding-left: 5px;" id="leadAffInput" placeholder="Digite o ID do afiliado">
  </div>
  
        
        
        <table id="user-table" style="border: none; box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;" class="table table-striped table-bordered">
          <thead>
            <tr>
            <th>Data/Hora</th>
              <th>Email</th>
              <th>Telefone</th>
              <th>Saldo</th>
           
              <th>Total Depositado</th>
       
              <th>Editar</th>
            </tr>
          </thead>
          <tbody id="table-body">
              
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="border-radius: 10px;">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Editar Usuário</h5>
        <button type="button" style="border-radius: 5px; border: 1px solid #333;" class="btn-close-modal" onclick="fecharModal()" data-dismiss="editModal" aria-label="Close">
          <span aria-hidden="false">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Campos de input para edição -->
        <form id="editForm" action="update.php" method="post">
            <label for="editEmail">Email:</label>
            <input type="text" class="form-control" id="editEmail" name="email" >
    
            <label for="editSenha">Senha:</label>
            <input type="password" class="form-control" id="editSenha" name="senha" >
            <label>Mostrar Senha: </label>
            <input type="checkbox" id="mostrarSenha" onclick="mostrarOcultarSenha()">
            <br/>
            <label for="editTelefone">Telefone:</label>
            <input type="text" class="form-control" id="editTelefone" name="telefone" >
    
            <label for="editSaldo">Saldo:</label>
            <input type="text" class="form-control" id="editSaldo" name="saldo" >
    
            <label for="editLinkAfiliado">Link Afiliado:</label>
            <input type="text" class="form-control" id="editLinkAfiliado" name="linkafiliado" >
    
             <!--<label for="editPlano">Revenue Share (%):</label>-->
             <!--<input type="text" class="form-control" id="editPlano" name="plano" >-->
            
            <!-- <select  name="plano" class="form-select custom-input" aria-label="Escolha a dificuldade">
                <option value="bronze">Bronze</option>
                <option value="ouro">Ouro</option>
                <option value="platina">Platina</option>
            </select>-->
    
             <!--<label for="editBloqueado">Bloqueado:</label>-->
             <!--<input type="checkbox" id="editBloqueado" name="bloqueado" >-->
            
            <br/>
            
             <!--<label for="editSaldoComissao">Saldo Comissao:</label>-->
             <!--<input type="text" class="form-control" id="editSaldoComissao" name="saldo_comissao" >-->
    
            <!-- <label for="editPerdas">Perdas:</label>-->
            <!-- <input type="text" class="form-control" id="editPerdas" name="percas" >-->
    
            <!-- <label for="editGanhos">Ganhos:</label>-->
            <!-- <input type="text" class="form-control" id="editGanhos" name="ganhos" >-->
    
            <!--<label for="editCpa">Cpa:</label>
           <!-- <input type="text" class="form-control" id="editCpa" name="cpa" >-->
    
            <!--<label for="editCpaFake">Chance do Afiliado Receber CPA (%):</label>-->
            <!--<input type="text" class="form-control" id="editCpaFake" name="cpafake" >-->
    
            <!--<label for="editComissaoFake">Porcentagem de Rev. Share Falso (%):</label>-->
            <!--<input type="text" class="form-control" id="editComissaoFake" name="comissaofake" >-->

            <input type="hidden" id="editUserId" name="id">

            <button type="submit" class="btn btn-primary" style="border-radius: 5px;">Salvar Alterações</button>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
<script>
    $(document).ready(function () {
        // Adicione um evento para reagir a mudanças no campo de entrada
        $('#leadAffInput').on('input', function () {
            // Obtenha o valor digitado no campo de entrada
            var leadAffValue = $(this).val();

            // Solicitação AJAX
            $.ajax({
                type: "GET",
                url: "../php/cadastrados_ultimas_24h.php",
                data: { leadAff: leadAffValue },
                success: function (response) {
                    // Atualiza o valor exibido na página
                    $("#valorUsuarios1").text(response.total);
                    $("#valorUsuarios2").text(response.ultimas_24h);
                    console.log(response); // Exibe a resposta do servidor no console
                },
                error: function (error) {
                    console.log("Erro na solicitação AJAX: " + error);
                }
            });
        });

        // Dispare o evento de mudança inicial para carregar os dados com base no valor padrão
        $('#leadAffInput').trigger('input');
    });
</script>

<script>

    function fecharModal() {
        $('#editModal').modal('hide')
    }

    function mostrarOcultarSenha(){
        const senhaInput = document.getElementById('editSenha');

        // Altera o tipo do input de senha para texto ou vice-versa
        senhaInput.type = senhaInput.type === 'password' ? 'text' : 'password';
        senhaInput.type = mostrarSenhaCheckbox.checked ? 'text' : 'password';
    }
    
</script>

<style>
    .btn-edit {
        background-color: #2255a4;
        border-radius: 5px;
        border: none;
        color: #fff;
    }
</style>

<script>
  $(document).ready(function() {
    
    // Use AJAX para buscar dados do arquivo PHP
    $.ajax({
      url: 'bd.php',
      method: 'GET',
      success: function(data) {
        // Limpar o corpo da tabela
        $('#table-body').empty();
        

        // Inserir dados na tabela
        data.forEach(function(row) {
            var newRow = "<tr>" +
            "<td>" + row.data_cadastro + "</td>" +
            "<td>" + row.email + "</td>" +
            "<td>" + row.telefone + "</td>" +
            "<td>" + row.saldo + "</td>" +
         
            "<td>" + row.depositou + "</td>" +
           
            "<td><button class='btn-edit' data-id='" + row.id + "'>Editar</button></td>" +
            "</tr>";
          $('#table-body').append(newRow);
        });
        

        // Inicializar DataTables após a conclusão da chamada AJAX
        var table = $('#user-table').DataTable();
        
        // Adicionar evento de clique para o botão de edição
        $('#user-table tbody').on('click', '.btn-edit', function() {
            
              var userId = $(this).data('id');
              // Preencher os campos do modal com os dados do usuário
              fillEditModal(userId);
              // Abrir o modal
              $('#editModal').modal('show');
        });
        

        function fillEditModal(userId) {
            var user = getUserById(userId); // Implemente a lógica para obter os dados do usuário por ID
            console.log(data)
            // Preencher os campos do modal
            $('#editEmail').val(user.email);
            $('#editSenha').val(user.senha);
            $('#editTelefone').val(user.telefone);
            $('#editSaldo').val(user.saldo);
            $('#editLinkAfiliado').val(user.linkafiliado);
            $('#editPlano').val(user.plano);
            $('#editDepositou').val(user.depositou);
            $('#editBloqueado').prop('checked', user.bloc === 'true');
            $('#editSaldoComissao').val(user.saldo_comissao);
            $('#editPerdas').val(user.percas);
            $('#editGanhos').val(user.ganhos);
            $('#editCpa').val(user.cpa);
            $('#editCpaFake').val(user.cpafake);
            $('#editComissaoFake').val(user.comissaofake);
            $('#editUserId').val(user.id);
        }

        function getUserById(userId) {
            return data.find(function (user) {
                return user.id == userId;
            });
        }
      },
      error: function() {
        console.log('Erro ao obter dados do servidor.');
      }
    });
    // Adicione um identificador ao seu campo de entrada
    var leadAffInput = $('#leadAffInput');

    // Adicione um evento para reagir a mudanças no campo de entrada
    $('#leadAffInput').on('input', function () {
            // Recarregue os dados da tabela com o novo valor de lead_aff
            loadData($(this).val());
        });

        // Função para carregar dados da tabela
        function loadData(leadAff) {
            $.ajax({
                url: 'bd.php',
                method: 'GET',
                data: { leadAff: leadAff },
                success: function (data) {
                    // Limpar o corpo da tabela
                    $('#table-body').empty();

                    // Inserir dados na tabela
                    data.forEach(function (row) {
                        var newRow = "<tr>" +
                            "<td>" + row.data_cadastro + "</td>" +
                            "<td>" + row.email + "</td>" +
                            "<td>" + row.telefone + "</td>" +
                            "<td>" + row.saldo + "</td>" +
                            "<td>" + row.depositou + "</td>" +
                            "<td><button class='btn-edit' data-id='" + row.id + "'>Editar</button></td>" +
                            "</tr>";
                        $('#table-body').append(newRow);
                    });

                    // Inicializar DataTables após a conclusão da chamada AJAX
                    var table = $('#user-table').DataTable();

                    // Adicionar evento de clique para o botão de edição
                    $('#user-table tbody').on('click', '.btn-edit', function () {
                        var userId = $(this).data('id');
                        // Preencher os campos do modal com os dados do usuário
                        fillEditModal(userId);
                        // Abrir o modal
                        $('#editModal').modal('show');
                    });
                },
                error: function () {
                    console.log('Erro ao obter dados do servidor.');
                }
            });
        }

        // Adicione um identificador ao seu campo de entrada
        var leadAffSelect = $('#leadAffSelect');

        // Adicione um evento para reagir a mudanças no campo de entrada
        leadAffSelect.on('change', function() {
            // Obter o valor selecionado
            var leadAffValue = leadAffSelect.val();
        
            // Se o valor selecionado for "Todos", reinicialize a tabela
            if (leadAffValue === "") {
                // Destrua e recrie a tabela
                $('#user-table').DataTable().destroy();
                
                // Recarregue os dados da tabela com o novo valor de lead_aff
                loadData('');
        
                // Inicialize novamente o DataTables
                //$('#user-table').DataTable();
            } else {
                // Se o valor selecionado for diferente de "Todos", proceda normalmente
                $('#user-table').DataTable().destroy();
                loadData(leadAffValue);
            }
        });


        // Chame a função loadData inicialmente para carregar todos os dados
        //loadData('');
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
