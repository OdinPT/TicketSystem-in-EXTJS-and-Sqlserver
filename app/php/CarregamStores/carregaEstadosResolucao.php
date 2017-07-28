<?php
error_reporting(0);
include("config.php");

$return_arr = array();

$sql = "{call emails.CarregaTiposResolucao()}";


$stmt = sqlsrv_query( $connection, $sql);
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {

$row_array['IdTipoRes'] = (string)$row['IdTipoRes'];
$row_array['DesTipoRes'] = $row['DesTipoRes'];

    array_push($return_arr,$row_array);
}
echo json_encode($return_arr);
sqlsrv_close($connection);
?>

