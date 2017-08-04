<?php
//error_reporting(0);
//include("config.php");
include "../config.php";

$id = $_COOKIE['cookieIDhistorico'];
echo $id;
$return_arr = array();

$myparams['id'] = $id;

//echo ($id);
  $params = array(
    array(&$myparams['id'], SQLSRV_PARAM_IN),
  );

$sql = "{Call emails.TicketSelecHistorico(?)}";

$stmt = sqlsrv_prepare($connection, $sql, $params);

if( sqlsrv_execute( $stmt ) === false ) {
    echo "ERRO2";
    die( print_r( sqlsrv_errors(), true));
}

while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){

    $row_array['id'] = $row['id'];
    $row_array['fromaddress'] = $row['fromaddress'];
    $row_array['subject'] = $row['subject'];
    $row_array['datea'] = $row['datea'];
    $row_array['body'] = $row['body'];
    $row_array['state'] =(string) $row['state'];
    $row_array['nome_departamento'] = $row['nome_departamento'];

    array_push($return_arr,$row_array);
}

echo json_encode($return_arr);
sqlsrv_close($connection);

?>
