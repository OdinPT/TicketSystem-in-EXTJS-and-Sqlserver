<?php
include("config.php");
//error_reporting(0);
$id = $_COOKIE['cookieID'];
//echo($id);
$myparams['id'] = $id;

$return_arr = array();

$sql = "SELECT * FROM emails.upload WHERE id_ticket='$id'";

$stmt = sqlsrv_prepare($connection, $sql);


$stmt = sqlsrv_query( $connection, $sql);
if( $stmt === false) {
    //echo("erro1");
die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
$row_array['id'] = (string)$row['id'];
  $row_array['nome'] = $row['nome'];
  $row_array['id_ticket'] = $row['id_ticket'];
  array_push($return_arr,$row_array);
}

echo json_encode($return_arr);
sqlsrv_close($connection);
?>