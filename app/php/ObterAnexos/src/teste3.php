<?php
$hostname = '{imap.gmail.com:993/imap/ssl}INBOX';
$username = 'testetrackit2@gmail.com';
$password = 'testetrackit123';

$inbox = imap_open($hostname,$username,$password) or die('Cannot connect to server: ' . imap_last_error());

$emails = imap_search($inbox,'ALL');

if($emails) {
    $output = '';
    rsort($emails);

    foreach($emails as $email_number) {
        $overview = imap_fetch_overview($inbox,$email_number,0);
        $structure = imap_fetchstructure($inbox, $email_number);

        if(isset($structure->parts) && is_array($structure->parts) && isset($structure->parts[1])) {
            $part = $structure->parts[1];
            $message = imap_fetchbody($inbox,$email_number,2);
            $message = utf8_encode(quoted_printable_decode($message));
            if($part->encoding == 3) {
                $message = imap_base64($message);
            } else if($part->encoding == 1) {
                $message = imap_8bit($message);
            } else if($part->encoding == 2) {
                $message = imap_binary($message);
            }
            else if($part->encoding == 4){
              $message = quoted_printable_decode($message);
            }
            else if($part->encoding == 5)
            {
              $message = $message;
            } else {
                $message = imap_qprint($message);
            }
        }
        $from = utf8_decode(imap_utf8($overview[0]->from));
        $date = utf8_decode(imap_utf8($overview[0]->date));
        $subject = utf8_decode(imap_utf8($overview[0]->subject));


<<<<<<< HEAD
        $conn= sqlsrv_connect("localhost","root","","emails");
        echo $message;
				//save to MySQL
				sqlsrv_query($conn, "INSERT INTO emails (fromaddress, subject, datea, body) VALUES ('$from', '$subject', '$date', '$message')");

				sqlsrv_close($conn);
=======
        $conn= mysqli_connect("localhost","root","","emails");
        echo $message;
				//save to MySQL
				mysqli_query($conn, "INSERT INTO emails (fromaddress, subject, datea, body) VALUES ('$from', '$subject', '$date', '$message')");

				mysqli_close($conn);
>>>>>>> a24fcc125feea59199f412789f438675a17b8613
    }

    echo $output;
}

imap_close($inbox);
?>
