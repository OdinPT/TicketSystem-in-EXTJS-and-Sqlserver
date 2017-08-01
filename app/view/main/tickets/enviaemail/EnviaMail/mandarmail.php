<?php
error_reporting(0);
require 'class.smtp.php';
require 'class.phpmailer.php';
require 'config.php';

$cookieEmail = $_COOKIE['cookieEmail'];
$id = $_COOKIE['cookieID'];

$assunto = $_POST['assuntoresposta2'];
$conteudo = $_POST['conteudoresposta2'];

$email = $_POST['email'];

$fileName = $_FILES['anexo2']['name'];
$tmpName  = $_FILES['anexo2']['tmp_name'];
$fileSize = $_FILES['anexo2']['size'];
$fileType = $_FILES['anexo2']['type'];

$fp = fopen($tmpName, 'r');
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

//selecting data associated with this particular id

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
// adiciona destinatário (pode ser chamado inúmeras vezes)

$PHPMailer->AddReplyTo($email, '');
$PHPMailer->AddAddress($email);
$PHPMailer->addAttachment($tmpName, $fileName);

//sqlsrv_query($mysqli, "call InserirRespostas('$assunto', '$conteudo','$id')");
/*
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

//sqlsrv_close($mysqli);
*/

// verifica se enviou corretamente
if ( $PHPMailer->Send() )
{
//echo "Enviado com sucesso";
}
else
{
echo 'Erro do PHPMailer: ' . $PHPMailer->ErrorInfo;
}
?>
