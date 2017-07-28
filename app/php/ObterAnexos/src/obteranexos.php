<?php
include_once 'config.php';
$id = $_COOKIE['cookieIDanexo'];

$sql = "SELECT * FROM emails.upload WHERE id=$id";

$stmt = sqlsrv_prepare($connection, $sql);


$stmt = sqlsrv_query( $connection, $sql);
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    $filename = $row['nome'];
    $X = $row['content'];
}
$type = ".pdf";
header('Content-Description:File Transfer');
header("Content-type: ".type);
header('Content-Disposition: attachment; filename="' . $filename . '"');
ob_clean();
flush();
echo $X;

?>