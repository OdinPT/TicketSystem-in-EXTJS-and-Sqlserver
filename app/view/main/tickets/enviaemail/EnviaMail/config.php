<?php
error_reporting(0);

$serverName = "PC-SERVER-01";
$connectionInfo = array( "Database" => "TRAKTICKETSYS", "UID"=>"trkguest", "PWD"=>"trkgu3st" );

$connection = sqlsrv_connect($serverName, $connectionInfo);

if( $connection ) {
    //echo "Connection established.<br />";
} else{
    echo "Connection could not be established.<br />";
    die( print_r( sqlsrv_errors(), true ) );
}
?>
