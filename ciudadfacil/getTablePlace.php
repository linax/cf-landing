<?php

require_once 'config.php';

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
$mysqli->set_charset("utf8");

$sql = "SELECT * FROM Lugar";

if($res = $mysqli->query($sql)){

    while($row=$res->fetch_assoc()){

                $id_lugar = $row['id_lugar'];

                $id_datos_lugar = $row['id_datos_lugar'];

                $id_accesibilidad = $row['id_accesibilidad'];

                $id_usuario = $row['id_usuario'];

                $id_subcategoria = $row['id_subcategoria'];

                $fecha_creacion = $row['fecha_creacion'];

                $data= array("id_lugar"=>$id_lugar,"id_datos_lugar"=>$id_datos_lugar,"id_accesibilidad"=>$id_accesibilidad,"id_usuario"=>$id_usuario,"id_subcategoria"=>$id_subcategoria,"fecha_creacion"=>$fecha_creacion);

                $lugar[] = $data;

    }

    $lugares = array("lugares"=>$lugar);

    echo json_encode($lugares);

    //echo "<pre>";

    //print_r($lugares);

}

?>