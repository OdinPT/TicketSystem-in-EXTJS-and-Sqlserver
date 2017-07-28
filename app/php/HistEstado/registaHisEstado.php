<?php
error_reporting(0);
include("config.php");

$IdTicketEstado = $_COOKIE['cookieID'];
$IdTipoRes = $_POST['IdTipoRes'];
$IDFuncEstadox =  $_COOKIE['cookieEmail'];

$myparams['IdTicketEstado'] = $IDFuncEstadox;
$myparams['IdTipoRes'] = $IDFuncEstadox;
$myparams['IDFuncEstadox'] = $IDFuncEstadox;

$params = array(
                     array(&$myparams['IdTicketEstado'], SQLSRV_PARAM_IN),
                     array(&$myparams['IdTipoRes'], SQLSRV_PARAM_IN),
                     array(&$myparams['IDFuncEstadox'], SQLSRV_PARAM_IN)
                   );

$sql = "{call emails.inserirhistoricoestados2(?,?,?)}";

                   $stmt = sqlsrv_prepare($connection, $sql, $params);

                   if( sqlsrv_execute( $stmt ) === false ) {
                             die( print_r( sqlsrv_errors(), true));
                   }

                   $row = sqlsrv_fetch_array($stmt);
                   sqlsrv_close($connection);

?>

