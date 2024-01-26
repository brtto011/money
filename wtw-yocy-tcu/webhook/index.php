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
include '../../conectarbanco.php';

$conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}


$sql = "SELECT url_cadastro, url_gerado, url_pago FROM app LIMIT 1";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $urlCadastro = $row['url_cadastro'];
    $urlGerado = $row['url_gerado'];
    $urlPago = $row['url_pago'];
} else {

    $urlCadastro = "URL não cadastrada";
    $urlGerado = "URL não cadastrada";
    $urlPago = "URL não cadastrada";
}

$conn->close();

?>


<?php
include './bd.php'; ?>

<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <style>
        input[type="text"] {
            width: 656px;
        }
    </style>
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
                            <img src="../assets/images/logo-text.png" width="150" height="50" alt="homepage"
                                class="light-logo" />
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
                <div class="card-body"">
          <h5 class=" card-title">Configurações de integracao com SMS FUNNEL</h5>
                </div>
                <h2 style="margin-left: 25px;">Recebimento WEBHOOK com SMS FUNNEL</h1>



                    <?php
                    include './../conectarbanco.php';

                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        if (isset($_POST['url_cadastro'], $_POST['url_gerado'], $_POST['url_pago'])) {
                            $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);

                            if ($conn->connect_error) {
                                die("Conexão falhou: " . $conn->connect_error);
                            }

                            $urlCadastro = $_POST['url_cadastro'];
                            $urlPixGerado = $_POST['url_gerado'];
                            $urlPixPago = $_POST['url_pago'];

                            if (empty($urlCadastro) || empty($urlPixGerado) || empty($urlPixPago)) {
                                echo "Todos os campos devem ser preenchidos.";
                            } else {
                                $sql = "UPDATE app SET url_cadastro = ?, url_gerado = ?, url_pago = ?";
                                $stmt = $conn->prepare($sql);

                                if (!$stmt) {
                                    die("Erro na preparação da consulta: " . $conn->error);
                                }

                                $stmt->bind_param("sss", $urlCadastro, $urlPixGerado, $urlPixPago);
                                $result = $stmt->execute();

                                if ($result) {
                                    echo "Dados atualizados com sucesso!";
                                } else {
                                    echo "Erro ao atualizar os dados. Tente novamente.";
                                }

                                $stmt->close();
                            }



                            $conn->close();
                        } else {
                            echo "Erro: Dados não recebidos corretamente.";
                        }
                    }
                    ?>






                    <form id="notificacao-form">
                        <div class="card">
                            <div class="card-body">






                                <div class="form-group row">
                                    <label class="col-md-3" for="disabledTextInput">URL DE CADASTRO </label>
                                    <div class="col-md-9">
                                        <input type="text" id="disabledTextInput" class="form-control"
                                            placeholder="<?php echo $urlCadastro ?>" disabled />
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-md-3">Inserir nova URL de cadastro : </label>
                                    <div class="col-md-9">
                                        <input type="text" id="urlCadastro" class="form-control"
                                            placeholder="Insira sua URL da Lista de Cadastro" />
                                    </div>
                                </div>
                                <br>
                                <br>
                                <div class="form-group row">
                                    <label class="col-md-3" for="disabledTextInput">URL DE PIX GERADO </label>
                                    <div class="col-md-9">
                                        <input type="text" id="disabledTextInput" class="form-control"
                                            placeholder="<?php echo $urlGerado ?>" disabled />
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-md-3">Inserir nova URL de pix gerado : </label>
                                    <div class="col-md-9">
                                        <input type="text" id="urlPixGerado" class="form-control"
                                            placeholder="Insira sua URL da Lista de Pix Gerado" />
                                    </div>
                                </div>

                                <br>
                                <br>
                                <div class="form-group row">
                                    <label class="col-md-3" for="disabledTextInput">URL DE PIX PAGO </label>
                                    <div class="col-md-9">
                                        <input type="text" id="disabledTextInput" class="form-control"
                                            placeholder="<?php echo $urlPago; ?>" disabled />
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-md-3">Inserir nova URL de pix pago : </label>
                                    <div class="col-md-9">
                                        <input type="text" id="urlPixPago" class="form-control"
                                            placeholder="Insira sua URL da Lista de Pix Pago" />
                                    </div>
                                </div>





                            <button style="margin-top: 35px;" type="button" class="btn btn-primary"
                                onclick="salvarAlteracoes()">Salvar Alterações</button>

</div>

                            <script>
                                function salvarAlteracoes() {

                                    var urlCadastro = document.getElementById('urlCadastro').value;
                                    var urlPixGerado = document.getElementById('urlPixGerado').value;
                                    var urlPixPago = document.getElementById('urlPixPago').value;


                                    if (urlCadastro === '' || urlPixGerado === '' || urlPixPago === '') {
                                        alert("Todos os campos devem ser preenchidos.");
                                        return;
                                    }


                                    var formData = new FormData();
                                    formData.append('url_cadastro', urlCadastro);
                                    formData.append('url_gerado', urlPixGerado);
                                    formData.append('url_pago', urlPixPago);

                                    fetch('index.php', {
                                        method: 'POST',
                                        body: formData
                                    })
                                        .then(response => {
                                            if (!response.ok) {
                                                throw new Error(`Erro na requisição: ${response.statusText}`);
                                            }
                                            return response.json();
                                        })
                                        .then(data => {
                                            alert("Dados atualizados com sucesso! Atualize a página para visualizar!")
                                        })
                                        .catch(error => {

                                            alert("Dados atualizados com sucesso! Atualize a página para visualizar!");
                                        });

                                }
                            </script>

                        </div>
            </div>

            </form>












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