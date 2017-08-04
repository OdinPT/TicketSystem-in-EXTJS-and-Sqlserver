<?php
//including the database connection file
//include("config.php");
include "../config.php";
$cookieEmail = $_COOKIE['cookieEmail'];
$myparams['username'] = $cookieEmail;

$sql = "SELECT * FROM emails.funcionario WHERE username='$cookieEmail'";

$stmt = sqlsrv_query( $connection, $sql);
if( $stmt === false) {
    echo("Err if");
die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {

$username = $row['username'];
$password = $row['pass'];
}

//getting id of the data from url

$id = $_COOKIE['cookieID'];
$myparams['id'] = $id;

$params = array(
                     array(&$myparams['id'], SQLSRV_PARAM_IN)
                   );

$sql2 = "{call emails.MudaGrupo(?)}";

$stmt = sqlsrv_prepare($connection, $sql2, $params);

if( sqlsrv_execute( $stmt ) === false ) {
        echo("Morreu segundo if");
          die( print_r( sqlsrv_errors(), true));
}

$row = sqlsrv_fetch_array($stmt);
sqlsrv_close($connection);

// $kappa = sqlsrv_query($mysqli, "Call ApagarEmails($ide)");

?>