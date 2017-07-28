<?php
error_reporting(0);
//Chama as definições patrão da BD utilizada.
include("config.php");
$id = $_COOKIE['cookieIDhistorico'];
$myparams['id'] = $id;

$params = array(
                     array(&$myparams['id'], SQLSRV_PARAM_IN)
                   );

$sql = "{call emails.MudaEstado(?)}";

                   $stmt = sqlsrv_prepare($connection, $sql, $params);

                   if( sqlsrv_execute( $stmt ) === false ) {
                             die( print_r( sqlsrv_errors(), true));
                   }

                   $row = sqlsrv_fetch_array($stmt);
$um = 1;
$myparams['um'] = $um;


                   $sql2 = "UPDATE emails.emails SET id_grupo_emails='$um' WHERE id='$id'";

                                      $stmt2 = sqlsrv_prepare($connection, $sql2);

                                      if( sqlsrv_execute($stmt2) === false ) {
                                                die( print_r( sqlsrv_errors(), true));
                                      }

                                      $row = sqlsrv_fetch_array($stmt2);
                                      sqlsrv_close($connection);

?>
