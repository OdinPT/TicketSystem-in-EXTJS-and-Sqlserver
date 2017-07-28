<?php
include("config.php");

$id_departamento4 = $_POST['id_departamento4'];
$nome_departamento4 = $_POST['nome_departamento4'];

$myparams['id_departamento4'] = $id_departamento4;
$myparams['nome_departamento4'] = $nome_departamento4;

$params = array(
                     array(&$myparams['id_departamento4'], SQLSRV_PARAM_IN),
                     array(&$myparams['nome_departamento4'], SQLSRV_PARAM_IN)
                   );
//$insere = sqlsrv_query($mysqli, "call InserirDepartamento('$id_departamento4','$nome_departamento4')");

$sql = "{call emails.InserirDepartamento(?,?)}";
$stmt = sqlsrv_prepare($connection, $sql, $params);

if( sqlsrv_execute( $stmt ) === false ) {
          die( print_r( sqlsrv_errors(), true));
}

$row = sqlsrv_fetch_array($stmt);
sqlsrv_close($connection);

?>

