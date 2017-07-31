<?php
error_reporting(0);
include("config.php");
$return_arr = array();
//$id = $_COOKIE['cookieIDhistorico'];
$id = $_COOKIE['cookieID'];
$myparams['id'] = $id;
$params = array(
          array(&$myparams['id'], SQLSRV_PARAM_IN));

$sql = "{call emails.VerHistoricoDepartamento(?)}";
$stmt = sqlsrv_prepare($connection, $sql, $params);


$stmt = sqlsrv_query( $connection, $sql, $params );
if( $stmt === false) {
die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {

$row_array['idHistoricoDep'] = $row['idHistoricoDep'];
$row_array['IdTicketDep'] = $row['IdTicketDep'];
$row_array['HoraAtribuicaoDep'] = $row['HoraAtribuicaoDep'];
$row_array['IDDepartamentoDep'] = $row['nome_departamento'];
$row_array['IDFuncEstado'] = $row['username'];

array_push($return_arr,$row_array);
}

echo json_encode($return_arr);

?>
