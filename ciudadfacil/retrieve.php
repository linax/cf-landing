<?php

require_once 'config2.php';


$marcadores = array();
$sql = "select lat,lng,titulo,direccion from poi";
$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if($res = $mysqli->query($sql)){
	while($row=$res->fetch_assoc()){
                $lat = $row['lat'];
	       		$lng = $row['lng'];
	       		$titulo = $row['titulo'];
	       		$direccion = $row['direccion'];
                $data= array("lat"=>$lat,"lng"=>$lng,"titulo"=>$titulo,"direccion"=>$direccion);
                $marcador[] = $data;
	}

        $marcadores = array("marcadores"=>$marcador);

        echo json_encode($marcadores);
}


?>
