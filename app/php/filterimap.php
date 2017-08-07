<?php
$hostname = '{imap.gmail.com:993/imap/ssl}INBOX';

include "config.php";
//include_once("config.php");
//getting id from url

$cookieEmail = $_COOKIE['cookieEmail'];
$myparams['cookieEmail'] = $cookieEmail;

//echo($cookieEmail);

$sql = "SELECT * FROM emails.funcionario WHERE username='$cookieEmail'";

$stmt = sqlsrv_prepare($connection, $sql);
$stmt = sqlsrv_query($connection, $sql);

if( $stmt === false) {
        echo('===> if Erro 1 <===== ');
    die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) )
{
    $iddepartamento = $row['id_departamento_funcionarios'];
}

$quatro = 4;
$myparams['quatro'] = $quatro;
$myparams['iddepartamento'] = $iddepartamento;

$sql2 = "SELECT * FROM emails.funcionario WHERE Tipo_Funcionario=$quatro AND id_departamento_funcionarios=$iddepartamento";

$stmt2 = sqlsrv_prepare($connection, $sql2);
$stmt2 = sqlsrv_query( $connection, $sql2);

while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC) )
{
    $username = $row2['username'];
    $password = $row2['pass'];
}

/* try to connect */
$inbox = imap_open($hostname,$username,$password) or die('Cannot connect to Server: ' . imap_last_error());

/* grab emails */
$emails = imap_search($inbox,'UNSEEN');

/* if emails are returned, cycle through each... */
if($emails) {

  /* begin output var */
  $output = '';

  /* put the newest emails on top */
  rsort($emails);

  /* for every email... */
  foreach($emails as $email_number) {
    $overview = imap_fetch_overview($inbox,$email_number,0);
            $structure = imap_fetchstructure($inbox, $email_number);
            $header = imap_header($inbox, $email_number);
            $frome = $header->from;
            foreach ($frome as $ide => $object) {
                $fromaddress = $object->mailbox . "@" . $object->host;
            }
    if(isset($structure->parts) && is_array($structure->parts) && isset($structure->parts[1])) {
        $part = $structure->parts[0];
        $message = quoted_printable_decode(imap_fetchbody($inbox,$email_number,"1.2"));
        if(empty($message))
        {
          $message = imap_fetchbody($inbox,$email_number,1);
        }
        if($part->encoding == 3) {
            $message = imap_base64($message);
        } else if($part->encoding == 1) {
            $message = imap_8bit($message);
            echo $message;
        } else if($part->encoding == 2) {
            $message = imap_binary($message);
        }
        else if($part->encoding == 4){
          $message = utf8_encode(quoted_printable_decode($message));
        }
        else if($part->encoding == 5)
        {
          $message = $message;
        } else {
            $message = imap_qprint($message);
        }
    }
    $from = quoted_printable_decode(imap_utf8($overview[0]->from));
        $date = utf8_decode(imap_utf8($overview[0]->date));
        $message = nl2br($message);
        $subject = quoted_printable_decode(imap_utf8($overview[0]->subject));
        $message = strip_tags($message);
        $message = html_entity_decode($message);
        $message = htmlspecialchars($message);

            echo $message;

    //$conn= sqlsrv_connect("localhost","root","","emails");

    $myparams['fromaddress'] = $fromaddress;
    $myparams['from'] = $from;
    $myparams['subject'] = $subject;
    $myparams['message'] = $message;
    $myparams['cookieEmail'] = $cookieEmail;

    $params3 = array(
                                     array(&$myparams['fromaddress'], SQLSRV_PARAM_IN),
                                     array(&$myparams['from'], SQLSRV_PARAM_IN),
                                     array(&$myparams['subject'], SQLSRV_PARAM_IN),
                                     array(&$myparams['message'], SQLSRV_PARAM_IN),
                                     array(&$myparams['cookieEmail'], SQLSRV_PARAM_IN)
                                   );

    $sql3 = "{call emails.InserirTickets2(?,?,?,?,? )}";

      $stmt3 = sqlsrv_prepare($connection, $sql3, $params3);
      $stmt3 = sqlsrv_query($connection, $sql3, $params3);




    /*$stmt3 = sqlsrv_prepare($connection, $sql3, $params3);

                if( sqlsrv_execute( $stmt3 ) === false ) {
                    echo('</br> Morreu aqui</br>');

                          die( print_r( sqlsrv_errors(), true));
                }

                $row3 = sqlsrv_fetch_array($stmt3);
	    sqlsrv_close($connection);
    */
  }
}


/* close the connection */
imap_close($inbox);
?>
