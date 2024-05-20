<?php

require_once 'config.php';

$latitud = $_POST['latitud'];

$longitud = $_POST['longitud'];

$titulo = $_POST['titulo'];

$direccion = $_POST['direccion'];

if(!empty($latitud) && !empty($longitud)){
	$sql = "insert into poi(lat,lng,titulo, direccion) values(?,?,?,?)";

	$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

	$stmt = $mysqli->prepare($sql);

        $stmt->bind_param("ssss",$latitud,$longitud,$titulo,$direccion);
        $stmt->execute();
        $stmt->close();
        $mysqli->close();
}

?>
