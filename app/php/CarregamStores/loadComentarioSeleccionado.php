<?php
include "../config.php";

$id = $_COOKIE['cookieIDComent'];

$return_arr = array();
$myparams['id'] = $id;

$params = array(
    array(&$myparams['id'], SQLSRV_PARAM_IN),
);

$sql = "{call emails.RetornaComentarioSelec(?)}";

$stmt = sqlsrv_prepare($connection, $sql, $params);

if( sqlsrv_execute( $stmt ) === false ) {
    echo("Morreu");
    die( print_r( sqlsrv_errors(), true));
}

while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC) ) {

$row_array['ID_Comentario'] = $row['ID_Comentario'];
$row_array['ID_Ticket'] = $row['ID_Ticket'];
$row_array['Data_comentario'] = $row['Data_comentario'];
$row_array['Comentario'] = $row['Comentario'];
$row_array['username'] = $row['username'];

//`ID_Comentario``ID_Ticket``Data_comentario``Comentario``ID_Utilizador`

    array_push($return_arr,$row_array);
}

echo json_encode($return_arr);

?>
