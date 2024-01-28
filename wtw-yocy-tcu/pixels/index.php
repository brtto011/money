<?php
session_start();

if (!isset($_SESSION['emailadm-378287423bkdfjhbb71ihudb'])) {
    header("Location: ../login");
    exit();
}

include './../../conectarbanco.php';
$conn = new mysqli('localhost', $config['db_user'], $config['db_pass'], $config['db_name']);

if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM app LIMIT 1");
$result = $result->fetch_assoc();

$google_ads_tag = $result['google_ads_tag'];
$facebook_ads_tag = $result['facebook_ads_tag'];
$facebook_meta_key = $result['facebook_ads_key'];

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
                                data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"
                                    style="color: #333;"></i></a>
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

            #user-table th,
            #user-table td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }

            #user-table th {
                background-color: #f2f2f2;
            }

            #user-table input[type="text"] {
                width: 80px;
                /* Ajuste conforme necessário */
                padding: 5px;
                margin: 0;
                box-sizing: border-box;
                border: none;
                /* Remover as bordas dos inputs */
                background-color: transparent;
                /* Tornar os inputs transparentes */
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





        <div class="page-wrapper">
            <div class="card">
                <div class="card-body">


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
                            min-width: 320px;
                            height: 250px;
                            width: 320px;
                            background-color: #fff;
                            border-radius: 15px;
                            display: block;
                            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
                            justify-content: center;
                            text-align: center;
                        }


                        .box .box-btn {
                            margin 0 auto;

                        }

                        .title {
                            font-size: 20px;
                            font-weight: bold;
                            color: #343a40;
                        }

                        .description {
                            color: #b6b7bf;
                            font-weight: 500;
                        }

                        .box-input {
                            background: #ffff1;
                            width: 100%;
                            height: 32px;
                            border-radius: 5px;
                            border: 1px solid #dadbe5;
                        }

                        .box-btn {
                            margin-top: 10px;
                            border-radius: 5px;
                            bottom: 0;
                        }
                    </style>
                    <div class="box-container">
                        <div class="box">
                            <form action='update.php?field=google_ads_tag' method='post'>
                                <p class="title">Google ADS TAG:</p>
                                <p class="description">Chave para fazer o trackeamento do seu site utilizando o google
                                    ADS.</p>
                                <input class="box-input" name="value" value="<?php echo $google_ads_tag ?>" />
                                <button type="submit" class="btn box-btn btn-primary">Salvar Alterações</button>
                            </form>
                        </div>
                        <div class="box">
                            <form action='update.php?field=facebook_ads_tag' method='post'>
                                <p class="title">Facebook ADS TAG:</p>
                                <p class="description">Chave para fazer o trackamento do seu site utilizando o facebook
                                    ADS</p>
                                <input class="box-input" name="value" value="<?php echo $facebook_ads_tag ?>" />
                                <button type="submit" class="btn box-btn btn-primary">Salvar Alterações</button>
                            </form>
                        </div>
                        <!-- <div class="box">
                        <form action='update.php?field=facebook_meta_key' method='post'>
                            <p class="title">Facebook Meta Key:</p>
                            <p class="description">Chave para o conteúdo meta disponibilizado na verificação de domínio no facebook ads.</p>
                            <input class="box-input" name="value"value="<?php echo $facebook_meta_key ?>"/>
                            <button type="submit" class="btn box-btn btn-primary">Salvar Alterações</button>
                        </form>
                    </div>-->
                    </div>

                </div>
            </div>
        </div>

        <?php
        // Fechar a conexão com o banco de dados
        $conn->close();
        ?>


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