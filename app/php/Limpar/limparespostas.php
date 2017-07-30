<?php
/*include("config.php");
$id = $_COOKIE['cookieID'];

$myparams['id'] = $id;


$params = array(
    array(&$myparams['id'], SQLSRV_PARAM_IN)

);

$sql = "{call emails.inserirhistoricoestados2(?,?,?)}";

$stmt = sqlsrv_prepare($connection, $sql, $params);

if( sqlsrv_execute( $stmt ) === false ) {
    die( print_r( sqlsrv_errors(), true));
}

$row = sqlsrv_fetch_array($stmt);
sqlsrv_close($connection);











$sql = "{TRUNCATE TABLE respostas}";

$stmt = sqlsrv_prepare($connection, $sql);


$stmt = sqlsrv_query( $connection, $sql );
if( $stmt === false) {
die( print_r( sqlsrv_errors(), true) );
}
sqlsrv_close($connection);*/
?>
