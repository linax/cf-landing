<?php

require_once 'config.php';

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
$mysqli->set_charset("utf8");

$sql = "SELECT * FROM Subcategoria";

if($res = $mysqli->query($sql)){

    while($row=$res->fetch_assoc()){

                $id_subcategoria = $row['id_subcategoria'];

                $id_categoria = $row['id_categoria'];

                $nombre_subcategoria = $row['nombre_subcategoria'];

                $data= array("id_subcategoria"=>$id_subcategoria,"id_categoria"=>$id_categoria,"nombre_subcategoria"=>$nombre_subcategoria);

                $subcategoria[] = $data;

    }

    $subcategorias = array("subcategorias"=>$subcategoria);

    echo json_encode($subcategorias);

    //echo "<pre>";

    //print_r($subcategorias);

}

?>