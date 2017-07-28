<?php
//including the database connection file
include("config.php");

$sql = "{TRUNCATE TABLE emails}";

$stmt = sqlsrv_prepare($connection, $sql);


$stmt = sqlsrv_query( $connection, $sql );
if( $stmt === false) {
die( print_r( sqlsrv_errors(), true) );
}
sqlsrv_close($connection);
?>
