<?php
//error_reporting(0);
include("config.php");
$id = $_COOKIE['cookieIDhistorico'];
//echo $id;
$myparams['id'] = $id;
$params = array(
                                 array(&$myparams['id'], SQLSRV_PARAM_IN)
                               );
$return_arr = array();
$sql = "{call emails.CarregaGridDepartamentoHistorico(?)}";
$stmt = sqlsrv_prepare($connection, $sql, $params);


$stmt = sqlsrv_query( $connection, $sql, $params );
if( $stmt === false) {
die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
$row_array['idHistoricoDep'] = $row['idHistoricoDep'];
$row_array['IdTicketDep'] = $row['IdTicketDep'];
$row_array['HoraAtribuicaoDep'] = $row['HoraAtribuicaoDep'];
$row_array['Descricao_Estado'] = $row['IDDepartamentoDep'];
$row_array['username'] = $row['IDFuncEstado'];

array_push($return_arr,$row_array);
}

echo json_encode($return_arr);

?>
