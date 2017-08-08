<?php
//error_reporting(0);
include("config.php");

$id = $_COOKIE['cookieIDhistorico'];

$return_arr = array();

$myparams['id'] = $id;

$params = array(
    array(&$myparams['id'], SQLSRV_PARAM_IN),
);

$sql = "{call emails.RetornaAtriSelec(?)}";

$stmt = sqlsrv_prepare($connection, $sql, $params);

if( sqlsrv_execute( $stmt ) === false ) {
    echo("Morreu");
    die( print_r( sqlsrv_errors(), true));
}

while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC) ) {
    $row_array['ID_Atribuicao'] = $row['ID_Atribuicao'];
    $row_array['ID_Func_Atribuidor'] = $row['ID_Func_Atribuidor'];
    $row_array['DataAtribuicao'] = $row['DataAtribuicao'];
    $row_array['ID_DepAtribuicao'] = $row['ID_DepAtribuicao'];
    $row_array['ID_Func_Atribuido'] = $row['ID_Func_Atribuido'];
    $row_array['ID_Ticket_atribuicao'] = $row['id'];

    array_push($return_arr,$row_array);
}
echo json_encode($return_arr);

?>
