<?php
//error_reporting(0);
include("config.php");

$return_arr = array();
$cookieEmail = $_COOKIE['cookieEmail'];
//$cookieEmail = "callcenter";


$sql = "SELECT id_departamento_funcionarios FROM emails.funcionario WHERE username='$cookieEmail'";
$stmt = sqlsrv_query($connection, $sql);
if( $stmt === false ) {
    echo "ERRO";
    die( print_r( sqlsrv_errors(), true));
}
$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

$iddepartamento = $row['id_departamento_funcionarios'];
$myparams['iddepartamento'] = $iddepartamento;

$params = array(
    array(&$myparams['iddepartamento'], SQLSRV_PARAM_IN),
);

$sql = "{call emails.VerTicket(?)}";

$stmt = sqlsrv_prepare($connection, $sql, $params);

if( sqlsrv_execute( $stmt ) === false ) {
    echo "ERRO2";
    die( print_r( sqlsrv_errors(), true));
}

while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

    $row_array['id'] =(string) $row['id'];
    $row_array['fromaddress'] = $row['fromaddress'];
    $row_array['subject'] = $row['subject'];
    $row_array['datea'] = $row['datea'];
    $row_array['body'] = $row['body'];
    $row_array['Descricao_Estado'] = $row['Descricao_Estado'];
    $row_array['DesTipoRes'] = $row['DesTipoRes'];
    $row_array['id_func_emails'] = $row['id_func_emails'];
    $row_array['nome_departamento'] = $row['nome_departamento'];

    array_push($return_arr,$row_array);
}

echo json_encode($return_arr);
sqlsrv_close($connection);
?>
