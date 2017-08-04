<?php
//error_reporting(0);
//include("config.php");
include "../config.php";
$funcionario = $_COOKIE['cookieEmail'];

$return_arr = array();

$sql = "SELECT * FROM emails.funcionario WHERE username='$funcionario'";

$stmt = sqlsrv_query($connection, $sql);

    if( $stmt === false ) {
            echo "ERRO";
            die( print_r( sqlsrv_errors(), true));
        }

$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

$iddepartamento = $row['id_departamento_funcionarios'];

        $myparams['iddepartamento'] = $iddepartamento;

        $tipo = $row['id_departamento_funcionarios'];

            $params = array(
                    array(&$myparams['iddepartamento'], SQLSRV_PARAM_IN),
            );

    $sql = "{call emails.VerTicket(?)}";

$stmt = sqlsrv_prepare($connection, $sql, $params);

if( sqlsrv_execute( $stmt ) === false ) {
    echo "ERRO2";
    die( print_r( sqlsrv_errors(), true));
}

while($resi = mysqli_fetch_array($vedepfunc))
{
	$tipo = $resi['id_departamento_funcionarios'];
}

    $myparams['tipo'] = $tipo;

    $params3 = array(
        array(&$myparams['tipo'], SQLSRV_PARAM_IN),
    );

    $query3 = "{call emails.VerDepFunc(?)}";

$stmt3 = sqlsrv_prepare($connection, $query3, $params3);

if( sqlsrv_execute( $stmt3 ) === false ) {
    echo "ERRO";
    die( print_r( sqlsrv_errors(), true));
}

while ($row = sqlsrv_fetch_array($stmt3, SQLSRV_FETCH_ASSOC)) {

$row_array['id_funcionario'] = (string)$row['id_funcionario'];
$row_array['usernamefunc'] = $row['username'];

    array_push($return_arr,$row_array);
}

echo json_encode($return_arr);
sqlsrv_close($connection);

?>