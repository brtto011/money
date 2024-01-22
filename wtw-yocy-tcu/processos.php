<?php
try{
session_start();

if (!isset($_SESSION['emailadm-378287423bkdfjhbb71ihudb'])) {
    header("Location: ../login");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}

include './../conectarbanco.php';

$conn = new mysqli('localhost', $config['db_user'], $config['db_pass'], $config['db_name']);

function required($value, $field)
{
    if ($value === "" || $value === null) {
        return "$field é requerido";
    }

    return null;
}

function validate_form($form, $fields)
{
    foreach ($fields as $field) {
        if (!isset($form[$field])) {
            return "$field não encontrado no formulário";
        }

        $value = $form[$field];
        $error = required($value, $field);

        if ($error) {
            return $error;
        }
    }

    return null;
}


function get_form()
{
    return array(
        'valor' => $_POST['valor'],
    );
}


if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

$form = get_form();
$error = validate_form($form, ['valor']);
$valor = $form['valor'];

if (isset($_GET['opcao'])) {
    $opcao = $_GET['opcao'];
}

$sql = "SELECT * FROM app";
$result = $conn->query($sql);
/*$result = $result2->fetch_assoc();*/


if ($error) {
    $msg = $error;
    var_dump($msg);
    var_dump($form);
}else{
    switch($opcao){
        case "depositoMin":
                if ($result->num_rows > 0) {
                    $sql_update = "UPDATE app SET deposito_min = '$valor'";
                    $result_update = $conn->query($sql_update);
                    
                    if ($result_update === TRUE) {
                        header("Location: index.php");
                        exit();
                    } else {
                        header("Location: index.php");
                        exit();
                    }
                } else {
                    $sql_insert = "INSERT INTO app SET deposito_min = '$valor'";
                    $result_insert = $conn->query($sql_insert);
                    
                    if ($result_insert === TRUE) {
                        header("Location: index.php");
                        exit();
                    } else {
                        header("Location: index.php");
                        exit();
                    }
                }
                
                $conn->close();
        case "saqueMin":
            if ($result->num_rows > 0) {
                    $sql_update = "UPDATE app SET saques_min = '$valor'";
                    $result_update = $conn->query($sql_update);
                    
                    if ($result_update === TRUE) {
                        header("Location: index.php");
                        exit();
                    } else {
                        header("Location: index.php");
                        exit();
                    }
                } else {
                    $sql_insert = "INSERT INTO app SET saques_min = '$valor'";
                    $result_insert = $conn->query($sql_insert);
                    
                    if ($result_insert === TRUE) {
                        header("Location: index.php");
                        exit();
                    } else {
                        header("Location: index.php");
                        exit();
                    }
                }
                
                $conn->close();
        case "apostaMax":
            if ($result->num_rows > 0) {
                    $sql_update = "UPDATE app SET aposta_max = '$valor'";
                    $result_update = $conn->query($sql_update);
                    
                    if ($result_update === TRUE) {
                        header("Location: index.php");
                        exit();
                    } else {
                        header("Location: index.php");
                        exit();
                    }
                } else {
                    $sql_insert = "INSERT INTO app SET aposta_max = '$valor'";
                    $result_insert = $conn->query($sql_insert);
                    
                    if ($result_insert === TRUE) {
                        header("Location: index.php");
                        exit();
                    } else {
                        header("Location: index.php");
                        exit();
                    }
                }
                
                $conn->close();
        case "apostaMin":
            if ($result->num_rows > 0) {
                    $sql_update = "UPDATE app SET aposta_min = '$valor'";
                    $result_update = $conn->query($sql_update);
                    
                    if ($result_update === TRUE) {
                        header("Location: index.php");
                        exit();
                    } else {
                        header("Location: index.phpm");
                        exit();
                    }
                } else {
                    $sql_insert = "INSERT INTO app SET aposta_min = '$valor'";
                    $result_insert = $conn->query($sql_insert);
                    
                    if ($result_insert === TRUE) {
                        header("Location: index.php");
                        exit();
                    } else {
                        header("Location: index.php");
                        exit();
                    }
                }
                
                $conn->close();
                
        case "rolloverSaque":
            // Use declarações preparadas para evitar problemas de segurança
            $stmt = $conn->prepare("SELECT * FROM app");
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $stmt_update = $conn->prepare("UPDATE app SET rollover_saque = ?");
                $stmt_update->bind_param("d", $valor); // 'd' para double/float
                $stmt_update->execute();

                if ($stmt_update->affected_rows > 0) {
                    header("Location: index.php");
                    exit();
                }
            } else {
                $stmt_insert = $conn->prepare("INSERT INTO app (rollover_saque) VALUES (?)");
                $stmt_insert->bind_param("d", $valor); // 'd' para double/float
                $stmt_insert->execute();

                if ($stmt_insert->affected_rows > 0) {
                    header("Location: index.php");
                    exit();
                }
            }

            // Feche as declarações preparadas
            $stmt->close();
            $stmt_update->close();
            $stmt_insert->close();

            break;
            
        case "taxaSaque":
            if ($result->num_rows > 0) {
                    $sql_update = "UPDATE app SET taxa_saque = '$valor'";
                    $result_update = $conn->query($sql_update);
                    
                    if ($result_update === TRUE) {
                        header("Location: index.php");
                        exit();
                    } else {
                        header("Location: index.php");
                        exit();
                    }
                } else {
                    $sql_insert = "INSERT INTO app SET taxa_saque = '$valor'";
                    $result_insert = $conn->query($sql_insert);
                    
                    if ($result_insert === TRUE) {
                        header("Location: index.php");
                        exit();
                    } else {
                        header("Location: index.php");
                        exit();
                    }
                }
                
                $conn->close();
        case "dificuldadeJogo":
            if ($result->num_rows > 0) {
                    $sql_update = "UPDATE app SET dificuldade_jogo = '$valor'";
                    $result_update = $conn->query($sql_update);
                    
                    if ($result_update === TRUE) {
                        header("Location: index.php");
                        exit();
                    } else {
                        header("Location: index.php");
                        exit();
                    }
                } else {
                    $sql_insert = "INSERT INTO app SET dificuldade_jogo = '$valor'";
                    $result_insert = $conn->query($sql_insert);
                    
                    if ($result_insert === TRUE) {
                        header("Location: index.php");
                        exit();
                    } else {
                        header("Location: index.php");
                        exit();
                    }
                }
                
                $conn->close();
        default:
            echo "entrei default";
            break;
    }

}
}catch(Exception $ex){
        var_dump($ex);
        exit;
    }
?>