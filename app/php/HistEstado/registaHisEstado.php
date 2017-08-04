<?php
//error_reporting(0);
include "../config.php";

$IdTicketEstado = $_COOKIE['cookieID'];
$IDFuncEstadox =  $_COOKIE['cookieEmail'];
$IdTipoRes = $_POST['IdTipoRes'];

//echo($IdTicketEstado);
//echo($IDFuncEstadox);


$myparams['IdTicketEstado'] = $IdTicketEstado;
$myparams['IDFuncEstadox'] = $IDFuncEstadox;
$myparams['IdTipoRes'] = $IdTipoRes;

$params = array(
                     array(&$myparams['IdTicketEstado'], SQLSRV_PARAM_IN),//int
                     array(&$myparams['IDFuncEstadox'], SQLSRV_PARAM_IN),//varchar
                     array(&$myparams['IdTipoRes'], SQLSRV_PARAM_IN) //int
                   );
//int varchar int
$sql = "{call emails.inserirhistoricoestados2(?,?,?)}";

                   $stmt = sqlsrv_prepare($connection, $sql, $params);

                   if( sqlsrv_execute( $stmt ) === false ) {
                             die( print_r( sqlsrv_errors(), true));
                   }

                   $row = sqlsrv_fetch_array($stmt);
                   sqlsrv_close($connection);

?>

