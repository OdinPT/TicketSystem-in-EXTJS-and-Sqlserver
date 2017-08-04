<?php
error_reporting(0);
//include("config.php");
include "../config.php";
$return_arr = array();

$sql = "{call emails.CarregaEstados()}";

$stmt = sqlsrv_prepare($connection, $sql);


$stmt = sqlsrv_query( $connection, $sql );
if( $stmt === false) {
die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
$row_array['ID_Estado'] = (string)$row['ID_Estado'];
$row_array['Descricao_Estado'] = $row['Descricao_Estado'];

    array_push($return_arr,$row_array);
}

echo json_encode($return_arr);
sqlsrv_close($connection);

?>
