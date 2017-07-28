<?php
//error_reporting(0);
include("config.php");

$return_arr = array();

$sql = "{call emails.CarregaDepartamentos()}";

$stmt = sqlsrv_prepare($connection, $sql);

$stmt = sqlsrv_query( $connection, $sql );

if( $stmt === false) {
die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
$row_array['id_departamento'] = (string)$row['id_departamento'];

$row_array['nome_departamento'] = $row['nome_departamento'];

    array_push($return_arr,$row_array);
}

echo json_encode($return_arr);
sqlsrv_close($connection);

?>