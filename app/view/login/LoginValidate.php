<?php
// Define $username and $password
session_start();
$truee = 'true';
$falsee = 'false';
$username=$_POST['user'];
$password=$_POST['pass'];
//echo($username);

$myparams['username'] = $username;
$myparams['password'] = $password;


$url = "Login.js";

$serverName = "FENIX\SQLNOTEWINDOWS10";
$connectionInfo = array( "Database" => "TRAKTICKETSYS", "UID"=>"sa", "PWD"=>"1234" );
$connection = sqlsrv_connect($serverName, $connectionInfo);

if( $connection ) {
     echo "Connection established.<br />";
} else{
     echo "Connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true ) );
}

$username = stripslashes($username);
$password = stripslashes($password);


$params = array(
                     array(&$myparams['username'], SQLSRV_PARAM_IN),
                     array(&$myparams['password'], SQLSRV_PARAM_IN)
                   );

$sql = "{call emails.Login(?,?)}";

$stmt = sqlsrv_prepare($connection, $sql, $params);

if( sqlsrv_execute( $stmt ) === false ) {
          die( print_r( sqlsrv_errors(), true));
}

$row = sqlsrv_fetch_array($stmt);
//echo "X";
//echo $row[0];
//echo "X";

if($row  !== NULL && $row != false  ) //not null and not false
{
    echo "====>Error in executing statement 3.\n";

        setcookie('password','true',time()+60*60*24*365, '/');
        setcookie('cookieEmail',$username,time()+60*60*24*365, '/');
        header("Refresh:0");

} else {


echo "Error in executing statement 3.\n";
    die( print_r( sqlsrv_errors(), true));
    setcookie('password','false',time()+60*60*24*365, '/');
    header("Refresh:0");

}


sqlsrv_close($connection); // Closing Connection


?>