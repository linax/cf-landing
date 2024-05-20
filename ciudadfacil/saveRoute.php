<?php

require_once 'config.php';

$stringRutaXML  = $_POST['stringRutaXML'];
$date = $_POST['date'];
$id_usuario = $_POST['id_usuario'];
$origen_ruta = $_POST['origen'];
$destino_ruta = $_POST['destino'];
$fecha_creacion = $_POST['fecha_creacion'];
$filename = $id_usuario.$date.".xml";
$target_path = "uploads/xml/";

$dbhandle = mysql_connect($DB_HOST, $DB_USER, $DB_PASS) or die("Unable to connect to MySQL");



mysql_select_db($DB_NAME,$dbhandle) or die("Could not select ".$DB_NAME);



function startTransaction()
{
    mysql_query("START TRANSACTION");
}

function uploadXMLFile($filename, $target_path, $stringRutaXML){
	echo "upload".$filename." ".$target_path;
	$ftp_server = "ftp.ciudadfacil.cl";
	$ftp_username   = "admin@ciudadfacil.cl";
	$ftp_password   =  "lolazo87!";
	//setup of connection
	$conn_id = ftp_connect($ftp_server) or die("could not connect to ".$ftp_server);
	// Let's make sure the file exists and is writable first.
	    // In our example we're opening $filename in append mode.
	    // The file pointer is at the bottom of the file hence
	    // that's where $somecontent will go when we fwrite() it.
	if (!$handle = fopen($target_path.$filename, 'a')) {
	     echo "Cannot open file ($filename)";
	     return "0";
	}

	// Write $somecontent to our opened file.
	if (fwrite($handle, $stringRutaXML) === FALSE) {
	    echo "Cannot write to file ($filename)";
	    return "0";
	}

	fclose($handle);
	echo "Success, wrote ($stringRutaXML) to file ($filename)";
	return "1";
	
}

function breakTransaction($str = "")
{
    //$msg = "Transaccion abortada debido a un error: ".mysql_error().;
    mysql_query("ROLLBACK");
    echo json_encode($str." "."user_id = ".$target_path);
    //die("alert(\"$str $msg\");\n");
}

function commitTransaction($filename, $target_path, $stringRutaXML)
{
	echo "commit".$filename." ".$target_path;
	$pass = uploadXMLFile($filename, $target_path, $stringRutaXML);
	$de_prueba = "1";
	if (strcmp($pass, $de_prueba) == "0"){
		mysql_query("COMMIT");
    
    	echo json_encode("Transaccion exitosa"." ".$latitud);
	}else{
		echo "error";
	}

    

}

function saveRoute($id_usuario, $origen_ruta, $destino_ruta, $filename, $target_path, $stringRutaXML, $fecha_creacion){
	echo "save".$filename." ".$target_path;
    startTransaction();
    //inserto datos barrera
    $sql = "INSERT INTO Ruta(id_usuario, origen, destino, archivo_xml, fecha_creacion) 
            VALUES('".$id_usuario."', '".$origen_ruta."', '".$destino_ruta."', '".$filename."', '".$fecha_creacion."')";

    $query_datos_barrera = mysql_query($sql) or die(breakTransaction());
	commitTransaction($filename, $target_path, $stringRutaXML);
}

saveRoute($id_usuario, $origen_ruta, $destino_ruta, $filename, $target_path, $stringRutaXML, $fecha_creacion);

?>