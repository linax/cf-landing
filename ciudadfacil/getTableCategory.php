<?php

require_once 'config.php';

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
$mysqli->set_charset("utf8");

$sql = "SELECT * FROM Categoria";

if($res = $mysqli->query($sql)){

    while($row=$res->fetch_assoc()){

                $id_categoria = $row['id_categoria'];

                $nombre_categoria = $row['nombre_categoria'];


                $data= array("id_categoria"=>$id_categoria,"nombre_categoria"=>$nombre_categoria);

                $categoria[] = $data;

    }

    $categorias = array("categorias"=>$categoria);

    echo json_encode($categorias);

    //echo "<pre>";

    //print_r($categorias);

}

?>