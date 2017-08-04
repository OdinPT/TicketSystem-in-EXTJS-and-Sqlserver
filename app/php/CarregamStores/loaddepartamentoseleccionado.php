<?php
//error_reporting(0);
//include("config.php");
include "../config.php";
$id = $_COOKIE['cookieIDdepartamento'];

$return_arr = array();

$myparams['id'] = $id;

$params = array(
    array(&$myparams['id'], SQLSRV_PARAM_IN),
);

$sql = "{call emails.CarregaDepSelec(?)}";

$stmt = sqlsrv_prepare($connection, $sql, $params);

if( sqlsrv_execute( $stmt ) === false ) {
    echo("Morreu");
    die( print_r( sqlsrv_errors(), true));
}


//$result = sqlsrv_query($mysqli, $query);
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_BOTH) ) {

    $row_array['id_departamento'] = $row['id_departamento'];
    $row_array['nome_departamento'] = $row['nome_departamento'];

    array_push($return_arr,$row_array);
}

echo json_encode($return_arr);
sqlsrv_close($connection);

?>
