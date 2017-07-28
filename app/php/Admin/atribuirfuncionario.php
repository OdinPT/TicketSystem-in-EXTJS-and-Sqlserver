<?php
//error_reporting(0);

include("config.php");
$id = $_COOKIE['cookieID'];
$funcionario = $_POST['id_funcionario'];

//$funcionario = 41;
//$id = 4;

$id = stripslashes($id);
$funcionario = stripslashes($funcionario);

echo($id);
echo($funcionario);

$myparams['id'] = $id;
$myparams['id_funcionario'] = $funcionario;

$params = array(
                     array(&$myparams['id_funcionario'], SQLSRV_PARAM_IN),
                        array(&$myparams['id'], SQLSRV_PARAM_IN)
                   );

$sql = "{call emails.teste(?,?)}";

$stmt = sqlsrv_prepare($connection, $sql, $params);

if( sqlsrv_execute( $stmt ) === false ) {
    echo("Erro 1");
          die( print_r( sqlsrv_errors(), true));
}


$row = sqlsrv_fetch_array($stmt);
sqlsrv_close($connection);

?>

