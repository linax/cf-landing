<?php

require_once 'config.php';

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
$mysqli->set_charset("utf8");

$sql = "SELECT * FROM Datos_lugar";

if($res = $mysqli->query($sql)){

    while($row=$res->fetch_assoc()){

                $id_datos_lugar = $row['id_datos_lugar'];

                $latitud = $row['latitud'];

                $longitud = $row['longitud'];

                $titulo = $row['titulo'];

                $direccion = $row['direccion'];

                $telefono = $row['telefono'];

                $email = $row['email'];

                $imagen = $row['imagen'];

                $comentarios_extra = $row['comentarios_extra'];

                $ev_positiva = $row['ev_positiva'];

                $ev_negativa = $row['ev_negativa'];

                $data= array("id_datos_lugar"=>$id_datos_lugar,
                                "latitud"=>$latitud,
                                "longitud"=>$longitud,
                                "titulo"=>$titulo,
                                "direccion"=>$direccion,
                                "telefono"=>$telefono,
                                "email"=>$email,
                                "imagen"=>$imagen,
                                "comentarios_extra"=>$comentarios_extra,
                                "ev_positiva"=>$ev_positiva,
                                "ev_negativa"=>$ev_negativa);

                $datos_lugar[] = $data;

    }

    $datos_lugares = array("datos_lugares"=>$datos_lugar);

    echo json_encode($datos_lugares);

    //echo "<pre>";

    //print_r($lugares);

}

?>