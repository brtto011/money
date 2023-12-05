<!DOCTYPE html>
<html dir="ltr" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


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
  
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div
      id="main-wrapper"
      data-layout="vertical"
      data-navbarbg="skin5"
      data-sidebartype="full"
      data-sidebar-position="absolute"
      data-header-position="absolute"
      data-boxed-layout="full"
    >
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
                <img
                  src="../assets/images/logo-icon.png "
                  alt="homepage"
                  class="light-logo"
                  width="25"
                />
              </b>
              <!--End Logo icon -->
              <!-- Logo text -->
              <span class="logo-text ms-2">
                <!-- dark Logo text -->
                <img
                  src="../assets/images/logo-text.png"
                  width="150" height="50"
                  alt="homepage"
                  class="light-logo"
                />
              </span>
           
            </a>
        
            <a
              class="nav-toggler waves-effect waves-light d-block d-md-none"
              href="javascript:void(0)"
              ><i class="ti-menu ti-close"></i
            ></a>
          </div>

          <div
            class="navbar-collapse collapse"
            id="navbarSupportedContent"
            data-navbarbg="skin5">
   
            <ul class="navbar-nav float-start me-auto">
              <li class="nav-item d-none d-lg-block">
                <a
                  class="nav-link sidebartoggler waves-effect waves-light"
                  href="javascript:void(0)"
                  data-sidebartype="mini-sidebar"
                  ><i class="mdi mdi-menu font-24"></i
                ></a>
              </li>
            
         
            
            </ul>
          </div>
        </nav>
      </header>
       <!-- ==========    MENU    =================== -->
    <?php include '../components/aside.php' ?>
      
      
      
      
      
      <style>
  /* Estilos da tabela */
  #user-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
  }

  #user-table th, #user-table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
  }

  #user-table th {
    background-color: #f2f2f2;
  }

  #user-table input[type="text"] {
    width: 80px; /* Ajuste conforme necessário */
    padding: 5px;
    margin: 0;
    box-sizing: border-box;
    border: none; /* Remover as bordas dos inputs */
    background-color: transparent; /* Tornar os inputs transparentes */
  }
  /* Estilos do botão */
  .btn-success {
    background-color: #28a745;
    color: #fff;
    border: none;
    padding: 10px 15px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 4px;
  }
</style>






<?php
// Configurações do banco de dados
$dbname = "u574069177_frutinhamoney";
$dbuser = "u574069177_tki3";
$dbpass = "Severino@123";

// Conectar ao banco de dados
$conn = new mysqli('localhost', $dbuser, $dbpass, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Atualizar os dados no banco de dados se o formulário for enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Certifique-se de validar e filtrar os dados do formulário para evitar SQL injection

    // Os arrays $_POST['cpa'], $_POST['rev'], $_POST['indicacao'] conterão os novos valores
    $cpa = $_POST['cpa'];
    $rev = $_POST['rev'];
    $indicacao = $_POST['indicacao'];
    $valor_saque_maximo = $_POST['valor_saque_maximo'];
    $saque_diario = $_POST['saque_diario'];


    // Loop através dos arrays e atualizar os valores no banco de dados
    for ($i = 0; $i < count($cpa); $i++) {
        $nome = $_POST['nome'][$i]; // Se necessário, adicione um campo de input hidden para o nome na tabela

        // Use declarações preparadas para evitar SQL injection
        $stmt = $conn->prepare("UPDATE planos SET cpa = ?, rev = ?, indicacao = ?, valor_saque_maximo = ?, saque_diario = ? WHERE nome = ?");
        $stmt->bind_param("ssssss", $cpa[$i], $rev[$i], $indicacao[$i],$valor_saque_maximo[$i],$saque_diario[$i], $nome);
        $stmt->execute();
    }

    // Redirecionar ou exibir uma mensagem de sucesso
    // header('Location: sua_pagina_de_sucesso.php');
    // exit();
}

// Consulta SQL para obter dados da tabela
$sql = "SELECT nome, cpa, rev, indicacao, valor_saque_maximo, saque_diario FROM planos";
$result = $conn->query($sql);

// Verificar se a consulta foi bem-sucedida
if (!$result) {
    die("Erro na consulta: " . $conn->error);
}
?>

<div class="page-wrapper">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Planos</h5>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="table-responsive">
          <table id="user-table" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Nome</th>
                <th>CPA Afiliado</th>
                <th>REV Afiliado</th>
                <th>Comissão por indicação</th>
                <th>Maximo Por Saque</th>
                <th>Saque diários</th>
              </tr>
            </thead>
            <tbody id="table-body">
              <?php
                // Extrair dados da consulta e gerar as linhas da tabela com inputs para edição
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>" .
                        "<td>" . $row['nome'] . "<input type='hidden' name='nome[]' value='" . $row['nome'] . "'></td>" .
                        "<td><input type='text' name='cpa[]' value='" . $row['cpa'] . "'></td>" .
                        "<td><input type='text' name='rev[]' value='" . $row['rev'] . "'></td>" .
                        "<td><input type='text' name='indicacao[]' value='" . $row['indicacao'] . "'></td>" .
                        "<td><input type='text' name='valor_saque_maximo[]' value='" . $row['valor_saque_maximo'] . "'></td>" .
                        "<td><input type='text' name='saque_diario[]' value='" . $row['saque_diario'] . "'></td>" .
                        "</tr>";
                }
              ?>
            </tbody>
          </table>
        </div>
        <button type="submit" class="btn btn-success">Salvar Alterações</button>
        <style>
            .box-container {
                display: flex;
                flex-direction: row;
                flex-wrap: wrap;
                width: 100%;
                justify-content: space-around;
            }
        
            .box {
                border: 1px solid white;
                padding: 20px;
                margin: 20px 0;
                min-width: 360px;
                width: 360px;
                background-color: #1f262d;
                border-radius: 15px;
                display: block;
            }
            .title {
                font-size: 20px;
                font-weight: bold;
                color: white;
            }
            .description {
                color: #b6b7bf;
                font-weight: 500;
            }
            
            .box-input {
                background: #b6b7bf;
                width: 100%;
                height: 32px;
                border-radius: 5px;
                border: 1px solid #dadbe5;
            }
            
            .box-btn {
                margin-top: 10px;
                border-radius: 5px;
            }
            
        </style>
        <div class="box-container">
            <div class="box">
                <form>
                    <p class="title">CPA Lvl 1 (RS):</p> 
                    <p class="description">Ganho em RS pelo primeiro depósito do indicado, feito ao afiliado Lvl 1.</p>
                    <input class="box-input" name="cpa" value="20"/>
                    <button type="submit" class="btn box-btn btn-primary">Salvar Alterações</button>
                </form>
            </div>
            <div class="box">
                <form>
                    <p class="title">Chance do afiliado ganhar CPA (%):</p> 
                    <p class="description">Quantos porcentos dos afiliados irá contar com CPA (aumentar lucros do site).</p>
                    <input class="box-input" name="cpa" value="20"/>
                    <button type="submit" class="btn box-btn btn-primary">Salvar Alterações</button>
                </form>
            </div>
            <div class="box">
                <form>
                    <p class="title">Depósito Mínimo Para Afiliado Ganhar CPA:</p> 
                    <p class="description">Valor de depósito mínimo que os convidados do afiliado devem fazer para gerar receita de CPA.</p>
                    <input class="box-input" name="cpa" value="20"/>
                    <button type="submit" class="btn box-btn btn-primary">Salvar Alterações</button>
                </form>
            </div>
            <div class="box">
                <form>
                    <p class="title">Porcentagem de Rev. Share Falso (%):</p> 
                    <p class="description">Valor a mais de revenue share que irá aparecer aos usuários (aumentar lucros do site).</p>
                    <input class="box-input" name="cpa" value="20"/>
                    <button type="submit" class="btn box-btn btn-primary">Salvar Alterações</button>
                </form>
            </div>
            <div class="box">
                <form>
                    <p class="title">Revenue Share LvL 1 (%):</p> 
                    <p class="description">Procentagem dad aos afiliados por cada perca real dos indicados Lvl 1.</p>
                    <input class="box-input" name="cpa" value="20"/>
                    <button type="submit" class="btn box-btn btn-primary">Salvar Alterações</button>
                </form>
            </div>
        </div>
      </form>
    </div>
  </div>
</div>

<?php
// Fechar a conexão com o banco de dados
$conn->close();
?>


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>







      
        <footer class="footer text-center">
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
