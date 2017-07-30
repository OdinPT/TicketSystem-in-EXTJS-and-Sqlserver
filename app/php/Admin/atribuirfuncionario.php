<?php
//error_reporting(0);
include("config.php");

$id = $_COOKIE['cookieID'];
$funcionario = $_POST['id_funcionario'];
$email = $_COOKIE['cookieEmail'];

$quatro=4;

$myparams['4'] = $quatro;

$myparams['id'] = $id;
$myparams['id_funcionario'] = $funcionario;
$myparams['email'] = $email;

$params = array(
                     array(&$myparams['email'], SQLSRV_PARAM_IN),
                     array(&$myparams['id_funcionario'], SQLSRV_PARAM_IN),
                     array(&$myparams['id'], SQLSRV_PARAM_IN)
                   );

$sql = "{call emails.InserirHistoricoAtribuicao(?,?,?)}";

$stmt = sqlsrv_prepare($connection, $sql, $params);

if( sqlsrv_execute( $stmt ) === false ) {
    echo("Erro 1");
          die( print_r( sqlsrv_errors(), true));
}

$row = sqlsrv_fetch_array($stmt);
//$state = mysqli_query($mysqli, "call inserirhistoricoestados('$id','4','$funcionario')");

$params2 = array(
    array(&$myparams['id'], SQLSRV_PARAM_IN),
    array(&$myparams['4'], SQLSRV_PARAM_IN),
    array(&$myparams['id_funcionario'], SQLSRV_PARAM_IN)

);

$sql2 = "{call emails.inserirhistoricoestados(?,?,?)}";

$stmt2 = sqlsrv_prepare($connection, $sql2, $params2);

if( sqlsrv_execute( $stmt2 ) === false ) {
    echo("Erro 1");
    die( print_r( sqlsrv_errors(), true));
}

$row = sqlsrv_fetch_array($stmt2);

sqlsrv_close($connection);

?>

