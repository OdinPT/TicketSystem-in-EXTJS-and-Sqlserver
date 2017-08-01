﻿<?php
//error_reporting(0);

require 'class.smtp.php';
require 'class.phpmailer.php';
require 'config.php';

$assunto = $_POST['assuntoresposta'];
$conteudo = $_POST['conteudoresposta'];

$myparams['assunto'] = $assunto;
$myparams['conteudo'] = $conteudo;

$cookieEmail = $_COOKIE['cookieEmail'];
$id = $_COOKIE['cookieID'];

$myparams['cookieEmail'] = $cookieEmail;
$myparams['id'] = $id;

//$IDFuncEstadox = $_COOKIE['cookieEmail'];

$fileName = $_FILES['anexo']['name'];
$tmpName  = $_FILES['anexo']['tmp_name'];
$fileSize = $_FILES['anexo']['size'];
$fileType = $_FILES['anexo']['type'];

$fp= fopen($tmpName, 'r');
    $content = fread($fp, filesize($tmpName));
    $content = addslashes($content);
  fclose($fp);
    if(!get_magic_quotes_gpc()){
        $fileName = addslashes($fileName);
    }

$sql = "SELECT * FROM emails.funcionario WHERE username='$cookieEmail'";

$stmt = sqlsrv_query( $connection, $sql );

if( $stmt === false) {
    echo ("if 1");
    die( print_r( sqlsrv_errors(), true) );
}
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    $departamento = $row['id_departamento_funcionarios'];
}

$sql2 = "SELECT * FROM emails.funcionario WHERE id_departamento_funcionarios='$departamento' AND Tipo_Funcionario=4";

$stmt2 = sqlsrv_query( $connection, $sql2 );

if( $stmt2 === false) {
    echo ("if 2");
    die( print_r( sqlsrv_errors(), true) );
}


while( $row = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC) ) {
    $username = $row['username'];
    $password = $row['pass'];
}

$PHPMailer = new PHPMailer();

// define que será usado SMTP
$PHPMailer->IsSMTP();

// envia email HTML
$PHPMailer->isHTML( true );

// codificação UTF-8, a codificação mais usada recentemente
$PHPMailer->Charset = 'UTF-8';

// Configurações do SMTP
$PHPMailer->SMTPAuth = true;
$PHPMailer->SMTPSecure = 'TLS';
$PHPMailer->Host = 'smtp.gmail.com';
$PHPMailer->Port = 587;
$PHPMailer->Username = $username;
$PHPMailer->Password = $password;

// E-Mail do remetente (deve ser o mesmo de quem fez a autenticação
// nesse caso seu_login@gmail.com)
$PHPMailer->From = $username;

// Nome do rementente
$PHPMailer->FromName = 'TrackIT';
$conteudo2 = $conteudo;
// assunto da mensagem

$PHPMailer->Subject = $assunto;

$conteudo = str_replace('%conteudo2%', $conteudo2, file_get_contents('action.html'));

// corpo da mensagem
$PHPMailer->Body = $conteudo;

// corpo da mensagem em modo texto
$PHPMailer->AltBody = 'Mensagem em texto';
$cookieID = $_COOKIE['cookieID'];

//selecting data associated with this particular id
//$result = mysqli_query($mysqli, "SELECT * FROM emails WHERE id='$cookieID'") or die(mysqli_error($mysqli));

$sql4 = "SELECT * FROM emails.emails WHERE id='$cookieID'";


$stmt4 = sqlsrv_prepare($connection, $sql4);
$stmt4 = sqlsrv_query($connection, $sql4);

if( $stmt4 === false) {
    echo("erro stmt 4");
    die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt4, SQLSRV_FETCH_ASSOC) ) {
    $fromaddress = $row['email'];
}
echo $fromaddress;

// adiciona destinatário (pode ser chamado inúmeras vezes)
$PHPMailer->AddReplyTo($fromaddress, 'Nome do visitante');
$PHPMailer->AddAddress($fromaddress);
$PHPMailer->addAttachment($tmpName, $fileName);

//sqlsrv_query($mysqli, "call InserirRespostas('$assunto', '$conteudo2','$id')");
$myparams['conteudo'] = $conteudo;

    //sqlsrv_query($mysqli, "call inserirhistoricoestados('$id',2,'$cookieEmail')");

$dois=2;
$myparams['dois'] = $dois;
$myparams['id'] = $id;
$myparams['email'] = $cookieEmail;

$paramx2 = array(
        array(&$myparams['id'], SQLSRV_PARAM_IN),
        array(&$myparams['dois'], SQLSRV_PARAM_IN),
        array(&$myparams['email'], SQLSRV_PARAM_IN)
);

$sqlx2 = "{call emails.inserirhistoricoestados(?,?,?)}";

$stmt23 = sqlsrv_prepare($connection, $sqlx2, $paramx2);
$stmt23 = sqlsrv_query($connection, $sqlx2, $paramx2);

$row = sqlsrv_fetch_array($stmtx2);

// mysqli_query($mysqli, "call InserirRespostas('$assunto', '$conteudo2','$id')");
$myparams['conteudo2'] = $conteudo2;

$paramx3 = array(
    array(&$myparams['assunto'], SQLSRV_PARAM_IN),
    array(&$myparams['conteudo2'], SQLSRV_PARAM_IN),
    array(&$myparams['id'], SQLSRV_PARAM_IN)

);

$sqlx3 = "{call emails.InserirRespostas(?,?,?)}";

$stmtx3 = sqlsrv_prepare($connection, $sqlx3, $paramx3);

if( sqlsrv_execute( $stmtx3 ) === false ) {
    echo("ERro  INSERIR Respostas");
    die( print_r( sqlsrv_errors(), true));
}

$row = sqlsrv_fetch_array($stmtx3);

//mysqli_query($mysqli, "call inserirhistoricoestados('$id',2,'$cookieEmail')");
// verifica se enviou corretamente

if ( $PHPMailer->Send())
{
echo "Enviado com sucesso";
}
else
{
echo 'Erro do PHPMailer: ' . $PHPMailer->ErrorInfo;
}

?>
