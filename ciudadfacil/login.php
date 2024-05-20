<?php



require_once 'config.php';

$dbhandle = mysql_connect($DB_HOST, $DB_USER, $DB_PASS) or die("Unable to connect to MySQL");

mysql_select_db($DB_NAME,$dbhandle) or die("Could not select ".$DB_NAME);

$dbhandle = mysql_connect($DB_HOST, $DB_USER, $DB_PASS) or die("Unable to connect to MySQL");

mysql_select_db($DB_NAME,$dbhandle) or die("Could not select ".$DB_NAME);

function startTransaction()

{
    mysql_query("START TRANSACTION");
}

function breakTransaction($str = "")
{
    
    mysql_query("ROLLBACK");
}

function commitTransaction()

{
    mysql_query("COMMIT");
}

function storeUser($email, $uname, $password) {

    startTransaction();

    $hash = hashSSHA($password);
    $encrypted_password = $hash["encrypted"]; // encrypted password
    $salt = $hash["salt"]; // salt
    $sql = "INSERT INTO Usuario(usuario, password, salt, email, fecha_creacion)
                              VALUES(UPPER('$uname'),'$encrypted_password', '$salt', '$email',  NOW())";
    $query_add_user = mysql_query($sql) or die( breakTransaction() );
    
    $sql = "select * from Usuario where email = '$email'";
    $query_get_user = mysql_query($sql)  or die( breakTransaction() );;
    $line = mysql_fetch_array($query_get_user, MYSQL_ASSOC);
    commitTransaction();
    
    return $line;

}

function getUserByEmailAndPassword($email, $password, $type) {

    if($type === 'email'){
      $result = mysql_query("SELECT * FROM Usuario WHERE email = '$email'") or die(mysql_error());
    }else{
      $result = mysql_query("SELECT * FROM Usuario WHERE UPPER(usuario) = UPPER('$email')") or die(mysql_error());
    }
    
    // check for result
    $no_of_rows = mysql_num_rows($result);
    if ($no_of_rows > 0) {
        $result = mysql_fetch_array($result);
        $salt = $result['salt'];
        $encrypted_password = $result['password'];
        $hash = checkhashSSHA($salt, $password);
        // check for password equality
        if ($encrypted_password == $hash) {
            // user authentication details are correct
            return $result;
        }
    } else {
        // user not found
        return false;
    }
}


/**
 * Encrypting password
 * returns salt and encrypted password
 */

function hashSSHA($password) {

    $salt = sha1(rand());

    $salt = substr($salt, 0, 10);

    $encrypted = base64_encode(sha1($password . $salt, true) . $salt);

    $hash = array("salt" => $salt, "encrypted" => $encrypted);

    return $hash;

}

/**
 * Decrypting password
 * returns hash string
 */

function checkhashSSHA($salt, $password) {

    $hash = base64_encode(sha1($password . $salt, true).$salt);

    return $hash;

}



/**
 * Checks whether the email is valid or fake
 */

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
         echo "local part length exceeded";
         $isValid = false;
      }
      else if ($domainLen < 1 || $domainLen > 255)
      {
         echo "domain part length exceeded";
         $isValid = false;

      }

      else if ($local[0] == '.' || $local[$localLen-1] == '.')

      {

         echo "local part starts or ends with '.'";

         $isValid = false;

      }

      else if (preg_match('/\.\./', $local))

      {

         echo "local part has two consecutive dots";

         $isValid = false;

      }else if (!preg_match('/^[A-Za-z0-9\-\.]+$/', $domain)){
         echo "character not valid in domain part";
         $isValid = false;
      }else if (preg_match('/\.\./', $domain)){
         echo "domain part has two consecutive dots";
         $isValid = false;
      }else if (!preg_match("/^(\\.|[A-Za-z0-9!#%&`_=\/$'*+?^{}|~.-])+$/",str_replace("\\","",$local))){
         echo "character not valid in local part unless local part is quoted";
         if (!preg_match('/^"(\\"|[^"])+"$/',
             str_replace("\\","",$local)))
         {
            $isValid = false;
         }
      }

   }
   echo $isValid;
   return $isValid;
}



/**
 * Check user is existed or not
 */

function emailExists($email){

    $result = mysql_query("SELECT email from Usuario WHERE UPPER(email) = UPPER('$email')");

    $no_of_rows = mysql_num_rows($result);

    if ($no_of_rows > 0) {

        // user existed

        return true;

    } else {

        // user not existed

        return false;

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

$tag = $_POST['tag'];

$uname = $_POST['uname'];

$uemail = $_POST['uemail'];

$upwd = $_POST['upwd'];



if (isset($tag) && $tag != '') {

    // Get tag

    $tag = $tag;

    // Include Database handler

      //require_once 'include/DB_Functions.php';

      //$db = new DB_Functions();

    // response Array

    //$response = array("tag" => $tag, "success" => 0, "error" => 0);

    // check for tag type

    if ($tag == 'login') {

        // Request type is check Login

        $email = $uemail;
        $type = "";
        if (strpos($email,'@') !== false) {
            $type = 'email';
        }else{
            $type = 'username';
        }

        $password = $upwd;

        // check for user

        $user = getUserByEmailAndPassword($email, $password, $type);

        if ($user != false) {

            // user found

            // echo json with success = 1

            $res_status = 1;

            $res_user_id = $user["id_usuario"];

            $res_username = $user["usuario"];

            /*$response["user"]["uid"] = $user["unique_id"];

            $response["user"]["created_at"] = $user["created_at"];*/

            echo json_encode($res_status."|".$res_user_id."|".$res_username);

        } else {

            // user not found

            // echo json with error = 1

            $response = 2;

            //$response = "Incorrect email or password!";

            echo json_encode($response);

        }

    }else if ($tag == 'register') {

        // Request type is Register new user

        $email = $_POST['uemail'];
        $uname = $_POST['uname'];
        $password = $_POST['upwd'];
        $subject = "Registro exitoso en Ciudad Fácil!";
        $message = "Bienvenido a la comunidad de Ciudad Fácil!\nTu registro en la aplicación ha sido exitoso!\nTus datos para registro son los siguientes:\nCorreo electrónico: ".$email."\nUsuario: ".$uname."\nContraseña: ".$password."\nSaludos, \nAdmin Ciudad Fácil.";
        $from = "no-reply@ciudadfacil.cl";
        $headers = "From:" . $from;
        // check if user is already existed
        if (usernameExists($uname)) {
            // user is already existed - error response
            $response = 2.1;
            //$response["error_msg"] = "ya existe email";
            echo json_encode($response);

        }else if (emailExists($email)) {
          
            $response = 2.2;
            //$response["error_msg"] = "ya existe usuario";
            echo json_encode($response);

        }else if(!validEmail($email)){
          $response = 3;
          //$response["error_msg"] = "Invalid Email Id";
          echo json_encode($response);
        }else {
            // store user
            $user = storeUser($email, $uname, $password);
            if ($user) {
                // user stored successfully
              $response = 1;
              /*$response["user"]["email"] = $user["email"];
              $response["user"]["uname"] = $user["username"];
              $response["user"]["uid"] = $user["unique_id"];*/
              mail($email,$subject,$message,$headers);
              echo json_encode($response);

            } else {

                // user failed to store

                $response = 4;

                //$response["error_msg"] = "JSON Error occured in Registartion";

                echo json_encode($response);

            }

        }

    } else {

         $response["error"] = 3;

         $response["error_msg"] = "JSON ERROR";

        echo json_encode($response);

    }

}
?>