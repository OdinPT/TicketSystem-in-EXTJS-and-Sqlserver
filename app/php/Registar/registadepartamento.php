<?php

include "../config.php";

$nome_departamento4 = $_POST['nome_departamento4'];


$myparams['nome_departamento4'] = $nome_departamento4;

$params = array(
                     array(&$myparams['nome_departamento4'], SQLSRV_PARAM_IN)
                   );

$sql = "{call emails.InserirDepartamento(?)}";
$stmt = sqlsrv_prepare($connection, $sql, $params);

if( sqlsrv_execute( $stmt ) === false ) {
          die( print_r( sqlsrv_errors(), true));
}

$row = sqlsrv_fetch_array($stmt);
sqlsrv_close($connection);

?>

