<?php
error_reporting(0);
include("config.php");

$id = $_COOKIE['cookieIDrecovered'];
$idticket = $_COOKIE['cookieID'];
$myparams['id'] = $id;
$myparams['idticket'] = $idticket;

$params = array(
                     array(&$myparams['idticket'], SQLSRV_PARAM_IN)
                   );
                   $sql = "{call emails.MudaGrupo(?)}";

                   $stmt = sqlsrv_prepare($connection, $sql, $params);

                   if( sqlsrv_execute( $stmt ) === false ) {
                             die( print_r( sqlsrv_errors(), true));
                   }

                   $row = sqlsrv_fetch_array($stmt);
                   sqlsrv_close($connection);

?>
