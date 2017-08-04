<?php
//including the database connection file
//include("config.php");
include "../config.php";
//getting id of the data from url
$id = $_COOKIE['cookieIDhistorico'];
$myparams['id'] = $id;

$params = array(
                     array(&$myparams['id'], SQLSRV_PARAM_IN)
                   );
//deleting the row from table
$sql = "{call emails.ApagarEmails(?)}";

$stmt = sqlsrv_prepare($connection, $sql, $params);

if( sqlsrv_execute( $stmt ) === false ) {
          die( print_r( sqlsrv_errors(), true));
}

$row = sqlsrv_fetch_array($stmt);
sqlsrv_close($connection);

//redirecting to the display page (index.php in our case)
?>
