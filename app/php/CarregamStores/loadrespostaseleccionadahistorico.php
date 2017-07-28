<?php
include("config.php");
//error_reporting('0');

$id = $_COOKIE['cookieIDhistorico'];

$return_arr = array();

$myparams['id'] = $id;

$params = array(
    array(&$myparams['id'], SQLSRV_PARAM_IN),
);

$sql = "{call emails.CarregaRespostaSelecionada(?)}";

$stmt = sqlsrv_prepare($connection, $sql, $params);

if( sqlsrv_execute( $stmt ) === false ) {
    echo "ERRO2";
    die( print_r( sqlsrv_errors(), true));
}

//$query = "call CarregaRespostaSelecionada($id)";

//$result = sqlsrv_query($mysqli, $query);
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){

    $row_array['id_resp'] =(string) $row['id_resp'];
    $row_array['subject_resp'] = $row['subject_resp'];
    $row_array['body_resp'] = $row['body_resp'];
    $row_array['datea_resp'] = $row['datea_resp'];
    $row_array['id_email'] = $row['id_email'];


    array_push($return_arr,$row_array);
}

echo json_encode($return_arr);
sqlsrv_close($connection);
?>
