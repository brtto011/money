<?php
session_start();

$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

// Conectar ao banco de dados
include './../conectarbanco.php';
$conn = new mysqli('localhost', $config['db_user'], $config['db_pass'], $config['db_name']);

// Verificar a conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $chavePix = $_POST["chavePix"];
    $tipoChave = $_POST["tipoChave"];

    // Definindo o typeKey com base no valor recebido do campo tipoChave
    $typeKey = ($tipoChave == "phoneNumber") ? "phoneNumber" : "document";
    
    // Corrija sua consulta SQL para selecionar as informações do banco de dados
    $sql = "SELECT * FROM appconfig WHERE (cpf >= 1 OR telefone >= 1) AND email = '$email'";
    $result = $conn->query($sql);

    $sql2 = "SELECT * FROM appconfig WHERE (cpf = '$chavePix' OR telefone = '$chavePix')";
    $result2 = $conn->query($sql2);

    $columnName = ($tipoChave == "phoneNumber") ? "telefone" : "CPF";

    if ($result->num_rows <= 0 || $result->num_rows === null) {
        if ($result2->num_rows <= 0) {
            // Se não há registros correspondentes, faça o update e envie o pagamento
            $updateQuery = "UPDATE appconfig SET $columnName = '$chavePix' WHERE email = '$email'";
            if ($conn->query($updateQuery) === TRUE) {
                // Coloque aqui o redirecionamento apropriado

    $curl = curl_init();

    $data = array(
        "value" => 0.05,
        "key" => $chavePix,
        "typeKey" => $typeKey // Altera dinamicamente com base no valor recebido do campo tipoChave
    );

    $jsonData = json_encode($data);

 // Substitua com a variável adequada que contém o email
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://ws.suitpay.app/api/v1/gateway/pix-payment',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $jsonData,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'ci: joaovecmm_1703093538802',
            'cs: 38ab97fef9ae972290df7dda9430f29ede955f9a0c49412fa3eaf9b0ae89a45af75793a309be42428e7b24ca69b6d642'
        ),
    ));

    $response = curl_exec($curl);
    
if ($response) {
    $data = json_decode($response, true);
    if (isset($data['response']) && $data['response'] === 'PIX_KEY_NOT_FOUND') {
        // A chave PIX não foi encontrada
        curl_close($curl);
        header("Location: https://subwaybrasil.bet/erro-chave-nao-encontrada");
        exit();
    }
}
// Se algo estiver errado ou a chave for encontrada, faça o redirecionamento apropriado
curl_close($curl);
        header("Location: https://subwaybrasil.bet/chave-pix-cadastrada/");
        exit();

            } else {
                header("Location: https://subwaybrasil.bet/erro-chave-cadastrada/");
                exit();
            }
        } else {
            header("Location: https://subwaybrasil.bet/erro-chave-cadastrada/");
            exit();
        }
    } else {
        header("Location: https://subwaybrasil.bet/erro-chave-cadastrada/");
        exit();
    }
}
?>


<!DOCTYPE html>

<html lang="pt-BR">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link data-optimized="1" rel="stylesheet" href="assets/css/5921624bf5bbe4c8c091ef09226fa76f.css">
        <link rel="preconnect" href="https://fonts.googleapis.com/">
        <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
        <link data-optimized="1" href="assets/css/1c7a3d2ee9759dc256d915300855c494.css" rel="stylesheet">
        <link data-optimized="1" href="assets/css/ba9cbbe9240a489628be8eb27c56db8a.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/animated.css">
        <title>Saque via PIX - Subway Brasil</title>
    </head>

    <body>

        <div class="menu">
            <a><img style="width: 160px;" src="assets/images/logosb.webp"></a>
        </div>

        <div style="margin-bottom: 100px;"></div>


        <div id="p1" style="display: block;">
            <div class="slogan-inicio">
                <div>
                    <p style="color: white; font-weight: bold; font-size: 20px; padding-top: 15px; text-align: center;">Cadastre agora sua chave PIX</p>
                </div>
            </div>

            <div style="margin-bottom: 20px;"></div>

            <div class="white-box">
                <label style="background-color: #e2e8ef; padding: 10px; border-radius: 12px; text-align: center; width: 100%; margin-bottom: 10px; line-height: 1.3rem; font-size: 18px;">Antes de realizar seu 1º saque <br /><b>CADASTRE SUA CHAVE PIX.</b><br /><br />Vamos te enviar um <b>PIX TESTE</b> para confirmar se está tudo certo com sua Chave PIX.</label>
                <label style="text-align: center; width: 100%;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="20" height="20" style="display: inline-flex;   vertical-align: text-bottom;" fill= "#36C5B8" transition= "fill .3s">
                        <path d="M242.4 292.5C247.8 287.1 257.1 287.1 262.5 292.5L339.5 369.5C353.7 383.7 372.6 391.5 392.6 391.5H407.7L310.6 488.6C280.3 518.1 231.1 518.1 200.8 488.6L103.3 391.2H112.6C132.6 391.2 151.5 383.4 165.7 369.2L242.4 292.5zM262.5 218.9C256.1 224.4 247.9 224.5 242.4 218.9L165.7 142.2C151.5 127.1 132.6 120.2 112.6 120.2H103.3L200.7 22.76C231.1-7.586 280.3-7.586 310.6 22.76L407.8 119.9H392.6C372.6 119.9 353.7 127.7 339.5 141.9L262.5 218.9zM112.6 142.7C126.4 142.7 139.1 148.3 149.7 158.1L226.4 234.8C233.6 241.1 243 245.6 252.5 245.6C261.9 245.6 271.3 241.1 278.5 234.8L355.5 157.8C365.3 148.1 378.8 142.5 392.6 142.5H430.3L488.6 200.8C518.9 231.1 518.9 280.3 488.6 310.6L430.3 368.9H392.6C378.8 368.9 365.3 363.3 355.5 353.5L278.5 276.5C264.6 262.6 240.3 262.6 226.4 276.6L149.7 353.2C139.1 363 126.4 368.6 112.6 368.6H80.78L22.76 310.6C-7.586 280.3-7.586 231.1 22.76 200.8L80.78 142.7H112.6z"></path>
                    </svg>
                    <h2 style="margin-top: 1rem; font-size: 16px; display: inline-flex; color: #7A7A7A;">Selecione sua chave pix</h2>
                </label>
<style>
.container {
    max-width: 600px;
    margin: 0 auto;
}

.slogan-inicio {
    background-color: #e6632c;
}

.row {
    display: flex;
    justify-content: center;
    margin-top: 0px;
}

.radio-label {
    display: flex;
    align-items: center;
    margin: 0 10px;
    cursor: pointer;
}

.radio-label input[type="radio"] {
    display: none;
}

.icon-box {
    display: flex;
    align-items: center;
    margin-left: 5px;
}

.icon-box i {
    margin-right: 5px;
}

/* Estilos de exemplo para os ícones */
.fa {
    font-size: 24px;
}

.valor-disabled {
    display: none;
}

.enviarCodigo {
    display: none;
}

/* Media queries para tornar o layout responsivo */
@media screen and (max-width: 768px) {
    .row {
        flex-wrap: wrap;
    }
    .radio-label {
        margin: 0px;
    }
}

.row label input[type="radio"]:checked~.icon-box, .row label input[type="checkbox"]:checked~.icon-box {
      background: linear-gradient(138deg, #e6632c, #c7473a) !important;
    color: #fff;
    font-weight: bold;
}

.enviarCodigo {
    background: linear-gradient(180deg, #22892b, #145f0f);
}
</style>

<div class="container">
    <form method="post">
    <div class="row">
        <label class="radio-label">
            <input type="radio" class="tipoChave" id="tipoChave1" name="tipoChave" value="phoneNumber"/>
            <div class="icon-box">
                <i class="fa fa-phone" aria-hidden="true"></i>
                <span>Celular</span>
            </div>
        </label>
        <label class="radio-label">
            <input type="radio" class="tipoChave" id="tipoChave2" name="tipoChave" value="document"/>
            <div class="icon-box">
                <i class="fa fa-id-card" aria-hidden="true"></i>
                <span>CPF/CNPJ</span>
            </div>
        </label>
    </div>
</div>

                        <input type="hidden" name="utm" value="">
                        <input type="hidden" name="valida" value="ok">
                        <input style="color: #000000; width: 100%; margin-top: 10px; border-radius: 35px;" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');" type="text" name="chavePix" id="chavePix" inputmode="numeric" autocomplete="off" required placeholder="Inserir chave pix" class="login-form valor-disabled">  

                        <button style="margin-top: 20px; margin-bottom: 20px; font-size: 20px;" id="submit" type="submit" class="enviarCodigo">REALIZAR SAQUE</button>
                    </form>
                </div>
            </div>
        </div>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>

        <script>
            var message="";
            function clickIE() {
                if (document.all) {(message);return false;}
            }
            function clickNS(e) {
                if(document.layers||(document.getElementById&&!document.all)) {
                    if (e.which==2||e.which==3) {(message);return false;}
                }
            }
            if (document.layers){
                document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;
            }
            else{
                document.onmouseup=clickNS;document.oncontextmenu=clickIE;
            }
            document.oncontextmenu=new Function("return false")


            //  F12
            //==========

            document.onkeypress = function (event) {
                if (e.ctrlKey && (e.keyCode === 123)) {
                    // alert('not allowed');
                    return false;
                }
            };


            //    CTRL + u
            //==============

            document.onkeydown = function(e) {
                if (e.ctrlKey && (e.keyCode === 85)) {
                    // alert('not allowed');
                    return false;
                }
            };  
        </script>

<script>
    jQuery(function($){
        $('.tipoChave').change(function(){
            var campo = $(this).val();
            if (campo == "document"){	
                $('.valor-disabled').css('display', 'block');
                $('.enviarCodigo').css('display', 'block');
                $('.valor-disabled').prop( "disabled", false );
                $(".valor-disabled").attr('placeholder', 'Chave PIX de CPF');
                $("#chavePix").val('');
                $("#chavePix").mask("999.999.999-99");
            }
            else if (campo == "phoneNumber"){
                $('.valor-disabled').css('display', 'block');
                $('.enviarCodigo').css('display', 'block');
                $('.valor-disabled').prop( "disabled", false );
                $(".valor-disabled").attr('placeholder', 'Chave PIX de Celular');
                $("#chavePix").val('');
                $("#chavePix").mask("(99)99999-9999");
            }			
        });

        function codeAddress() {
            $('.valor-disabled').prop( "disabled", true );
        }
        window.onload = codeAddress;
    });
</script>

    </body>



    <footer>
        <p style="color: #ffffff; text-align: center; font-size: 12px; margin-top: 10px;">©️ 2023 Todos os direitos reservados.</p>
    </footer>

</html>