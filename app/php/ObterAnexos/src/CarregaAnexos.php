<?php
//error_reporting(0);
include("config.php");
$return_arr = array();
$id = $_COOKIE['cookieID'];
set_time_limit(3000);

function mssql_escape($data) {
    if(is_numeric($data))
        return $data;
    $unpacked = unpack('H*hex', $data);
    return '0x'.$unpacked['hex'];
}

/* connect to gmail with your credentials */
$hostname = '{imap.gmail.com:993/imap/ssl}INBOX';
$cookieEmail = $_COOKIE['cookieEmail'];

$myparams['cookieEmail'] = $cookieEmail;

$sql = "SELECT * FROM emails.funcionario WHERE username='$cookieEmail'";

//$stmt = sqlsrv_prepare($connection, $sql);


$stmt = sqlsrv_query( $connection, $sql);
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    $iddepartamento = $row['id_departamento_funcionarios'];
}

$myparams['iddepartamento'] = $iddepartamento;

$quatro = 4;
$myparams['quatro'] = $quatro;

$sql2 = "SELECT * FROM emails.funcionario WHERE Tipo_Funcionario='$quatro' AND id_departamento_funcionarios='$iddepartamento'";
//$stmt2 = sqlsrv_prepare($connection, $sql2);


$stmt2 = sqlsrv_query( $connection, $sql2);
if( $stmt2 === false) {
    die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC) ) {
    $username = $row['username'];
    $password = $row['pass'];

}

$myparams['id'] = $id;
$sql3 = "SELECT * FROM emails.emails WHERE id='$id'";
//$stmt3 = sqlsrv_prepare($connection, $sql3);

$stmt3 = sqlsrv_query( $connection, $sql3);
if( $stmt3 === false) {
    die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt3, SQLSRV_FETCH_ASSOC) ) {
    $subject = $row['subject'];
}

/* try to connect */
$inbox = imap_open($hostname,$username,$password) or die('Cannot connect to Server: ' . imap_last_error());

$emails = imap_search($inbox, 'SUBJECT '.$subject.'');
/* if any emails found, iterate through each email */

if($emails) {

    $count = 1;

    /* put the newest emails on top */
    rsort($emails);

    /* for every email... */
    foreach($emails as $email_number)
    {

        /* get information specific to this email */
        $overview = imap_fetch_overview($inbox,$email_number,0);

        $message = imap_fetchbody($inbox,$email_number,2);

        /* get mail structure */
        $structure = imap_fetchstructure($inbox, $email_number);

        $attachments = array();

        /* if any attachments found... */
        if(isset($structure->parts) && count($structure->parts))
        {
            for($i = 0; $i < count($structure->parts); $i++)
            {
                $attachments[$i] = array(
                    'is_attachment' => false,
                    'filename' => '',
                    'name' => '',
                    'attachment' => ''
                );

                if($structure->parts[$i]->ifdparameters)
                {
                    foreach($structure->parts[$i]->dparameters as $object)
                    {
                        if(strtolower($object->attribute) == 'filename')
                        {
                            $attachments[$i]['is_attachment'] = true;
                            $attachments[$i]['filename'] = $object->value;
                        }
                    }
                }

                if($structure->parts[$i]->ifparameters)
                {
                    foreach($structure->parts[$i]->parameters as $object)
                    {
                        if(strtolower($object->attribute) == 'name')
                        {
                            $attachments[$i]['is_attachment'] = true;
                            $attachments[$i]['name'] = $object->value;
                        }
                    }
                }

                if($attachments[$i]['is_attachment'])
                {
                    $attachments[$i]['attachment'] = imap_fetchbody($inbox, $email_number, $i+1);

                    /* 3 = BASE64 encoding */
                    if($structure->parts[$i]->encoding == 3)
                    {
                        $attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
                    }
                    /* 4 = QUOTED-PRINTABLE encoding */
                    elseif($structure->parts[$i]->encoding == 4)
                    {
                        $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
                    }
                }
            }
        }

        /* iterate through each attachment and save it */
        foreach($attachments as $attachment) {
            if ($attachment['is_attachment'] == 1) {
                $filename = $attachment['name'];
                if (empty($filename)) $filename = $attachment['filename'];

                if (empty($filename)) $filename = time() . ".dat";
                $folder = "";
                if (!is_dir($folder)) {
                    mkdir($folder);
                }
                $fp = fopen("./" . $folder . "/" . $filename, "w+");
                fwrite($fp, $attachment['attachment']);
                fclose($fp);
                $fp = fopen($filename, 'r');
                $data = fread($fp, filesize($filename));
                $data = addslashes($data);
                fclose($fp);
                $filename = quoted_printable_decode(imap_utf8($filename));



                $myparams['data'] = mssql_escape($data);
                //$myparams['data'] = $data;
                $myparams['filename'] = $filename;
                $myparams['id'] = $id;
                echo "Chegou aqui";
                //echo $filename;
                if ($quatro == 4) {
                    $myparams['data']= array($data, SQLSRV_PARAM_IN,
                        SQLSRV_PHPTYPE_STREAM(SQLSRV_ENC_BINARY), SQLSRV_SQLTYPE_VARBINARY('max'));
                }

                $sql = "INSERT INTO emails.upload ([content],[nome],[id_ticket]) SELECT CONVERT(VARBINARY(MAX),?),?,?";

                $parametri = array(
                    array(&$myparams['data'], SQLSRV_PARAM_IN),
                    array(&$myparams['filename'], SQLSRV_PARAM_IN),
                    array(&$myparams['id'], SQLSRV_PARAM_IN)
                );

                //$sql = "INSERT INTO emails.upload(nome, content, id_ticket) VALUES ('$filename','.mssql_escape($data).','$id')";

                $r_blob = sqlsrv_query($connection, $sql, $parametri);
                echo "depois do query";
                if ($r_blob === false) {
                    die(print_r(sqlsrv_errors(), true));
                }
            }
        }
    }
}

sqlsrv_close($connection);
imap_close($inbox);
?>