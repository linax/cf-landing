<?php



require_once 'config.php';





$user_id = $_POST['user_id'];



$id_ruta = "por_defecto";



$origen = "por_defecto";



$destino = "por_defecto";



$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);



$sql = "select id_ruta, origen, destino from Ruta where id_usuario = '$user_id'";



if($res = $mysqli->query($sql)){



    while($row=$res->fetch_assoc()){



                $id_ruta = $row['id_ruta'];



                $origen = $row['origen'];



                $destino = $row['destino'];



                $data= array("id_ruta"=>$id_ruta,"origen"=>$origen,"destino"=>$destino);



                $ruta[] = $data;

    }



    $rutas = array("rutas"=>$ruta);



    echo json_encode($rutas);

}



?>







