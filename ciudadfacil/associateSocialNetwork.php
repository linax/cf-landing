<?php    
require_once 'config.php';

$id_usuario = $_POST['userId'];
$email = $_POST['email'];
$username = $_POST['username'];
$red_social = $_POST['socialNetwork'];
$id_red_social = $_POST['socialNetworkId'];

//connection to the database
$dbhandle = mysql_connect($DB_HOST, $DB_USER, $DB_PASS) or die("Unable to connect to MySQL");

mysql_select_db($DB_NAME,$dbhandle) or die("Could not select ".$DB_NAME);
mysql_query("SET NAMES 'utf8'");

function startTransaction()
{

    mysql_query("START TRANSACTION");

}

 

function breakTransaction($str = "")
{

    $msg = "Transaccion abortada debido a un error: ".mysql_error();

    //mysql_query("ROLLBACK");

    //echo $str." ".$msg;
    echo "Ocurrio un error en la transacción";
    //die("alert(\"$str $msg\");\n");

}

 

function commitTransaction($msg)
{

    mysql_query("COMMIT");
    echo "Transaccion exitosa".$msg;
}



function associateSocialNetwork($id_usuario, $id_red_social, $red_social, $start, $msg){

    if($start){
        startTransaction();    
    }
    

    $sql = "SELECT id_usuario FROM Redes_sociales WHERE id_usuario = '$id_usuario'";
    $query_id_usuario = mysql_query($sql) or die( breakTransaction() );
    $numero_filas = mysql_num_rows($query_id_usuario);

    switch($red_social) {
        case "Facebook":
            if ($numero_filas > 0){
                $sql_update_facebook = "UPDATE Redes_sociales SET id_facebook='$id_red_social' WHERE id_usuario = '$id_usuario'";
                $query = mysql_query($sql_update_facebook) or die( breakTransaction() );
                        
            }else{
                $sql_insert_facebook = "INSERT INTO Redes_sociales(id_usuario, id_facebook) 
                   VALUES('".$id_usuario."', '".$id_red_social."')";
                $query = mysql_query($sql_insert_facebook) or die( breakTransaction() );
            }      
        
            break;
        case "Twitter": 
            if ($numero_filas > 0){
                $sql_update_twitter = "UPDATE Redes_sociales SET id_twitter='$id_red_social' WHERE id_usuario = '$id_usuario'";
                $query = mysql_query($sql_update_twitter) or die( breakTransaction() );
                        
            }else{
                $sql_insert_twitter = "INSERT INTO Redes_sociales(id_usuario, id_twitter) 
                    VALUES('".$id_usuario."', '".$id_red_social."')";
                $query = mysql_query($sql_insert_twitter) or die( breakTransaction() );
            }
            break;
        
    }

    commitTransaction($msg);

}

function createSocialNetworkAccount($username, $email, $id_red_social, $red_social, $start){

    if(!usernameExists($username) && !emailExists($email)){
        if(validEmail($email)){

            startTransaction();

            $sql = "INSERT INTO Usuario(usuario, password, salt, email, fecha_creacion)
                                  VALUES(UPPER('$username'),'NONE', 'NONE', '$email',  NOW())";
            $query_add_user = mysql_query($sql) or die( breakTransaction() );
            
            $sql = "select id_usuario from Usuario where email = '$email'";
            $query_get_user = mysql_query($sql)  or die( breakTransaction() );
            
            while ($line = mysql_fetch_array($query_get_user, MYSQL_ASSOC)) {
            
                $id_usuario = $line['id_usuario'];

            }
            $res_status = 1;
            $msg = "*".$res_status."|".$id_usuario."|".strtoupper($username);
            associateSocialNetwork($id_usuario, $id_red_social, $red_social, $start, $msg);
        }else
        {
            echo "El correo electrónico ingresado no es válido";
        }

    }else{
        echo "El Usuario y/o correo electrónico ya se encuentran en uso";
    }
    

}

function usernameExists($username){

    $result = mysql_query("SELECT usuario from Usuario WHERE UPPER(usuario) = UPPER('$username')");

    $no_of_rows = mysql_num_rows($result);

    if ($no_of_rows > 0) {

        // user existed

        return true;

    } else {

        // user not existed

        return false;

    }

}

function emailExists($email){

    $result = mysql_query("SELECT email from Usuario WHERE UPPER(email) = UPPER('$email')");

    $no_of_rows = mysql_num_rows($result);

    if ($no_of_rows > 0) {

        // email exists

        return true;

    } else {

        // email not exists

        return false;

    }

}

function validEmail($email){
   $isValid = true;
   $atIndex = strrpos($email, "@");
   if (is_bool($atIndex) && !$atIndex)
   {
      $isValid = false;
   }
   else
   {
      $domain = substr($email, $atIndex+1);
      $local = substr($email, 0, $atIndex);
      $localLen = strlen($local);
      $domainLen = strlen($domain);
      if ($localLen < 1 || $localLen > 64)
      {
         //echo "local part length exceeded";
         $isValid = false;
      }
      else if ($domainLen < 1 || $domainLen > 255)
      {
         //echo "domain part length exceeded";
         $isValid = false;

      }

      else if ($local[0] == '.' || $local[$localLen-1] == '.')

      {

         //echo "local part starts or ends with '.'";

         $isValid = false;

      }

      else if (preg_match('/\.\./', $local))

      {

         //echo "local part has two consecutive dots";

         $isValid = false;

      }else if (!preg_match('/^[A-Za-z0-9\-\.]+$/', $domain)){
         //echo "character not valid in domain part";
         $isValid = false;
      }else if (preg_match('/\.\./', $domain)){
         //echo "domain part has two consecutive dots";
         $isValid = false;
      }else if (!preg_match("/^(\\.|[A-Za-z0-9!#%&`_=\/$'*+?^{}|~.-])+$/",str_replace("\\","",$local))){
         //echo "character not valid in local part unless local part is quoted";
         if (!preg_match('/^"(\\"|[^"])+"$/',
             str_replace("\\","",$local)))
         {
            $isValid = false;
         }
      }

   }
   return $isValid;
}

if ($id_usuario != "-1"){
    
    $start = true;
    $msg = "";
    associateSocialNetwork($id_usuario, $id_red_social, $red_social, $start, $msg);

}
if($id_usuario === "-1"){
    $start = false;
    createSocialNetworkAccount($username, $email, $id_red_social, $red_social, $start);
}

















