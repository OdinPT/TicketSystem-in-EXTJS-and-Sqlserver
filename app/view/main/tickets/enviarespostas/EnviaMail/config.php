<?php
error_reporting(0);

$serverName = "FENIX\SQLNOTEWINDOWS10";
$connectionInfo = array( "Database" => "TRAKTICKETSYS", "UID"=>"sa", "PWD"=>"1234" );
$connection = sqlsrv_connect($serverName, $connectionInfo);

if( $connection ) {
    //echo "Connection established.<br />";
} else{
    echo "Connection could not be established.<br />";
    die( print_r( sqlsrv_errors(), true ) );
}
?>
