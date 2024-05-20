<?php


    

require_once 'config.php';



$latitud  = $_POST['latitud'];

$longitud = $_POST['longitud'];

$tipo = $_POST['tipo'];

$descripcion = $_POST['descripcion'];

$id_usuario = $_POST['id_usuario'];

$imagen = $_POST['imagen'];

$fecha_creacion = $_POST['fecha_creacion'];

//connection to the database

$dbhandle = mysql_connect($DB_HOST, $DB_USER, $DB_PASS) or die("Unable to connect to MySQL");

mysql_select_db($DB_NAME,$dbhandle) or die("Could not select ".$DB_NAME);

mysql_query("SET NAMES 'utf8'");



function startTransaction()



    {



    mysql_query("START TRANSACTION");



    }



 



function breakTransaction($str = "")

{



    $msg = "Transaccion abortada debido a un error: ".mysql_error();



    mysql_query("ROLLBACK");



    echo json_encode($str." ".$msg);

    //die("alert(\"$str $msg\");\n");



}



 



function commitTransaction()

{



    mysql_query("COMMIT");

    echo json_encode("Transaccion exitosa"." ".$latitud);

}







function addBarrier($id_usuario, $latitud, $longitud, $tipo, $descripcion, $imagen, $fecha_creacion){

    echo json_encode($id_usuario);


    startTransaction();



    //inserto datos barrera

    $sql = "INSERT INTO Datos_barrera(latitud, longitud, tipo, descripcion, imagen) 

            VALUES('".$latitud."', '".$longitud."', '".$tipo."', '".$descripcion."', '".$imagen."')";

    $query_datos_barrera = mysql_query($sql) or die(breakTransaction());



    //saco la ID del ultimo datos_barrera

    $sql = "SELECT id_datos_barrera FROM Datos_barrera ORDER BY id_datos_barrera DESC LIMIT 1;";

    $query_datos_barrera_id = mysql_query($sql);

    $line = mysql_fetch_array($query_datos_barrera_id, MYSQL_ASSOC);

    $id_datos_barrera = "";

    foreach ($line as $col_value) {

        //echo "</br>$col_value</br>";

        $id_datos_barrera = $col_value;

    }



    $sql = "INSERT INTO Barrera(id_datos_barrera, id_usuario, fecha_creacion) 

            VALUES ('".$id_datos_barrera."', '".$id_usuario."', '".$fecha_creacion."')";

    $query_lugar = mysql_query($sql) or die(breakTransaction());



    commitTransaction();



}



addBarrier($id_usuario, $latitud, $longitud, $tipo, $descripcion, $imagen, $fecha_creacion);







































