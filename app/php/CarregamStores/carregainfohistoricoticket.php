<?php
//error_reporting(0);
//include("config.php");
include "../config.php";
$id = $_COOKIE['cookieIDhistorico'];

//$id=14;
//echo $id;

$return_arr = array();

$myparams['id'] = $id;
$params = array(
    array(&$myparams['id'], SQLSRV_PARAM_IN)
);

$sql = "{Call emails.ShowBody(?)}";

$stmt = sqlsrv_prepare($connection, $sql, $params);

if( sqlsrv_execute( $stmt ) === false ) {
    echo "ERRO2";
    die( print_r( sqlsrv_errors(), true));
}

//$result = sqlsrv_query($mysqli, $query);

while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){

    $row_array['id'] = $row['id'];
    $row_array['email'] = $row['email'];
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
