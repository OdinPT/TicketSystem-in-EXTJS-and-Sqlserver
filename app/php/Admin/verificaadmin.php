<?php
//error_reporting(0);
//include_once("config.php");
include "../config.php";

//getting id from url
$email = $_COOKIE['cookieEmail'];
$myparams['username'] = $email;

$params = array(
                                 array(&$myparams['username'], SQLSRV_PARAM_IN)
                               );
$sql = "{call emails.VerificaAdmin(?)}";

$stmt = sqlsrv_query( $connection, $sql, $params );
if( $stmt === false) {
die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
$tipo = $row['Tipo_Funcionario'];
}

if($tipo == 3)
{
    echo "Sucesso";
}
else
{
    header("HTTP/1.0 404 Not Found");
    header('HTTP', true, 500);
}
?>