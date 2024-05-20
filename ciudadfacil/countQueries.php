<?php

require_once 'config.php';

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
$mysqli->set_charset("utf8");

//El count de accesibilidad es igual al de Lugar, y datos_lugar
//El count de barrera es igual al de datos_barrera
//El count de estacionamiento es igual al de datos_estacionamiento
$arrayTablas = ["Categoria", "Subcategoria","Lugar", "Barrera", "Estacionamiento"];

$tablesRowCount = "";

for ($i = 0; $i <= 4; $i++ ){

	$sql = "SELECT count(*) AS total FROM ".$arrayTablas[$i].";";

	if($res = $mysqli->query($sql)){

	    while($row=$res->fetch_assoc()){

	                $totalRows = $row['total'];

	    }

	    if($i == 0){
	    	$tablesRowCount = $totalRows;
	    }else{
			$tablesRowCount = $tablesRowCount.",".$totalRows;
	    }
    
	}
}

echo json_encode($tablesRowCount);

?>