<?php
//error_reporting(0);
//include("config.php");
include "../config.php";
$return_arr = array();

$id = $_COOKIE['cookieIDhistorico'];

$myparams['id'] = $id;

$params = array(
    array(&$myparams['id'], SQLSRV_PARAM_IN)
);

$sql = "{Call emails.VerHistoricoDepartamento(?)}";

$stmt = sqlsrv_prepare($connection, $sql, $params);

if( sqlsrv_execute( $stmt ) === false ) {
    echo "ERRO2";
    die( print_r( sqlsrv_errors(), true));
}
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){

    $row_array['idHistoricoDep'] = (string) $row['idHistoricoDep'];
    $row_array['IdTicketDep'] =(string) $row['IdTicketDep'];
    $row_array['HoraAtribuicaoDep'] = $row['HoraAtribuicaoDep'];
    $row_array['nome_departamento'] = $row['nome_departamento'];
    $row_array['username'] = $row['username'];

    array_push($return_arr,$row_array);
}
echo json_encode($return_arr);
sqlsrv_close($connection);

?>
