<?php
//error_reporting(0);
//include("config.php");
include "../config.php";
$id = $_COOKIE['cookieIDfuncionario'];
$return_arr = array();

    $sql = "{call emails.CarregaFuncionarios()}";

$stmt = sqlsrv_prepare($connection, $sql);

$stmt = sqlsrv_query( $connection, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {

$row_array['id_funcionario'] = (string)$row['id_funcionario'];
$row_array['usernamefunc'] = $row['username'];
$row_array['nome_departamento'] = $row['nome_departamento'];
$row_array['Descricao_TipoUtilizador'] = $row['Descricao_TipoUtilizador'];

    array_push($return_arr,$row_array);
}

echo json_encode($return_arr);
sqlsrv_close($connection);

?>

