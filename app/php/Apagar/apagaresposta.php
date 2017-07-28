<?php
include("config.php");
$id = $_COOKIE['cookieIDanswer'];
$myparams['id'] = $id;

$params = array(
                     array(&$myparams['id'], SQLSRV_PARAM_IN)
                   );

              $sql = "{call emails.ApagaResposta(?)}";

              $stmt = sqlsrv_prepare($connection, $sql, $params);

              if( sqlsrv_execute( $stmt ) === false ) {
                        die( print_r( sqlsrv_errors(), true));
              }

              $row = sqlsrv_fetch_array($stmt);
              sqlsrv_close($connection);
?>
