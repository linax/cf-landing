<?php

require_once 'config.php';

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
$mysqli->set_charset("utf8");

$sql = "SELECT * FROM Datos_estacionamiento";

if($res = $mysqli->query($sql)){

    while($row=$res->fetch_assoc()){

                $id_datos_estacionamiento = $row['id_datos_estacionamiento'];

                $latitud = $row['latitud'];

                $longitud = $row['longitud'];

                $cant_est_total = $row['cant_est_total'];

                $cant_est_reservados = $row['cant_est_reservados'];

                $cumple_ordenanza = $row['cumple_ordenanza'];

                $comentarios = $row['comentarios'];

                $ev_positiva = $row['ev_positiva'];

                $ev_negativa = $row['ev_negativa'];

                $data= array("id_datos_estacionamiento"=>$id_datos_estacionamiento,
                                "latitud"=>$latitud,
                                "longitud"=>$longitud,
                                "cant_est_total"=>$cant_est_total,
                                "cant_est_reservados"=>$cant_est_reservados,
                                "cumple_ordenanza"=>$cumple_ordenanza,
                                "comentarios"=>$comentarios,
                                "ev_positiva"=>$ev_positiva,
                                "ev_negativa"=>$ev_negativa);

                $datos_estacionamiento[] = $data;

    }

    $datos_estacionamientos = array("datos_estacionamientos"=>$datos_estacionamiento);

    echo json_encode($datos_estacionamientos);

    //echo "<pre>";

    //print_r($lugares);

}

?>