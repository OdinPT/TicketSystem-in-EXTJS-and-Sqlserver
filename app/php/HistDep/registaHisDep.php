<?php
error_reporting(0);
include("config.php");

$IdTicketEstado = $_COOKIE['cookieID'];
$IDEDep = $_POST['id_departamento'];
$IDFuncEstado =  $_COOKIE['cookieEmail'];

$myparams['IdTicketEstado'] = $IdTicketEstado;
$myparams['IDEDep'] = $IDEDep;
$myparams['IDFuncEstado'] = $IDFuncEstado;

$params = array(
                     array(&$myparams['IdTicketEstado'], SQLSRV_PARAM_IN),
                     array(&$myparams['IDEDep'], SQLSRV_PARAM_IN),
                     array(&$myparams['IDFuncEstado'], SQLSRV_PARAM_IN)
                   );

$sql = "{call emails.InserirHistoricoDepartamentos(?,?,?)}";

$stmt = sqlsrv_prepare($connection, $sql, $params);

if( sqlsrv_execute( $stmt ) === false ) {
          die( print_r( sqlsrv_errors(), true));
}

$row = sqlsrv_fetch_array($stmt);
sqlsrv_close($connection);

?>

