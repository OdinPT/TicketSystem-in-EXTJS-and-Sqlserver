<?php
//error_reporting(0);
//include("config.php");
include "../config.php";

$idTicket = $_COOKIE['cookieID'];
$comentario = $_POST['comentario'];
$IDFuncEstadox = $_COOKIE['cookieEmail'];

$myparams['idTicket'] = $idTicket;
$myparams['comentario'] = $comentario;
$myparams['IDFuncEstadox'] = $IDFuncEstadox;


$params = array(
    array(&$myparams['idTicket'], SQLSRV_PARAM_IN),
    array(&$myparams['comentario'], SQLSRV_PARAM_IN),
    array(&$myparams['IDFuncEstadox'], SQLSRV_PARAM_IN)
);

$sql = "{call emails.InserirComentario(?,?,?)}";
$stmt = sqlsrv_prepare($connection, $sql, $params);

if( sqlsrv_execute( $stmt ) === false ) {
    die( print_r( sqlsrv_errors(), true));
}

$row = sqlsrv_fetch_array($stmt);
sqlsrv_close($connection);




//$insere = mysqli_query($mysqli, " call InserirComentario('$idTicket','$comentario','$IDFuncEstadox')");
//mysqli_close($mysqli);

?>