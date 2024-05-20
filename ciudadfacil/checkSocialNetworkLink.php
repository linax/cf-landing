<?php

$red_social = $_POST['red_social'];
$id_red_social = $_POST['id_red_social'];

function getUserId($red_social, $id_red_social){
    require_once 'config.php';

    $mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

    if ($red_social === "Facebook"){

        $sql = "SELECT id_usuario FROM Redes_sociales WHERE id_facebook = '$id_red_social'";

    }elseif ($red_social === "Twitter"){

        $sql = "SELECT id_usuario FROM Redes_sociales WHERE id_twitter = '$id_red_social'";

    }

    if($res = $mysqli->query($sql)){
        if($res->num_rows > 0){

            $row=$res->fetch_assoc();
            
            $id_usuario = $row['id_usuario'];

            $sql_datos = "SELECT usuario FROM Usuario WHERE id_usuario = '$id_usuario'";
            
            if($res = $mysqli->query($sql_datos)){
                while($row=$res->fetch_assoc()){

                    $usuario = $row['usuario'];

                }
            }

            echo json_encode("1|".$id_usuario."|".$usuario);
        }
        else{
            echo "noexiste" ;
        }        
        
    }
}

getUserId($red_social, $id_red_social);