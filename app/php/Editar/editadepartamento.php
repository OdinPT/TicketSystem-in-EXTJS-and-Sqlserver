<?php
//include("config.php");
include "../config.php";
$id = $_COOKIE['cookieIDdepartamento'];
$myparams['id'] = $id;

$id_departamento2 = $_POST['id_departamento2'];
$nome_departamento2 = $_POST['nome_departamento2'];

$myparams['id_departamento2'] = $id_departamento2;
$myparams['nome_departamento2'] = $nome_departamento2;

if($id_departamento2 == "")
{
    $id_departamento2 = $id;
    $myparams['id_departamento2'] = $id;
}
$params = array(
                     array(&$myparams['nome_departamento2'], SQLSRV_PARAM_IN),
                     array(&$myparams['id'], SQLSRV_PARAM_IN)
                   );
                   $sql = "{call emails.AtualizaDepartamento(?,?)}";

                   $stmt = sqlsrv_prepare($connection, $sql, $params);

                   if( sqlsrv_execute( $stmt ) === false ) {
                             die( print_r( sqlsrv_errors(), true));
                   }

                   $row = sqlsrv_fetch_array($stmt);
                   sqlsrv_close($connection);

?>