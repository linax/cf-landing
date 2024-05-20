<?php



require_once 'config.php';



$id_lugar = $_POST['id_lugar'];

$id_datos_lugar = "por_defecto";

$direccion = "por_defecto";

$telefono = "por_defecto";

$email = "por_defecto";

$imagen = "por_defecto";

$comentarios_extra = "por_defecto";

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
$mysqli->set_charset("utf8");

$sql = "select id_datos_lugar from Lugar where id_lugar = '$id_lugar'";

if($res = $mysqli->query($sql)){

    while($row=$res->fetch_assoc()){

                $id_datos_lugar = $row['id_datos_lugar'];

                $sql_datos = "SELECT direccion, telefono, email, imagen, comentarios_extra FROM Datos_lugar WHERE id_datos_lugar = '$id_datos_lugar'";

                if($res_datos = $mysqli->query($sql_datos)){

                    while($row_datos =$res_datos->fetch_assoc()){

                        $direccion = $row_datos['direccion'];

                        $telefono = $row_datos['telefono'];

                        $email = $row_datos['email'];

                        $imagen = $row_datos['imagen'];

                        $comentarios_extra = $row_datos['comentarios_extra'];

                    }

                }else{
                    echo "holi";
                }

                $data= array("direccion"=>$direccion,"telefono"=>$telefono,"email"=>$email, "imagen"=>$imagen, "comentarios_extra"=>$comentarios_extra);

                $lugar[] = $data;

    }



    $lugar_especifico = array("lugar_especifico"=>$lugar);



    echo json_encode($lugar_especifico);

    //echo "<pre>";

    //print_r($lugares);

}





?>

