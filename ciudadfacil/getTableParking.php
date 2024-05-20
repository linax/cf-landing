<?php

require_once 'config.php';

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
$mysqli->set_charset("utf8");

$sql = "SELECT * FROM Estacionamiento";

if($res = $mysqli->query($sql)){

    while($row=$res->fetch_assoc()){

                $id_estacionamiento = $row['id_estacionamiento'];

                $id_datos_estacionamiento = $row['id_datos_estacionamiento'];

                $id_usuario = $row['id_usuario'];

                $fecha_creacion = $row['fecha_creacion'];

                $data= array("id_estacionamiento"=>$id_estacionamiento,
                                "id_datos_estacionamiento"=>$id_datos_estacionamiento,
                                "id_usuario"=>$id_usuario,
                                "fecha_creacion"=>$fecha_creacion);

                $estacionamiento[] = $data;

    }

    $estacionamientos = array("estacionamientos"=>$estacionamiento);

    echo json_encode($estacionamientos);

    //echo "<pre>";

    //print_r($lugares);

}

?>