<?php
//include_once 'config.php';
include "../config.php";
error_reporting(0);
$id = $_COOKIE['cookieIDanexo'];

$sql = "SELECT * FROM emails.upload WHERE id='$id'";


$stmt = sqlsrv_query( $connection, $sql);
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}
$folder = "downloads";
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    $filename = "./" . $folder . "/" . $row['nome'];

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
    header('Content-Length: ' . filesize($filename));
    readfile($filename);
}
flush();
?>