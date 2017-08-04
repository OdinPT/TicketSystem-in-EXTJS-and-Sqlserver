<?php
include "../config.php";

error_reporting(0);

$idUtilizador = $_COOKIE['cookieEmail'];
$idComent = $_COOKIE['cookieIDComent'];
$Comentario = $_POST['Comentario'];
$username = $_POST['username'];

$myparams['username'] = $username;
$myparams['idu'] = $idUtilizador;
$myparams['id'] = $idComent;
$myparams['comentario2'] = $Comentario;

$params = array(
            array(&$myparams['comentario2'], SQLSRV_PARAM_IN),
            array(&$myparams['idu'], SQLSRV_PARAM_IN),
            array(&$myparams['id'], SQLSRV_PARAM_IN)
);

$sql = "{call emails.AtualizaComentario(?,?,?)}";


if($username == $idUtilizador)
{
    $stmt = sqlsrv_prepare($connection, $sql, $params);

    if( sqlsrv_execute( $stmt ) === false ) {
        die( print_r( sqlsrv_errors(), true));
    }


    //$insere = mysqli_query($mysqli, "call AtualizaComentario('$Comentario','$idUtilizador',$idComent)");
}
else
{
    header("HTTP/1.0 404 Not Found");
    header('HTTP', true, 500);

}
$row = sqlsrv_fetch_array($stmt);
sqlsrv_close($connection);

?>