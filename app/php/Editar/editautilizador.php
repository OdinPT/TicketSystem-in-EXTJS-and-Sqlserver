<?php
include("config.php");
$id = $_COOKIE['cookieIDfuncionario'];

//$myparams[id] = $id;

$username = $_POST['user'];
$password = $_POST['pass'];
$id_departamento = $_POST['id_departamento'];
$tipo_funcionario = $_POST['tipo_funcionario'];

$myparams['id'] = $id;
$myparams['username'] = $username;
$myparams['password'] = $password;
$myparams['id_departamento'] = $id_departamento;
$myparams['tipo_funcionario'] = $tipo_funcionario;

$params = array(

                     array(&$myparams['username'], SQLSRV_PARAM_IN),
                     array(&$myparams['password'], SQLSRV_PARAM_IN),
                     array(&$myparams['id_departamento'], SQLSRV_PARAM_IN),
                     array(&$myparams['tipo_funcionario'], SQLSRV_PARAM_IN),
                     array(&$myparams['id'], SQLSRV_PARAM_IN)
                   );

$sql = "{call emails.AtualizaFuncionario(?,?,?,?,?)}";

$stmt = sqlsrv_prepare($connection, $sql, $params);

if( sqlsrv_execute( $stmt ) === false ) {
          die( print_r( sqlsrv_errors(), true));
}

$row = sqlsrv_fetch_array($stmt);
sqlsrv_close($connection);

?>