<?php
include("config.php");

$id = $_COOKIE['cookieID'];
$IDFuncEstadox = $_COOKIE['cookieEmail'];

$myparams['id'] = $id;
$myparams['IDFuncEstadox'] = $IDFuncEstadox;

/*echo("id: ");
echo $id;
echo("</br>");
echo("Estado: ");
echo $state;
echo("</br>");
echo $IDFuncEstadox;
echo("</br>");
echo("Funcionario atribuido: ");
echo $func;
echo("</br>");
*/

$sql = "SELECT * FROM emails.emails WHERE id='$id'";

$stmt = sqlsrv_query( $connection, $sql );

if( $stmt === false) {

die( print_r( sqlsrv_errors(), true) );
}


while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    $state = $row['state'];
    $func = $row['id_func_emails'];
}

$sql2 = "SELECT * FROM emails.funcionario WHERE username='$IDFuncEstadox'";
//$stmt = sqlsrv_prepare($connection, $sql2);

$stmt = sqlsrv_query( $connection, $sql2);

    if( $stmt === false) {
            echo("morreu segundo if");
        die( print_r( sqlsrv_errors(), true) );
                        }

//echo("</br>");
//echo("2 Parte");

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    $tipo = $row['Tipo_Funcionario'];
}
$myparams['tres'] = 3;
$params = array(
                                 array(&$myparams['id'], SQLSRV_PARAM_IN),
                                 array(&$myparams['tres'], SQLSRV_PARAM_IN),
                                 array(&$myparams['IDFuncEstadox'], SQLSRV_PARAM_IN)
                               );
if($state == 1)
 {
    if($func == $IDFuncEstadox)
         {
            $sql2 = "{call emails.inserirhistoricoestados(?,?,?)}";
             echo "Sucesso";
                $stmt = sqlsrv_prepare($connection, $sql2, $params);

                if( sqlsrv_execute( $stmt ) === false ) {
                          die( print_r( sqlsrv_errors(), true));
                }

                $row = sqlsrv_fetch_array($stmt);
                echo "Sucesso";
                                 //   echo("==> inserir");

         }
         else if($tipo == 3)
            {
            $sql2 = "{call emails.inserirhistoricoestados(?,?,?)}";
                     $stmt = sqlsrv_prepare($connection, $sql2, $params);

                     if( sqlsrv_execute( $stmt ) === false ) {
                               die( print_r( sqlsrv_errors(), true));
                     }

                     $row = sqlsrv_fetch_array($stmt);
                     echo "Sucesso";
            }

        else if($state != 3 && $state != 4)
            {

            $sql2 = "{call emails.inserirhistoricoestados(?,?,?)}";
                     $stmt = sqlsrv_prepare($connection, $sql2, $params);

                     if( sqlsrv_execute( $stmt ) === false ) {
                               die( print_r( sqlsrv_errors(), true));
                     }
                     $row = sqlsrv_fetch_array($stmt);
                     echo ("Sucesso 2");

         }
        else
        {
         header("HTTP/1.0 404 Not Found");
         header('HTTP', true, 500);
        }
 }
 if($state == 2)
 {
 if($func == $IDFuncEstadox)
 {

 $sql2 = "{call emails.inserirhistoricoestados(?,?,?)}";
                 $stmt = sqlsrv_prepare($connection, $sql2, $params);

                 if( sqlsrv_execute( $stmt ) === false ) {
                           die( print_r( sqlsrv_errors(), true));
                 }

                 $row = sqlsrv_fetch_array($stmt);
                 echo "Sucesso 22";
 }
 else if($tipo == 3)
 {

     $sql2 = "{call emails.inserirhistoricoestados(?,?,?)}";
                     $stmt = sqlsrv_prepare($connection, $sql2, $params);

                     if( sqlsrv_execute( $stmt ) === false ) {
                               die( print_r( sqlsrv_errors(), true));
                     }

                     $row = sqlsrv_fetch_array($stmt);
                        echo "Sucesso 3";
 }
 else if($state != 3 && $state != 4)
 {

     $sql2 = "{call emails.inserirhistoricoestados(?,?,?)}";
                     $stmt = sqlsrv_prepare($connection, $sql2, $params);

                     if( sqlsrv_execute( $stmt ) === false ) {
                               die( print_r( sqlsrv_errors(), true));
                     }

                     $row = sqlsrv_fetch_array($stmt);
                     echo "Sucesso != 3 e 4";

 }
 else
 {
     header("HTTP/1.0 404 Not Found");
     header('HTTP', true, 500);
 }
 }

 if($state == 3)
 {
     //echo ('Estado 3!!');
    if($func == $IDFuncEstadox)
     {
         $sql2 = "{call emails.inserirhistoricoestados(?,?,?)}";
                         $stmt = sqlsrv_prepare($connection, $sql2, $params);

                         if( sqlsrv_execute( $stmt ) === false ) {
                                   die( print_r( sqlsrv_errors(), true));
                         }

                         $row = sqlsrv_fetch_array($stmt);
            echo("sucesso state= 3 e funcionario= func atribuido");
    }
    else if($tipo == 3 || $tipo ==2)
        {

            $sql2 = "{call emails.inserirhistoricoestados(?,?,?)}";
                     $stmt = sqlsrv_prepare($connection, $sql2, $params);

                     if( sqlsrv_execute( $stmt ) === false ) {
                               die( print_r( sqlsrv_errors(), true));
                     }

                     $row = sqlsrv_fetch_array($stmt);
                     echo "Sucesso ";
         }

 else if($state != 3     && $state != 4)
 {

     $sql2 = "{call emails.inserirhistoricoestados(?,?,?)}";
                     $stmt = sqlsrv_prepare($connection, $sql2, $params);

                     if( sqlsrv_execute( $stmt ) === false ) {
                               die( print_r( sqlsrv_errors(), true));
                     }

                     $row = sqlsrv_fetch_array($stmt);
                     echo "Sucesso";
 }
 else
 {
     header("HTTP/1.0 404 Not Found");
     header('HTTP', true, 500);
 }
 }
 if($state == 4)
   {
   if($func == $IDFuncEstadox)
   {
       echo "Sucesso";
   }
   else if($tipo == 3 || $tipo == 2)
   {
           echo "Sucesso";
   }
   else if($state != 3 && $state != 4)
   {

       echo "Sucesso";
   }
   else
   {
       header("HTTP/1.0 404 Not Found");
       header('HTTP', true, 500);
   }
   }
if($state == 5)
     {
        if($func == $IDFuncEstadox)
            {
            echo "Sucesso";
            }
        else if($tipo == 3)
            {
                 echo "Sucesso";
             }
     else if($state != 3 && $state != 4)
     {
         //$insere = mysqli_query($mysqli, "UPDATE emails SET state=3 WHERE id='$id'");
         echo "Sucesso";

     }
     else
     {
         header("HTTP/1.0 404 Not Found");
         header('HTTP', true, 500);
     }
     }
     if($state == 6)
      {
          if($func == $IDFuncEstadox)
      {

         $sql2 = "{call emails.inserirhistoricoestados(?,?,?)}";
                      $stmt = sqlsrv_prepare($connection, $sql2, $params);

                      if( sqlsrv_execute( $stmt ) === false ) {
                                die( print_r( sqlsrv_errors(), true));
                      }

                      $row = sqlsrv_fetch_array($stmt);
                      echo "Sucesso";
      }
      else if($tipo == 3)
      {
          $sql2 = "{call emails.inserirhistoricoestados(?,?,?)}";
                          $stmt = sqlsrv_prepare($connection, $sql2, $params);

                          if( sqlsrv_execute( $stmt ) === false ) {
                                    die( print_r( sqlsrv_errors(), true));
                          }

                          $row = sqlsrv_fetch_array($stmt);
                          echo "Sucesso";
      }
      else if($state != 3 && $state != 4)
      {
          //$insere = mysqli_query($mysqli, "UPDATE emails SET state=3 WHERE id='$id'");

          $sql2 = "{call emails.inserirhistoricoestados(?,?,?)}";
                          $stmt = sqlsrv_prepare($connection, $sql2, $params);

                          if( sqlsrv_execute( $stmt ) === false ) {
                                    die( print_r( sqlsrv_errors(), true));
                          }

                          $row = sqlsrv_fetch_array($stmt);
                          echo "Sucesso";

      }
      else
      {
          header("HTTP/1.0 404 Not Found");
          header('HTTP', true, 500);
      }
      }
?>