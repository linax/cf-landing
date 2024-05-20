<?php

require_once 'config.php';

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
$mysqli->set_charset("utf8");

$sql = "SELECT * FROM Datos_barrera";

if($res = $mysqli->query($sql)){

    while($row=$res->fetch_assoc()){

                $id_datos_barrera = $row['id_datos_barrera'];

                $latitud = $row['latitud'];

                $longitud = $row['longitud'];

                $tipo = $row['tipo'];

                $descripcion = $row['descripcion'];

                $imagen = $row['imagen'];

                $ev_positiva = $row['ev_positiva'];

                $ev_negativa = $row['ev_negativa'];

                $data= array("id_datos_barrera"=>$id_datos_barrera,
                                "latitud"=>$latitud,
                                "longitud"=>$longitud,
                                "tipo"=>$tipo,
                                "descripcion"=>$descripcion,
                                "imagen"=>$imagen,
                                "ev_positiva"=>$ev_positiva,
                                "ev_negativa"=>$ev_negativa);

                $datos_barrera[] = $data;

    }

    $datos_barreras = array("datos_barreras"=>$datos_barrera);

    echo json_encode($datos_barreras);

    //echo "<pre>";

    //print_r($lugares);

}

?>