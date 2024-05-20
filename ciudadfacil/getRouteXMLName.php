<?php







require_once 'config.php';



$id_ruta = $_POST['route_id'];



$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);



$sql = "select archivo_xml from Ruta where id_ruta = '$id_ruta'";



if($res = $mysqli->query($sql)){



    while($row=$res->fetch_assoc()){



                $archivo_xml = $row['archivo_xml'];



    }



    echo ($archivo_xml);



}







?>















