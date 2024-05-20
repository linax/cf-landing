<?php

require_once 'config.php';

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
$mysqli->set_charset("utf8");

$sql = "SELECT * FROM Barrera";

if($res = $mysqli->query($sql)){

    while($row=$res->fetch_assoc()){

                $id_barrera = $row['id_barrera'];

                $id_datos_barrera = $row['id_datos_barrera'];

                $id_usuario = $row['id_usuario'];

                $fecha_creacion = $row['fecha_creacion'];

                $data= array("id_barrera"=>$id_barrera,"id_datos_barrera"=>$id_datos_barrera,"id_usuario"=>$id_usuario,"fecha_creacion"=>$fecha_creacion);

                $barrera[] = $data;

    }

    $barreras = array("barreras"=>$barrera);

    echo json_encode($barreras);

    //echo "<pre>";

    //print_r($lugares);

}

?>