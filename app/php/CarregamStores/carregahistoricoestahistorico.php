<?php
error_reporting(0);

include "../config.php";
$id = $_COOKIE['cookieIDhistorico'];

$return_arr = array();

$myparams['id'] = $id;

    $params = array(
        array(&$myparams['id'], SQLSRV_PARAM_IN),
    );

$sql = "{call emails.CarregaHistoricoEstado(?)}";

$stmt = sqlsrv_prepare($connection, $sql, $params);

if( sqlsrv_execute( $stmt ) === false ) {
    echo("Morreu");
    die( print_r( sqlsrv_errors(), true));
}

while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC) ) {
    $row_array['idHistoricoEstados'] = (string)$row['idHistoricoEstados'];
    $row_array['HoraAtribuicaoEstado'] = $row['HoraAtribuicaoEstado'];
    $row_array['IdTicketEstado'] = (string)$row['IdTicketEstado'];
    $row_array['Descricao_Estado'] = $row['Descricao_Estado'];
    $row_array['username'] = $row['username'];
    $row_array['DesTipoRes'] = $row['DesTipoRes'];

    array_push($return_arr,$row_array);
}

echo json_encode($return_arr);
sqlsrv_close($connection);

?>

