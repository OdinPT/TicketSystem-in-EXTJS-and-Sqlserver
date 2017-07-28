<?php
//error_reporting(0);
include("config.php");
//getting id from url

$id = $_COOKIE['cookieID'];
$IDFuncEstadox = $_COOKIE['cookieEmail'];

/*
echo('id: ');
echo($id);
echo('</br>');
echo($IDFuncEstadox);
echo('</br>');
*/

$dois = 2;
$myparams['id'] = $id;
$myparams['id_funcionario'] = $IDFuncEstadox;
$myparams['dois'] = $dois;

$sql = "SELECT * FROM emails.emails WHERE id='$id'";

//    $stmt2 = sqlsrv_prepare($connection, $sql);
    //$stmt2 = sqlsrv_execute( $connection, $sql);

$stm2t = sqlsrv_prepare($connection, $sql);
$stmt2 = sqlsrv_query($connection, $sql);

if( $stmt2 === false) {
    echo(Erro1);
    die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC) ) {
    $state = $row['state'];
}
        if($state == 3)
        {
            $params = array(
                                 array(&$myparams['id'], SQLSRV_PARAM_IN),
                                 array(&$myparams['dois'], SQLSRV_PARAM_IN),
                                 array(&$myparams['id_funcionario'], SQLSRV_PARAM_IN)
                               );
            $sql2 = "{call emails.inserirhistoricoestados(?,?,?)}";
            $stmt = sqlsrv_prepare($connection, $sql2, $params);

            if( sqlsrv_execute( $stmt ) === false ) {
                      die( print_r( sqlsrv_errors(), true));
            }
            $row = sqlsrv_fetch_array($stmt);

        }
        else
        {

        }

        sqlsrv_close($connection);

?>