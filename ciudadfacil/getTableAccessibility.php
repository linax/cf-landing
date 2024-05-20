<?php

require_once 'config.php';

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
$mysqli->set_charset("utf8");

$sql = "SELECT * FROM Accesibilidad";

if($res = $mysqli->query($sql)){

    while($row=$res->fetch_assoc()){

                $id_accesibilidad = $row['id_accesibilidad'];

                $acc_exterior = $row['acc_exterior'];

                $acc_interior = $row['acc_interior'];

                $bano = $row['bano'];

                $data= array("id_accesibilidad"=>$id_accesibilidad,
                                "acc_exterior"=>$acc_exterior,
                                "acc_interior"=>$acc_interior,
                                "bano"=>$bano);

                $accesibilidad_lugar[] = $data;

    }

    $accesibilidad_lugares = array("accesibilidad_lugares"=>$accesibilidad_lugar);

    echo json_encode($accesibilidad_lugares);

    //echo "<pre>";

    //print_r($lugares);

}

?>