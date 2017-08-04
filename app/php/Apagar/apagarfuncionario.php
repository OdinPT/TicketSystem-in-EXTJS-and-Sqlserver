<?php
//include("config.php");
include "../config.php";
$id = $_COOKIE['cookieIDfuncionario'];
$myparams['id'] = $id;

$sql = "DELETE FROM emails.funcionario WHERE id_funcionario=$id";

$stmt = sqlsrv_prepare($connection, $sql);

if( sqlsrv_execute( $stmt ) === false ) {
          die( print_r( sqlsrv_errors(), true));
}

$row = sqlsrv_fetch_array($stmt);
sqlsrv_close($connection);

?>